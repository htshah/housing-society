<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlatOwned extends Model
{
    protected $table = "flat_owned";

    protected $guarded = [];

    public function bills()
    {
        return $this->hasMany('App\Billing', 'flat_id');
    }
}
