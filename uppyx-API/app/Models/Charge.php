<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'city_id', 'car_classification_id'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function car()
    {
        return $this->belongsTo('App\Models\CarClassification', 'car_classification_id', 'id');
    }

    public function configuration()
    {
        return $this->belongsTo('App\Models\Configuration', 'configuration_id', 'id');
    }
}