<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalTransaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_id', 'rental_request_id', 'type', 'amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

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
        return $this->belongsTo('App\Models\RentalRequest');
    }

    /**
     * @param $userId
     * @param $rentalRequestId
     * @param $type
     * @param $amount
     * @return $this
     */
    public function loadData($userId, $rentalRequestId, $type, $amount) {
        $this->uuid = Uuid::generate(4)->string;
        $this->user_id = $userId;
        $this->rental_request_id = $rentalRequestId;
        $this->type = $type;
        $this->amount = $amount;
        return $this;
    }
}
