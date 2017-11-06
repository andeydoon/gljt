<?php

namespace App\Providers;

use App\Notifications\SystemMessage;
use App\Order;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $statuses = [1 => ['等待接单', '等待测量', '待付定金', '等待制作', '待付尾款', '等待发货', '等待收货', '等待安装', '订单完成', 101 => '订单取消'], 2 => ['等待接单', '等待上门', '等待付款', '等待服务', '订单完成', 101 => '订单取消']];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('captcha_sms', function ($attribute, $value, $parameters, $validator) {

            switch ($parameters[0]) {
                case 'key':
                    $mobile = request()->input($parameters[1]);
                    break;
                case 'value':
                    $mobile = $parameters[1];
                    break;
            }

            $key = sprintf('captcha_sms_%s', $mobile);
            $code = Redis::GET($key);
            if ($code == $value) {
                Redis::DEL($key);
                return true;
            }

            return false;
        });

        Order::updated(function ($order) {
            $message = ['content' => sprintf('您的订单<strong>%s</strong>已更新，目前状态为<strong>%s</strong>。', $order->trade_id, $this->statuses[$order->type][$order->status])];
            $order->member->notify(new SystemMessage($message));
            if ($order->master) {
                $order->master->notify(new SystemMessage($message));
            }
            if ($order->dealer) {
                $order->dealer->notify(new SystemMessage($message));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
