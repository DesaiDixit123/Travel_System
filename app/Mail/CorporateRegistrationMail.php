<?php

namespace App\Mail;

use App\Models\Corporate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorporateRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $corporate;
    public $generatedPassword;

    public function __construct($corporate, $generatedPassword)
    {
        $this->corporate = $corporate;
        $this->generatedPassword = $generatedPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to Corporate Portal')
                    ->markdown('emails.corporate.registration', [
                        'corporate' => $this->corporate,
                        'generatedPassword' => $this->generatedPassword
                    ]);
    }
    
}
