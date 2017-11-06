<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const TYPE_CUSTOM = 1;
    const TYPE_SERVICE = 2;

    //type 1
    //status 0-发布需求 1-师傅接单 2-上门测量 3-付定金 4-厂家制作 5-付尾款 6-发货 7-收货 8-上门安装 9-安装完毕 101-用户取消


    //type 2
    //status 0-发布需求 1-师傅接单 2-上门查看 3-付款 4-确认服务 101-用户取消

    public function member()
    {
        return $this->belongsTo('App\User');
    }

    public function master()
    {
        return $this->belongsTo('App\User');
    }

    public function dealer()
    {
        return $this->belongsTo('App\User');
    }

    public function custom()
    {
        return $this->hasOne('App\OrderCustom');
    }

    public function service()
    {
        return $this->hasOne('App\OrderService');
    }

    public function address()
    {
        return $this->belongsTo('App\UserAddress');
    }

    public function comment()
    {
        return $this->hasOne('App\OrderComment');
    }

    public function custom_scheme()
    {
        return $this->hasOne('App\OrderCustomScheme');
    }

    public function custom_scheme_draft()
    {
        return $this->hasOne('App\OrderCustomSchemeDraft');
    }

    public function service_scheme()
    {
        return $this->hasOne('App\OrderServiceScheme');
    }
}
