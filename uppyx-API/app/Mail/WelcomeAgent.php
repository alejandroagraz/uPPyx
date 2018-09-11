<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class WelcomeAgent extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $password;
    public $email;

    /**
     * WelcomeAgent constructor.
     * @param $name
     * @param $password
     * @param $email
     */
    public function __construct($name, $password, $email)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email= $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome-agent')->from(env('MAIL_USERNAME') , 'uPPyx')->subject('Bienvenido a uPPyx');
    }
}
