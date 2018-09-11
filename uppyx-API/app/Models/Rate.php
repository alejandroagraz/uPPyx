<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valid_from', 'valid_to', 'days_from', 'days_to', 'amount', 'country_id', 'city_id', 'car_classification_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryRate()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cityRate()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carRate()
    {
        return $this->belongsTo('App\Models\CarClassification', 'car_classification_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carClassification()
    {
        return $this->belongsTo('App\Models\CarClassification', 'car_classification_id', 'id');
    }

}
