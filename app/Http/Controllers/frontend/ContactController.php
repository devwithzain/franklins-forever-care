<?php

namespace App\Http\Controllers\frontend;

use App\Mail\ContactFormMail;
use App\Mail\NewsletterSubscriptionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
   public function index(): View
   {
      return view('frontend.contact.index');
   }

   /**
    * Handle contact form submission
    */
   public function submit(Request $request): RedirectResponse
   {
      $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|max:255',
         'phone' => 'nullable|string|max:20',
         'subject' => 'required|string|max:255',
         'message' => 'required|string|min:10|max:5000',
      ]);

      try {
         // Create contact submission record
         $submission = ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => ContactSubmission::STATUS_NEW,
         ]);

         // Send email to admin
         Mail::to(config('mail.from.address', 'admin@franklinsforevercare.com'))
            ->send(new ContactFormMail($validated, $submission));

         Log::info('Contact form submitted', [
            'submission_id' => $submission->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
         ]);

         return back()->with('success', 'Thank you for contacting us! We have received your message and will get back to you soon.');
      } catch (\Exception $e) {
         Log::error('Contact form submission failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
         ]);

         return back()->with('error', 'Sorry, there was an error sending your message. Please try again later or contact us directly.');
      }
   }

   /**
    * Handle newsletter subscription
    */
   public function subscribe(Request $request): RedirectResponse
   {
      $validated = $request->validate([
         'email' => 'required|email|max:255',
         'name' => 'nullable|string|max:255',
      ]);

      try {
         // Check if already subscribed and active
         $existingSubscriber = NewsletterSubscriber::where('email', $validated['email'])
            ->active()
            ->first();

         if ($existingSubscriber) {
            return back()->with('info', 'You are already subscribed to our newsletter!');
         }

         // Create or update subscriber
         $subscriber = NewsletterSubscriber::subscribe(
            $validated['email'],
            $validated['name'] ?? null,
            [
               'ip_address' => $request->ip(),
               'user_agent' => $request->userAgent(),
            ]
         );

         // Send confirmation email only if pending (double opt-in)
         if ($subscriber->status === NewsletterSubscriber::STATUS_PENDING) {
            Mail::to($subscriber->email)
               ->send(new NewsletterSubscriptionMail($subscriber));
            
            Log::info('Newsletter subscription pending confirmation', [
               'subscriber_id' => $subscriber->id,
               'email' => $subscriber->email,
            ]);

            return back()->with('success', 'Thank you! Please check your email to confirm your subscription.');
         }

         // Auto-confirmed
         Log::info('Newsletter subscription confirmed', [
            'subscriber_id' => $subscriber->id,
            'email' => $subscriber->email,
         ]);

         return back()->with('success', 'Thank you for subscribing to our newsletter!');
      } catch (\Exception $e) {
         Log::error('Newsletter subscription failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
         ]);

         return back()->with('error', 'Sorry, there was an error processing your subscription. Please try again later.');
      }
   }
}
