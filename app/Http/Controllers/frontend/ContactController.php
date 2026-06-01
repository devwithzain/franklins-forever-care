<?php

namespace App\Http\Controllers\frontend;

use App\Mail\ContactFormMail;
use App\Mail\NewsletterSubscriptionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
   public function index(): View
   {
      return view('frontend.contact.index');
   }

   public function submit(Request $request)
   {
      $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|max:255',
         'phone' => 'nullable|string|max:20',
         'subject' => 'required|string|max:255',
         'message' => 'required|string|min:10',
      ]);

      try {
         // Send email to admin
         Mail::to(config('mail.from.address', 'admin@franklinsforevercare.com'))
            ->send(new ContactFormMail($validated));

         return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
      } catch (\Exception $e) {
         return back()->with('error', 'Sorry, there was an error sending your message. Please try again later.');
      }
   }

   public function subscribe(Request $request)
   {
      $validated = $request->validate([
         'email' => 'required|email|max:255',
      ]);

      try {
         // Send newsletter subscription confirmation email
         Mail::to($validated['email'])
            ->send(new NewsletterSubscriptionMail($validated['email']));

         return back()->with('success', 'Thank you for subscribing to our newsletter!');
      } catch (\Exception $e) {
         return back()->with('error', 'Sorry, there was an error processing your subscription. Please try again later.');
      }
   }
}
