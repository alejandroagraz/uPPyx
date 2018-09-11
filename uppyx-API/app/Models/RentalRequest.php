<?php

namespace App\Models;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalRequest extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'pickup_address', 'pickup_date', 'dropoff_address', 'dropoff_date', 'car_classification_id', 'user_id',
        'taken_by_agency', 'taken_by_user', 'taken_by_user_dropoff', 'taken_by_manager', 'total_cost', 'total_days',
        'status', 'gate' ,'pickup_address_coordinates', 'dropoff_address_coordinates', 'updated_at', 'blocked_amount',
        'city_id', 'last_agent_coordinate', 'credit_card_token', 'returned_car', 'time_zone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $appends = ['full_pickup_date', 'full_dropoff_date', 'full_created_at'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $uuid
     */
    public function setUuidAttribute($uuid)
    {
        $this->attributes['uuid'] = Uuid::generate(4)->string;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestedBy()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function takenByUser()
    {
        return $this->belongsTo('App\User', 'taken_by_user', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestCity()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function takenByAgency()
    {
        return $this->belongsTo('App\Models\RentalAgency', 'taken_by_agency', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function takenByManager()
    {
        return $this->belongsTo('App\User', 'taken_by_manager', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function takenByUserDropOff()
    {
        return $this->belongsTo('App\User', 'taken_by_user_dropoff', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classification()
    {
        return $this->belongsTo('App\Models\CarClassification', 'car_classification_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany('App\Models\TokenDevice', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devicesAgent()
    {
        return $this->hasMany('App\Models\TokenDevice', 'user_id', 'taken_by_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devicesManager()
    {
        return $this->hasMany('App\Models\TokenDevice', 'user_id', 'taken_by_manager');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devicesAgentDropoff()
    {
        return $this->hasMany('App\Models\TokenDevice', 'user_id', 'taken_by_user_dropoff');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cancellationRequestReasons()
    {
        return $this->hasMany('App\Models\CancellationRequestReason', 'rental_request_id', 'id');
    }

    /**
     * The discount codes that belong to the rental requests.
     */
    public function discountCodes()
    {
        return $this->belongsToMany('App\Models\DiscountCode', 'discount_code_by_request','rental_request_id', 'discount_code_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalRequestExtensions()
    {
        return $this->hasMany('App\Models\RentalRequestExtension', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalTransactions()
    {
        return $this->hasMany('App\Models\RentalTransaction', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pushLogs()
    {
        return $this->hasMany('App\Models\PushLog', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalRequestRates()
    {
        return $this->hasMany('App\Models\RentalRequestRate', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chargeResets()
    {
        return $this->hasMany('App\Models\ChargeReset', 'rental_request_id', 'id');
    }

    /**
     * @param $status
     * @return string
     */
    public static function getMessageKey($status)
    {
        switch ($status) {
            case "cancelled":
                $messageKey = "RequestCancelled";
                break;
            case "cancelled-app":
                $messageKey = "RequestCancelledForApp";
                break;
            case "cancelled-system":
                $messageKey = "RequestCancelledForSystem";
                break;
            case "taken-user":
                $messageKey = "RequestTaken";
                break;
            case "taken-manager":
                $messageKey = "RequestTaken";
                break;
            case "on-board":
                $messageKey = "RequestTaken";
                break;
            case "on-way":
                $messageKey = "RequestTaken";
                break;
            case "arrived-agent":
                $messageKey = "ArrivedAgent";
                break;
            case "checking":
                $messageKey = "RequestChecking";
                break;
            case "taken-user-dropoff":
                $messageKey = "RequestTaken";
                break;
            case "returned-car":
                $messageKey = "RequestCarReturned";
                break;
            default:
                $messageKey = "RequestNotTaken";
        }
        return $messageKey;
    }

    /**
     * @param $data
     * @param $user
     * @param $requestTypeTime
     * @return $this
     */
    public function loadCreateData($data, $user, $requestTypeTime) {
        $this->uuid = '';
        $this->user_id = $user->id;
        $this->status = 'sent';
        $this->blocked_amount = $data['total_cost'];
        $this->credit_card_token = $data['credit_card_id'];
        $this->time_zone = (!isset($data['time_zone'])) ? 'America/New_York' : $data['time_zone'];
        $this->type = (Carbon::now()->diffInHours(Carbon::parse($data['pickup_date'])) < $requestTypeTime) ?
            'standard' : 'planned';
        return $this;
    }

    /**
     * Get the request's pickup date with timezone.
     *
     * @return string
     */

    public function getFullPickupDateAttribute()
    {
        try {
            return (!is_null($this->time_zone) && !empty($this->time_zone))
                ? Carbon::parse($this->pickup_date)->timezone($this->time_zone)->toDateTimeString() : $this->pickup_date;
        } catch (\Exception $exception){
            return $this->pickup_date;
        }

    }

    /**
     * Get the request's dropoff date with timezone.
     *
     * @return string
     */
    public function getFullDropoffDateAttribute()
    {
        try {
            return (!is_null($this->time_zone) && !empty($this->time_zone)) ?
                Carbon::parse($this->dropoff_date)->timezone($this->time_zone)->toDateTimeString() : $this->dropoff_date;
        } catch (\Exception $exception){
            return $this->dropoff_date;
        }

    }

    /**
     * Get the request's dropoff date with timezone.
     *
     * @return string
     */
    public function getFullCreatedAtAttribute()
    {
        try {
            return (!is_null($this->time_zone) && !empty($this->time_zone)) ?
                Carbon::parse($this->created_at)->timezone($this->time_zone)->toDateTimeString() : $this->created_at;
        } catch (\Exception $exception){
            return $this->created_at;
        }

    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getTimeZoneAttribute($value)
    {
        return (!is_null($value)) ? $value : 'America/New_York';
    }

}
