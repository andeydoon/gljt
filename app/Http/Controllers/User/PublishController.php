<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Krucas\Notification\Facades\Notification;

class PublishController extends UserController
{
    private $view_module = 'publish.';

    public function index(Request $request)
    {
        $type = $request->server('QUERY_STRING');
        if (!in_array($type, ['custom', 'service'])) {
            $type = 'custom';
        }

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__ . '-' . $type);
    }

    public function custom_scheme(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', '>=', 2)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function service_scheme(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', '>=', 2)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function pay(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 2)->where('type', 2)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function pay_part1(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 2)->where('type', 1)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;
        $data['pay_part1'] = bcmul($order->total, $this->order_part1_ratio, 2);

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function pay_part2(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 4)->where('type', 1)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;
        $data['pay_part1'] = bcmul($order->total, $this->order_part1_ratio, 2);
        $data['pay_part2'] = bcsub($order->total, bcmul($order->total, $this->order_part1_ratio, 2), 2);

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function comment(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        if ($order->type == 1 && $order->status != 7) {
            return response()->json(['status' => 'error', 'message' => '订单不在可操作状态']);
        }

        if ($order->type == 2 && $order->status != 3) {
            return response()->json(['status' => 'error', 'message' => '订单不在可操作状态']);
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }
}
