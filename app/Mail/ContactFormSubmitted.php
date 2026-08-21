<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $mail = $this->subject('Nuevo mensaje desde el formulario de contacto')
            ->view('emails.contact')
            ->with(['data' => $this->data]);

        if (!empty($this->data['email'])) {
            $mail->replyTo($this->data['email']);
        }

        return $mail;
    }
}
