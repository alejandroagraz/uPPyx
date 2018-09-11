<?php

namespace App\Jobs;

use Mail;
use App\User;
use Carbon\Carbon;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Summary as SummaryDetailEmail;

class SendSummaryEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $rentalRequest;

    /**
     * SendSummaryEmail constructor.
     * @param RentalRequest $rentalRequest
     */
    public function __construct(RentalRequest $rentalRequest)
    {
        $this->rentalRequest = $rentalRequest;
    }

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        list($pickupDate, $dropOffDate, $city, $cityId, $countryId, $discountAmount) = [
            Carbon::parse($this->rentalRequest->pickup_date)->format('Y-m-d H:i'),
            Carbon::parse($this->rentalRequest->dropoff_date)->format('Y-m-d H:i'),
            City::whereId($this->rentalRequest->city_id)->first(), 1, 1, 0];
        $this->rentalRequest = RentalRequest::whereUuid($this->rentalRequest->uuid)->with(['requestedBy', 'takenByAgency',
            'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments', 'requestCity',
            'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])->first();
        if (count($this->rentalRequest->discountCodes) > 0) {
            $discount = $this->rentalRequest->discountCodes->first();
            $discountAmount = $discount->discount_amount;
        }
        if (count($city) > 0) {
            list($cityId, $countryId) = [$city->id, (count($city->country) > 0) ? $city->country->id : 1];
        }
        $request->merge(['lang' => $request->lang, 'pickup_date' => $pickupDate, 'dropoff_date' => $dropOffDate,
            'country' => $countryId, 'city' => $cityId
        ]);
        $request->only(['lang', 'pickup_date', 'dropoff_date', 'country', 'city']);
        $response = app('App\Http\Controllers\RentalRequestController')->getSummary($request);
        list($days, $total) = [$this->rentalRequest->total_days, ($this->rentalRequest->total_cost + $discountAmount)];
        $dailyCostCar = round(($total / $days), 2);
        $data = ['days' => $days, 'daily_cost_car' => $dailyCostCar, 'total' => $total, 'sub_total' => $total,
            'tax' => 0, 'sales_tax' => 0, 'lang' => $request->lang, 'discount' => $discountAmount];
        if ($response->getStatusCode() == 200) {
            $jsonContent = json_decode($response->getContent());
            list($summaries, $summaryValue) = [$jsonContent->data, []];
            foreach ($summaries as $key => $summary) {
                list($validFrom, $validTo, $summaryCity) = [Carbon::parse($summary->valid_from),
                    Carbon::parse($summary->valid_to), $summary->city];
                if ($summary->car_classification->id == $this->rentalRequest->car_classification_id
                    && Carbon::parse($this->rentalRequest->pickup_date)->between($validFrom, $validTo) && $summaryCity == $cityId
                ) {
                    $summaryValue = $summary;
                }
            }
            if (count($summaryValue) > 0) {
                $data = ['days' => $summaryValue->days, 'daily_cost_car' => $summaryValue->daily_cost_car,
                    'total' => ($summaryValue->total - $discountAmount), 'sub_total' => ($summaryValue->subtotal - $discountAmount),
                    'tax' => $summaryValue->tax, 'sales_tax' => $summaryValue->sales_tax, 'lang' => $request->lang,
                    'discount' => $discountAmount];
            }
        }
//        Mail::to($this->rentalRequest->takenByManager->email, $this->rentalRequest->takenByManager->name)
//            ->send(new SummaryDetailEmail($data, $this->rentalRequest));
        $users = User::getManagersByAgencies($this->rentalRequest->taken_by_agency);
        if (count($users) > 0) {
            foreach ($users as $email => $name) {
                Mail::to($email, $name)->send(new SummaryDetailEmail($data, $this->rentalRequest));
            }
        }
        return;
    }
}
