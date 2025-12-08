<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct($student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->from('shielddutyweb@gmail.com', 'PLV SHIELD')
                    ->subject('Your PLV SHIELD Account Has Been Approved')
                    ->view('emails.account_approved')
                    ->with(['student' => $this->student]);
    }
}
