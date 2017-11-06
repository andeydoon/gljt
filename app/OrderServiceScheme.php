<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderServiceScheme extends Model
{
    use SoftDeletes;

    public function draft()
    {
        return $this->hasOne('App\OrderServiceSchemeDraft');
    }
}
