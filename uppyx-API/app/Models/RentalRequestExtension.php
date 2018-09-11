<?php

namespace App\Models;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalRequestExtension extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_id', 'rental_request_id', 'total_days', 'total_cost', 'dropoff_address', 'dropoff_date',
        'dropoff_address_coordinates',
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
    protected $appends = ['full_dropoff_date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @param $uuid
     */
    public function setUuidAttribute($uuid) {
        if ($uuid != "") {
            $this->attributes['uuid'] = Uuid::generate(4)->string;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequest()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'rental_request_id', 'id');
    }

    /**
     * @param $rentalRequest
     * @param $data
     * @param $user
     * @return $this
     */
    public function loadData($rentalRequest, $data, $user) {
        $this->uuid = Uuid::generate(4)->string;
        $this->user_id = $user->id;
        $this->rental_request_id = $rentalRequest->id;
        $this->total_days = $data['total_days'];
        $this->total_cost = $data['total_cost'];
        $this->dropoff_address = $data['dropoff_address'];
        $this->dropoff_date = $data['dropoff_date'];
        $this->dropoff_address_coordinates = $data['dropoff_address_coordinates'];
        return $this;
    }

    /**
     * Get the request's dropoff date with timezone.
     *
     * @return string
     */
    public function getFullDropoffDateAttribute()
    {
        try {
            return (!is_null($this->rentalRequest->time_zone) && !empty($this->rentalRequest->time_zone)) ?
                Carbon::parse($this->dropoff_date)->timezone($this->rentalRequest->time_zone)->toDateTimeString() : $this->dropoff_date;
        } catch (\Exception $exception){
            return $this->dropoff_date;
        }
    }
}
