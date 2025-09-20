<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $customerEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp, $customerEmail)
    {
        $this->otp = $otp;
        $this->customerEmail = $customerEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.otp')
                    ->subject('Your One-Time Password (OTP)');
    }
}
