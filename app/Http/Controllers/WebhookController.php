<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            \Log::error('Stripe webhook validation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        match ($event->type) {
            'invoice.payment_succeeded'      => $this->handlePaymentSucceeded($event->data->object),
            'invoice.payment_failed'         => $this->handlePaymentFailed($event->data->object),
            'customer.subscription.deleted'  => $this->handleSubscriptionCancelled($event->data->object),
            default                          => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentSucceeded($invoice): void
    {
        $booking = ServiceBooking::where('stripe_subscription_id', $invoice->subscription)->first();
        if ($booking) {
            $booking->update([
                'payment_status'      => 'paid',
                'subscription_status' => 'active',
            ]);
        }
    }

    private function handlePaymentFailed($invoice): void
    {
        $booking = ServiceBooking::where('stripe_subscription_id', $invoice->subscription)->first();
        if ($booking) {
            $booking->update([
                'payment_status'      => 'failed',
                'subscription_status' => 'past_due',
            ]);
        }
    }

    private function handleSubscriptionCancelled($subscription): void
    {
        $booking = ServiceBooking::where('stripe_subscription_id', $subscription->id)->first();
        if ($booking) {
            $booking->update(['subscription_status' => 'cancelled']);
        }
    }
}
