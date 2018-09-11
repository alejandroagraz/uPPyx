<?php

namespace App\Models;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "discount_codes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'code', 'active', 'discount_operation', 'discount_amount', 'num_uses', 'expiry'
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
    public function setUuidAttribute()
    {
        $this->attributes['uuid'] = Uuid::generate(4);
    }

    /**
     * The rental requests that belong to the discount codes.
     */
    public function rentalRequests()
    {
        return $this->belongsToMany('App\Models\RentalRequest', 'discount_code_by_request', 'discount_code_id', 'rental_request_id');
    }

    /**
     * @return array
     */
    public static  function getCreateData(){
        return [
            'uuid' => Uuid::generate(4)->string,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
    }


}
