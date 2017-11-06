<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, Notifiable, SoftDeletes;

    const STATUS_VERIFY = 0;
    const STATUS_NORMAL = 1;
    const STATUS_REJECT = 2;

    const TYPE_MEMBER = 1;
    const TYPE_MASTER = 2;
    const TYPE_DEALER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\UserProfile');
    }

    public function feedback()
    {
        return $this->hasMany('App\Feedback');
    }

    public function addresses()
    {
        return $this->hasMany('App\UserAddress');
    }

    public function coins()
    {
        return $this->hasMany('App\UserCoin');
    }

    public function credits()
    {
        return $this->hasMany('App\UserCredit');
    }

    public function quotes()
    {
        return $this->hasMany('App\UserQuote');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function member_orders()
    {
        return $this->hasMany('App\Order', 'member_id');
    }

    public function master_orders()
    {
        return $this->hasMany('App\Order', 'master_id');
    }

    public function dealer_orders()
    {
        return $this->hasMany('App\Order', 'dealer_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\User', 'finder_id');
    }

    public function masters()
    {
        return $this->hasMany('App\User', 'finder_id');
    }

    public function favorites()
    {
        return $this->hasMany('App\UserFavorite');
    }

    public function cards()
    {
        return $this->hasMany('App\UserCard');
    }

}
