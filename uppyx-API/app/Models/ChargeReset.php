<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeReset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rental_request_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequest()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'rental_request_id', 'id');
    }
}
