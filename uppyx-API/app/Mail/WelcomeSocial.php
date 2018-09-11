<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeSocial extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $lang;

    /**
     * WelcomeSocial constructor.
     * @param $name
     * @param $email
     * @param $lang
     */
    public function __construct($name, $email, $lang)
    {
        $this->name = $name;
        $this->email= $email;
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
        return $this->view('emails.welcome-social')->from(env('MAIL_USERNAME') , 'uPPyx')->subject($subject);
    }
}
