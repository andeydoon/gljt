<?php

namespace App\Http\Controllers\User;

use App\Order;
use App\OrderCustomSchemeDraft;
use App\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Krucas\Notification\Facades\Notification;
use Illuminate\Support\Facades\DB;

class OrderController extends UserController
{
    private $view_module = 'order.';

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

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', '>=', 2)->where('type', 1)->where('trade_id', $id)->first()) {
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

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', '>=', 2)->where('type', 2)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function custom_scheme_create(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 1)->where('type', 1)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        if (!$orderCustomSchemeDraft = $order->custom_scheme_draft) {
            $orderCustomSchemeDraft = new OrderCustomSchemeDraft;
            $orderCustomSchemeDraft->order_id = $order->id;
            $orderCustomSchemeDraft->order_custom_id = $order->custom->id;

            $order->custom_scheme_draft()->save($orderCustomSchemeDraft);
        }

        $data['order'] = $order;
        $data['order_custom_scheme_draft'] = $orderCustomSchemeDraft;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function service_scheme_create(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 1)->where('type', 2)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }

    public function make(Request $request, $id)
    {
        $user = auth()->user();

        $data = [];

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 3)->where('type', 1)->where('trade_id', $id)->first()) {
            Notification::error('找不到该订单');
            return redirect()->intended();
        }

        $data['order'] = $order;

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, $data);
    }
}
