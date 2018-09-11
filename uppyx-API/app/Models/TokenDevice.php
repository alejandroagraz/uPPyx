<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TokenDevice extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'uuid', 'token_device', 'user_id', 'operative_system', 'deleted_at',
    ];

    /**
     * @param $uuid
     */
    public function setUuidAttribute($uuid)
    {
        $this->attributes['uuid'] = Uuid::generate(4);
    }

    /**
     * @param $user_id
     * @param $token_device
     */
    public function deleteTokeDevice($user_id, $token_device)
    {
        $token = TokenDevice::whereUserId($user_id)->whereTokenDevice($token_device)->first();
        if ($token) {
            $token->forceDelete();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequestUser()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequestAgent()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'taken_by_user', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequestManager()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'taken_by_manager', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequestAgentDropoff()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'taken_by_user_dropoff', 'user_id');
    }
}
