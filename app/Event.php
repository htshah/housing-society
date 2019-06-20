<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "event";

    protected $guarded = [];

    public function registeredUsers()
    {
        return $this->hasManyThrough('App\User', 'App\EventRegistrant', 'event_id', 'user_id');
    }
}
