<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Confirm extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $lang;

    /**
     * Confirm constructor.
     * @param $name
     * @param $email
     * @param $lang
     */
    public function __construct($name, $email, $lang)
    {
        $this->name = $name;
        $this->email = $email;
        $this->lang = $lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->lang === 'en') ? 'Confirm your uPPyx account' : 'Confirmar su cuenta uPPyx';
        return $this->view('emails.confirm')->from(env('MAIL_USERNAME') , 'uPPyx')->subject($subject);
    }
}
