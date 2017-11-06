<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function parent()
    {
        return $this->belongsTo('App\Category');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function materials()
    {
        return $this->hasMany('App\Material');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
