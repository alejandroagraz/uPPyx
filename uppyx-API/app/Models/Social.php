<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'social_logins';

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
        'user_id', 'provider', 'social_id'
    ];

    /**
     * @param $uuid
     * @throws \Exception
     */
    public function setUuidAttribute($uuid) {
        $this->attributes['uuid'] = Uuid::generate(4);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $newUser
     * @param $userSocial
     * @param $data
     * @return $this
     */
    public function loadSocialData($newUser, $userSocial, $data){
        $this->uuid = "";
        $this->user_id = $newUser->id;
        $this->social_id = $userSocial->id;
        $this->provider = $data['provider'];
        return $this;
    }
}
