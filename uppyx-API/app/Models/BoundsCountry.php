<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoundsCountry extends Model
{
    protected $fillable = [
        'latitude', 'longitude','country_id'
    ];


    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }


}
