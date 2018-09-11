<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderManagerAssignAgents extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $totalRequests;

    /**
     * ReminderManagerAssignAgents constructor.
     * @param $rentalRequest
     */
    public function __construct($rentalRequest)
    {
        $this->name = $rentalRequest->takenByManager->name;
        $this->totalRequests = $rentalRequest->total_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /*$subject = ($this->lang === 'en') ? 'Pending request for assign' : 'Pendiente por asignar';*/
        $subject = 'Pending request for assign';
        return $this->view('emails.reminder-managers')->from(env('MAIL_USERNAME') , 'uPPyx')->subject($subject);
    }
}
