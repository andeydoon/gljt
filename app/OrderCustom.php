<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCustom extends Model
{
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function product_colour()
    {
        return $this->belongsTo('App\ProductColour');
    }

    public function express()
    {
        return $this->hasOne('App\OrderCustomExpress', 'order_custom_id');
    }

    public function make()
    {
        return $this->hasOne('App\OrderCustomMake', 'order_custom_id');
    }
}
