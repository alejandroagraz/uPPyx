<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Activate extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $lang;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $lang
     */
    public function __construct($name,$lang)
    {
        $this->name = $name;
        $this->lang = $lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->lang === 'en') ? 'Welcome to uPPyx' : 'Bienvenido a uPPyx';
        return $this->view('emails.activate')->from(env('MAIL_USERNAME') , 'uPPyx')->subject($subject);
    }
}
