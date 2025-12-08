<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DutyCertificate extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $duty;
    public $certificatePath;
    public $downloadUrl;

    public function __construct($participant, $duty, $certificatePath, $downloadUrl = null)
    {
        $this->participant = $participant;
        $this->duty = $duty;
        $this->certificatePath = $certificatePath;
        $this->downloadUrl = $downloadUrl;
    }

    public function build()
    {
        $mail = $this->from('shielddutyweb@gmail.com', 'PLV SHIELD')
                    ->subject('Your Duty Certificate - PLV SHIELD')
                    ->view('emails.duty_certificate')
                    ->with([
                        'participant' => $this->participant,
                        'duty' => $this->duty,
                        'downloadUrl' => $this->downloadUrl,
                    ])
                    ->attach($this->certificatePath, [
                        'as' => 'Duty_Certificate_' . $this->participant->participant_id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);

        return $mail;
    }
}
