<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    public function province()
    {
        return $this->hasOne('App\Area', 'id', 'province_id');
    }

    public function city()
    {
        return $this->hasOne('App\Area', 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne('App\Area', 'id', 'district_id');
    }
}
