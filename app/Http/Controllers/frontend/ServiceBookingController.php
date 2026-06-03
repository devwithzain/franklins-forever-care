<?php

namespace App\Http\Controllers\frontend;

use Stripe\Stripe;
use Stripe\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Client;
use Stripe\Subscription;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class ServiceBookingController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function checkout($slug, Request $request)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $planSlug = $request->query('plan');

        $package = Package::whereRaw(
            'LOWER(REPLACE(name, " ", "")) = ?',
            [$planSlug]
        )->first();

        return view('frontend.checkout.checkout', compact('service', 'package', 'planSlug'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'plan_type' => 'required|string',
            'patient_name' => 'required|string|max:255',
            'patient_age' => 'required|string|max:10',
            'relationship' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'preferred_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'payment_method_id' => 'required|string',
        ]);

        $package = Package::whereRaw(
            'LOWER(REPLACE(name, " ", "")) = ?',
            [$validated['plan_type']]
        )->first();

        if (!$package || $package->amount <= 0) {
            return back()->with('error', 'Invalid package. Please contact support.');
        }

        $priceMap = config('services.stripe_prices');
        $planKey = strtolower($validated['plan_type']);
        $priceId = null;

        if (str_contains($planKey, 'basic')) {
            $priceId = $priceMap['basic'] ?? null;
        } elseif (str_contains($planKey, 'standard')) {
            $priceId = $priceMap['standard'] ?? null;
        } elseif (str_contains($planKey, 'premium') || str_contains($planKey, 'advance')) {
            $priceId = $priceMap['premium'] ?? null;
        } else {
            $priceId = $priceMap[$planKey] ?? null;
        }

        if (!$priceId) {
            return back()->with('error', 'Stripe price not configured for this plan. Please contact support.');
        }

        $booking = ServiceBooking::create(array_merge($validated, [
            'amount' => $package->amount,
            'payment_status' => 'pending',
            'status' => 'pending',
            'user_id' => Auth::id(),
            'subscription_status' => 'inactive',
        ]));

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $user = Auth::user();

            // 3a. Get or create Stripe Customer
            $customerId = $this->getOrCreateStripeCustomer($user, $request->payment_method_id);

            // 3b. Attach payment method to customer
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
            $paymentMethod->attach(['customer' => $customerId]);

            // 3c. Set as default payment method
            Customer::update($customerId, [
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method_id,
                ],
            ]);

            // 3d. Create Subscription
            $subscription = Subscription::create([
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'booking_id' => $booking->id,
                    'patient_name' => $validated['patient_name'],
                ],
            ]);

            // 3e. Check payment status
            $paymentIntent = $subscription->latest_invoice->payment_intent;

            if (
                in_array($subscription->status, ['active', 'trialing']) &&
                $paymentIntent->status === 'succeeded'
            ) {
                $booking->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'stripe_customer_id' => $customerId,
                    'stripe_subscription_id' => $subscription->id,
                    'stripe_session_id' => $paymentIntent->id,
                    'subscription_status' => 'active',
                    'booking_date' => $validated['preferred_date'] ?? now(),
                ]);

                $this->createOrUpdateClient($user, $booking);

                // Create notification for admin about new unassigned booking
                $this->notificationService->notifyUnassignedBooking($booking);

                return redirect()->route('service.booking.success', ['id' => $booking->id]);
            }

            // 3D Secure / requires action
            if ($paymentIntent->status === 'requires_action') {
                return back()->with('error', 'Your bank requires additional verification. Please use a different card or contact your bank.');
            }

            $booking->update(['payment_status' => 'failed']);
            return back()->with('error', 'Payment failed. Please try again.');

        } catch (\Stripe\Exception\CardException $e) {
            $booking->update(['payment_status' => 'failed']);
            return back()->with('error', 'Card error: ' . $e->getMessage());

        } catch (\Exception $e) {
            $booking->update(['payment_status' => 'failed']);
            return back()->with('error', 'Payment error: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // CANCEL SUBSCRIPTION
    // ─────────────────────────────────────────────────────────────────
    public function cancelSubscription($id)
    {
        $booking = ServiceBooking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$booking->stripe_subscription_id) {
            return back()->with('error', 'No active subscription found.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Cancel at period end — user keeps access until billing cycle ends
            $subscription = Subscription::retrieve($booking->stripe_subscription_id);
            $subscription->cancel_at_period_end = true;
            $subscription->save();

            $booking->update([
                'subscription_status' => 'cancelled',
                'subscription_ends_at' => now()->addMonth(),
            ]);

            return back()->with('success', 'Subscription cancelled. You will retain access until the end of your billing period.');

        } catch (\Exception $e) {
            return back()->with('error', 'Could not cancel: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // SUCCESS & CANCEL PAGES
    // ─────────────────────────────────────────────────────────────────
    public function success(Request $request, $id)
    {
        $booking = ServiceBooking::findOrFail($id);
        // Using frontend.thankyou.index based on previous implementation state or guide
        if (view()->exists('frontend.thankyou.index')) {
            return view('frontend.thankyou.index', compact('booking'));
        }
        // Fallback to services success page if it exists
        return view('frontend.services.success', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $booking->update(['payment_status' => 'cancelled']);

        return redirect()->route('packages')
            ->with('error', 'Payment was cancelled. You can try again whenever you are ready.');
    }

    // ─────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────
    private function getOrCreateStripeCustomer($user, string $paymentMethodId): string
    {
        if ($user && $user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        // Require valid email for Stripe customer creation
        $email = $user?->email;
        if (!$email) {
            throw new \Exception('Valid email is required to create a Stripe customer.');
        }

        $customer = Customer::create([
            'email' => $email,
            'name' => $user?->name ?? 'Guest',
            'payment_method' => $paymentMethodId,
        ]);

        if ($user) {
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        return $customer->id;
    }

    private function createOrUpdateClient($user, ServiceBooking $booking): void
    {
        if (!$user || $user->role === 'admin')
            return;

        $user->update(['role' => 'client']);

        \App\Models\Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'client_custom_id' => 'C-' . rand(1000, 9999),
                'phone' => 'N/A',
                'region' => $booking->city . ', ' . $booking->state,
                'care_plan' => $booking->plan_type,
                'status' => 'Pending',
            ]
        );
    }
}
