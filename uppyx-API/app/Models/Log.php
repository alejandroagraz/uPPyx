<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
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
        'uuid','log_type_id','user_id','rental_request_id','rental_agencies_id','message'
    ];

    /**
     * @var array
     */
    protected $appends = ['full_created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function logTypes()
    {
        return $this->belongsTo('App\Models\LogType', 'log_type_id', 'id');
    }

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
    public function rentalAgencies()
    {
        return $this->belongsTo('App\Models\RentalAgency', 'rental_agencies_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalRequests()
    {
        return $this->belongsTo('App\Models\RentalRequest', 'rental_request_id', 'id');
    }

    /**
     * @param $rentalRequest
     * @return array
     */
    public static function getLogCreateData($rentalRequest)
    {
        $data = [
            'uuid' => Uuid::generate(4)->string,
            'log_type_id' => self::getLogTypeIdByStatus($rentalRequest->status),
            'user_id' => (count(Auth::user()) > 0) ? Auth::user()->id : $rentalRequest->user_id,
            'rental_request_id' => $rentalRequest->id,
            'rental_agencies_id' => $rentalRequest->taken_by_agency,
            'message' => $rentalRequest->status
        ];
        return $data;
    }

    /**
     * @param $status
     * @return int
     */
    public static function getLogTypeIdByStatus($status)
    {
        switch ($status) {
            case "sent":
                $logTypeName = 'sent_request';
                break;
            case "taken-manager":
                $logTypeName = 'accepted_request';
                break;
            case "taken-user":
                $logTypeName = 'took_request';
                break;
            case "on-way":
                $logTypeName = 'routed_request';
                break;
            case "checking":
                $logTypeName = 'checked_request';
                break;
            case "on-board":
                $logTypeName = 'boarded_request';
                break;
            case "taken-user-dropoff":
                $logTypeName = 'took_request';
                break;
            case "returned-car":
                $logTypeName = 'returned_request';
                break;
            case "finished":
                $logTypeName = 'finished_request';
                break;
            case "cancelled":
                $logTypeName = 'rejected_request';
                break;
            case "cancelled-app":
                $logTypeName = 'system_cancelled_request';
                break;
            case "cancelled-system":
                $logTypeName = 'system_cancelled_request';
                break;
            default:
                $logTypeName = 'uncategorized_log_request';
        }
        $logType = LogType::whereName($logTypeName)->first();
        if(count($logType) > 0) {
            $logTypeId = $logType->id;
        } else {
            $model = new LogType();
            $model->uuid = Uuid::generate(4)->string;
            $model->name = $logTypeName;
            $model->description = $logTypeName;
            $model->save();
            $logTypeId = $model->id;
        }

        return $logTypeId;

    }

    /**
     * Get the request's dropoff date with timezone.
     *
     * @return string
     */
    public function getFullCreatedAtAttribute()
    {
        try {
            if(count($this->rentalRequests) > 0){
                return (!is_null($this->rentalRequests->time_zone) && !empty($this->rentalRequests->time_zone)) ?
                    Carbon::parse($this->created_at)->timezone($this->rentalRequests->time_zone)->toDateTimeString() : $this->created_at;
            } else {
                return $this->created_at;
            }
        } catch (\Exception $exception){
            return $this->created_at;
        }

    }
}
