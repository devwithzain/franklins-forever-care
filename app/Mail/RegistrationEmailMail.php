<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class RegistrationEmailMail extends Mailable
{
   use Queueable, SerializesModels;

   public $name;
   public $email;
   public $subject;

   public function __construct($subject, $data)
   {
      $this->name = $data['name'];
      $this->email = $data['email'];
      $this->subject = $subject;
   }

   public function envelope(): Envelope
   {
      return new Envelope(
         subject: $this->subject,
      );
   }

   public function content(): Content
   {
      return new Content(
         view: 'email.registrationemail',
         with: [
            'name' => $this->name,
            'email' => $this->email,
         ],
      );
   }

   public function attachments(): array
   {
      return [];
   }
}
