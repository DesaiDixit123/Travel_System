<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporatePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Corporate Account Password')
                    ->view('emails.corporate-password');
    }
}
