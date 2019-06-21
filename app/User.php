<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $table = "user";

    public function flats()
    {
        return $this->hasMany('App\FlatOwned');
    }

    public function bills()
    {
        return $this->hasManyThrough('App\Billing', 'App\FlatOwned', 'user_id', 'flat_id');
    }

    public function events()
    {
        return $this->hasMany('App\Events');
    }
}
