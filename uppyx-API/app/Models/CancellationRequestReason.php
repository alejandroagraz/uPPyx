<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancellationRequestReason extends Model
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
        'uuid','user_id','rental_request_id','reason','comment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequests()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'rental_request_id', 'id');
    }

    /**
     * @param $data
     * @return array
     */
    public static function getCancellationCreateData($data)
    {
        $data = [
            'uuid' => Uuid::generate(4)->string,
            'user_id' => $data['user_id'],
            'rental_request_id' => $data['rental_request_id'],
            'reason' => $data['reason'],
            'comment' => isset($data['comment']) ? $data['comment'] : null
        ];
        return $data;
    }

}
