<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function build()
    {
        $otp = mt_rand(100000, 999999);

        // Store the OTP in the session variable named 'otp'
        Session::put('otp', $otp);
        return $this->subject('Krazy Kart Security Verification')
            ->view('emails.verify_user', ['otp' => $otp]); // Blade view file for the email content
    }
}
