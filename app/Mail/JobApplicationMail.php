<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {

        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->subject('New Job Application')
            ->view('emails.job-application');
    }
}
