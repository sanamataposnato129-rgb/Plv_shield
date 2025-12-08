<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $plainPassword;

    /**
     * Create a new message instance.
     */
    public function __construct($admin, $plainPassword)
    {
        $this->admin = $admin;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your admin account at PLV SHIELD')
                    ->view('emails.admin_created')
                    ->with([
                        'admin' => $this->admin,
                        'password' => $this->plainPassword,
                    ]);
    }
}
