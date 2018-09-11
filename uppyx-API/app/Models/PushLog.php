<?php

namespace App\Models;

use Auth;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushLog extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'message', 'context', 'level', 'user_id', 'token_device', 'rental_request_id', 'status', 'attempts'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequests()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'rental_request_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @param $uuid
     */
    public function setUuidAttribute($uuid)
    {
        $this->attributes['uuid'] = Uuid::generate(4)->string;
    }

    /**
     * @param $push
     * @param $device
     * @param $message
     * @param $rentalRequest
     * @return $this
     */
    public function loadCreateData($push, $device, $message, $rentalRequest)
    {
        $this->uuid = '';
        $this->message = ($push == false) ? 'Push not sent' : 'Push sent';
        $this->context = $message;
        $this->level = ($push == false) ? 'alert' : 'info';
        $this->user_id = $device->user_id;
        $this->token_device = $device->token_device;
        $this->rental_request_id = (count($rentalRequest) > 0) ? $rentalRequest->id : null;
        $this->status =  ($push == false) ? 'failed' : 'sent';
        $this->attempts = 1;
        return $this;
    }


}
