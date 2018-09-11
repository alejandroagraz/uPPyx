<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poliline extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'longitude'
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }
}
