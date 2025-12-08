<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $reason;

    public function __construct($request, $reason)
    {
        $this->request = $request;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->from('shielddutyweb@gmail.com', 'PLV SHIELD')
                    ->subject('Your PLV SHIELD Account Request Has Been Rejected')
                    ->view('emails.account_rejected')
                    ->with(['request' => $this->request, 'reason' => $this->reason]);
    }
}
