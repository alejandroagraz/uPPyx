<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use EntrustUserTrait;
    use Notifiable;
    use HasApiTokens;

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
        'name', 'email', 'phone', 'address', 'password', 'uuid', 'rental_agency_id', 'profile_picture', 'status',
        'license_picture', 'stripe_customer_id', 'country', 'city', 'gender', 'birth_of_date', 'default_lang',
        'facebook_id', 'facebook_profile_picture', 'google_id', 'google_profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @param $uuid
     * @throws \Exception
     */
    public function setUuidAttribute($uuid)
    {
        $this->attributes['uuid'] = Uuid::generate(4);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalAgencies()
    {
        return $this->belongsTo('App\Models\RentalAgency', 'rental_agency_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeSoftDelete($query)
    {
        return $query->whereDeletedAt(null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleUsers()
    {
        return $this->hasMany('App\Models\RoleUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany('App\Models\TokenDevice', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalRequests()
    {
        return $this->hasMany('App\Models\RentalRequest', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentRentalRequests()
    {
        return $this->hasMany('App\Models\RentalRequest', 'taken_by_user', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function managerRentalRequests()
    {
        return $this->hasMany('App\Models\RentalRequest', 'taken_by_manager', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentDropoffRentalRequests()
    {
        return $this->hasMany('App\Models\RentalRequest', 'taken_by_user_dropoff', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cancellationRequestReasons()
    {
        return $this->hasMany('App\Models\CancellationRequestReason', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialLogins()
    {
        return $this->hasMany('App\Models\Social', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalRequestExtensions()
    {
        return $this->hasMany('App\Models\RentalRequestExtension', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalTransactions()
    {
        return $this->hasMany('App\Models\RentalTransaction', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentalRequestRates()
    {
        return $this->hasMany('App\Models\RentalRequestRate', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pushLogs()
    {
        return $this->hasMany('App\Models\PushLog', 'user_id', 'id');
    }

    /**
     * @param $userSocial
     * @param $data
     * @return $this
     */
    public function loadData($userSocial, $data)
    {
        list($data['id'], $data['name'], $data['gender']) = ["", "", null];
        if (count($userSocial->user) > 0) {
            $userData = $userSocial->user;
            if (isset($userData['gender']) && !is_null($userData['gender'])) {
                $data['gender'] = ($userData['gender'] === 'male') ? 'M' : 'F';
            }
            if (isset($userData['name']) && !is_null($userData['name'])) {
                $data['name'] = $userData['name'];
            }
            if (isset($userData['id']) && !is_null($userData['id'])) {
                $data['id'] = $userData['id'];
            }
        } else {
            if (isset($userSocial->name) && !is_null($userSocial->name)) {
                $data['name'] = $userSocial->name;
            }
            if (isset($userSocial->id) && !is_null($userSocial->id)) {
                $data['id'] = $userSocial->id;
            }
        }
        if(!isset($data['avatar']) || is_null($data['avatar'])) {
            if (isset($userSocial->avatar) && !is_null($userSocial->avatar)) {
                $data['avatar'] = $userSocial->avatar;
            }
        }

        $this->uuid = "";
        $this->name = (!is_null($userSocial->name)) ? $userSocial->name : "";
        $this->email = (!is_null($userSocial->email)) ? $userSocial->email : $data['email'];
        $this->password = bcrypt(str_random(16));
        $this->default_lang = $data['lang'];
        $this->gender = $data['gender'];
        $this->phone = (isset($data['phone'])) ? $data['phone'] : null;
        $this->country = (isset($data['country'])) ? $data['country'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->birth_of_date = $data['birth_of_date'];
        if ($data['provider'] === 'facebook') {
            $this->facebook_id = $data['id'];
            $this->facebook_profile_picture = $data['avatar'];
        } elseif ($data['provider'] === 'google') {
            $this->google_id = $data['id'];
            $this->google_profile_picture = $data['avatar'];
        }
        $this->status = 1;
        return $this;
    }

    /**
     * @param $agencyId
     * @return mixed
     */
    public static function getManagersByAgencies($agencyId) {
        return User::whereRentalAgencyId($agencyId)->pluck('name', 'email');
    }

}
