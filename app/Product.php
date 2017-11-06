<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function material()
    {
        return $this->belongsTo('App\Material');
    }

    public function colours()
    {
        return $this->hasMany('App\ProductColour');
    }

    public function attributes()
    {
        return $this->hasMany('App\ProductAttribute');
    }

    public function galleries()
    {
        return $this->hasMany('App\ProductGallery');
    }

    public function favorites()
    {
        return $this->hasMany('App\UserFavorite', 'related_id')->where('type', 1);
    }

    public function parameters()
    {
        return $this->hasMany('App\ProductParameter');
    }

    public function comments()
    {
        return $this->hasMany('App\OrderComment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
