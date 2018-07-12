<?php
namespace App\Mail;

use App\Mail\Mailer\Mailable;

class WelcomeEmail extends Mailable
{
    public function build()
    {
        return $this->subject('Test Email')
            ->view('email/welcome.twig');
    }
}
