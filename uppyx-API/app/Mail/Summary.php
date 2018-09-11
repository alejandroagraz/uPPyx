<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Summary extends Mailable
{
    use Queueable, SerializesModels;

    public $days;
    public $dailyCostCar;
    public $subTotal;
    public $tax;
    public $salesTax;
    public $total;
    public $lang;
    public $id;
    public $userName;
    public $managerName;
    public $pickupDate;
    public $dropOffDate;
    public $discount;

    /**
     * Summary constructor.
     * @param $data
     * @param $rentalRequest
     */
    public function __construct($data, $rentalRequest)
    {
        $this->days = $data['days'];
        $this->dailyCostCar = $data['daily_cost_car'];
        $this->subTotal = $data['sub_total'];
        $this->tax = $data['tax'];
        $this->salesTax = $data['sales_tax'];
        $this->total = $data['total'];
        $this->lang = $data['lang'];
        $this->discount = $data['discount'];
        $this->id = $rentalRequest->uuid;
        $this->pickupDate = $rentalRequest->full_pickup_date;
        $this->dropOffDate = $rentalRequest->full_dropoff_date;
        $this->userName = $rentalRequest->requestedBy->name;
        $this->managerName = $rentalRequest->takenByManager->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->lang == 'en') ? 'Summary Receipt' : 'Recibo Resumen';
        return $this->view('emails.summary')->from(env('MAIL_USERNAME') , 'uPPyx')->subject($subject);
    }
}
