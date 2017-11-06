<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFavorite extends Model
{
    use SoftDeletes;

    const TYPE_PRODUCT = 1;

    public function product()
    {
        return $this->belongsTo('App\Product', 'related_id');
    }
}
