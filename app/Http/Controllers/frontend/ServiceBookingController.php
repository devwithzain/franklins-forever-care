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
use Illuminate\Support\Facades\DB;
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
            'phone' => 'required|string|max:30',
        ]);

        $package = Package::whereRaw(
            'LOWER(REPLACE(name, " ", "")) = ?',
            [$validated['plan_type']]
        )->first();

        if (!$package || $package->amount <= 0) {
            return response()->json(['error' => 'Invalid package. Please contact support.'], 422);
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
            return response()->json(['error' => 'Stripe price not configured for this plan. Please contact support.'], 422);
        }

        DB::beginTransaction();

        try {
            $booking = ServiceBooking::create(array_merge(
                collect($validated)->except('phone')->toArray(),
                [
                    'amount' => $package->amount,
                    'payment_status' => 'unpaid',
                    'status' => 'pending',
                    'user_id' => Auth::id(),
                    'subscription_status' => 'incomplete',
                ]
            ));

            Stripe::setApiKey(config('services.stripe.secret'));
            $user = Auth::user();

            // Get or create Stripe Customer
            $customerId = $this->getOrCreateStripeCustomer($user, $request->payment_method_id);

            // Attach payment method to customer
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
            $paymentMethod->attach(['customer' => $customerId]);

            // Set as default payment method
            Customer::update($customerId, [
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method_id,
                ],
            ]);

            // Create Subscription
            $subscription = Subscription::create([
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'default_payment_method' => $request->payment_method_id,
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'booking_id' => $booking->id,
                    'patient_name' => $validated['patient_name'],
                ],
            ]);

            $invoice = $subscription->latest_invoice;
            if (is_string($invoice)) {
                $invoice = \Stripe\Invoice::retrieve($invoice, [
                    'expand' => ['payment_intent']
                ]);
            }
            $paymentIntent = $invoice->payment_intent;

            $booking->update([
                'stripe_customer_id' => $customerId,
                'stripe_subscription_id' => $subscription->id,
                'stripe_session_id' => $paymentIntent->id ?? null,
            ]);

            DB::commit();

            // Check if 3D Secure / SCA authentication or client-side confirmation is required
            if ($paymentIntent && in_array($paymentIntent->status, ['requires_action', 'requires_confirmation'])) {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                    'booking_id' => $booking->id,
                ]);
            }

            // If payment succeeded immediately
            if (
                in_array($subscription->status, ['active', 'trialing']) &&
                (!$paymentIntent || $paymentIntent->status === 'succeeded')
            ) {
                $this->finalizeBooking($booking, $validated, $user);

                return response()->json([
                    'requires_action' => false,
                    'redirect_url' => route('service.booking.success', ['id' => $booking->id]),
                ]);
            }

            return response()->json(['error' => 'Payment status: ' . ($paymentIntent->status ?? 'unknown')], 400);

        } catch (\Stripe\Exception\CardException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Card error: ' . $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Payment error: ' . $e->getMessage()], 500);
        }
    }

    public function confirmBooking(Request $request, $id)
    {
        $booking = ServiceBooking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $subscription = Subscription::retrieve($booking->stripe_subscription_id, [
                'expand' => ['latest_invoice.payment_intent']
            ]);

            $invoice = $subscription->latest_invoice;
            if (is_string($invoice)) {
                $invoice = \Stripe\Invoice::retrieve($invoice, [
                    'expand' => ['payment_intent']
                ]);
            }
            $paymentIntent = $invoice->payment_intent;

            if (
                in_array($subscription->status, ['active', 'trialing']) &&
                (!$paymentIntent || $paymentIntent->status === 'succeeded')
            ) {
                if ($booking->payment_status !== 'paid') {
                    $this->finalizeBooking($booking, [
                        'patient_name' => $booking->patient_name,
                        'patient_age' => $booking->patient_age,
                        'relationship' => $booking->relationship,
                        'address' => $booking->address,
                        'city' => $booking->city,
                        'state' => $booking->state,
                        'zip_code' => $booking->zip_code,
                        'plan_type' => $booking->plan_type,
                        'preferred_date' => $booking->preferred_date,
                        'phone' => $request->input('phone', 'N/A'),
                    ], Auth::user());
                }

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('service.booking.success', ['id' => $booking->id]),
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Payment authentication has not completed successfully. Status: ' . ($paymentIntent->status ?? 'unknown'),
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function portal()
    {
        $user = Auth::user();

        if (!$user || !$user->stripe_customer_id) {
            return back()->with('error', 'No active billing account found. Please subscribe to a package first.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = \Stripe\BillingPortal\Session::create([
                'customer' => $user->stripe_customer_id,
                'return_url' => route('client.dashboard'),
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Could not access billing portal: ' . $e->getMessage());
        }
    }

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

    public function success(Request $request, $id)
    {
        $booking = ServiceBooking::findOrFail($id);
        if (view()->exists('frontend.thankyou.index')) {
            return view('frontend.thankyou.index', compact('booking'));
        }
        return view('frontend.services.success', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $booking->update(['payment_status' => 'cancelled']);

        return redirect()->route('packages')
            ->with('error', 'Payment was cancelled. You can try again whenever you are ready.');
    }

    private function finalizeBooking($booking, array $validated, $user): void
    {
        $patient = \App\Models\Patient::firstOrCreate(
            [
                'user_id' => $user->id,
                'name' => $validated['patient_name'],
            ],
            [
                'age' => $validated['patient_age'],
                'relationship' => $validated['relationship'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'care_plan' => $validated['plan_type'],
            ]
        );

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'subscription_status' => 'active',
            'booking_date' => $validated['preferred_date'] ?? now(),
            'patient_id' => $patient->id,
        ]);

        $this->createOrUpdateClient($user, $booking, $validated['phone'] ?? 'N/A');

        $this->notificationService->notifyUnassignedBooking($booking);
    }

    private function getOrCreateStripeCustomer($user, string $paymentMethodId): string
    {
        if ($user && $user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

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

    private function createOrUpdateClient($user, ServiceBooking $booking, string $phone = 'N/A'): void
    {
        if (!$user || $user->role === 'admin')
            return;

        $user->update(['role' => 'client']);

        $client = \App\Models\Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'client_custom_id' => 'C-' . rand(1000, 9999),
                'phone' => $phone,
                'status' => 'Active',
            ]
        );

        if ($client->phone === 'N/A' && $phone !== 'N/A') {
            $client->update(['phone' => $phone]);
        }
    }
}
