<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App\Models
 */
class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'latitude', 'longitude'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function polilines()
    {
        return $this->hasMany('App\Models\Poliline', 'city_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bounds()
    {
        return $this->hasMany('App\Models\BoundsCountry', 'city_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany('App\Models\RentalRequest', 'city_id', 'id');
    }
}
