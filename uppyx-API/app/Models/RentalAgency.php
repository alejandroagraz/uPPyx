<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalAgency extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'phone','description', 'uuid', 'user_id', 'rental_agency_id',
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


    public function setUuidAttribute($uuid) {
        if ($uuid != "") {
            $this->attributes['uuid'] = Uuid::generate(4);
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query){
        return $query->whereStatus(1);
    }
}