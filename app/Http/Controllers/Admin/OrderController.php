<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function edit($id)
    {
        $data = [];

        $order = Order::findOrFail($id);

        $data['order'] = $order;

        if ($order->type == 1) {
            $data['dealers'] = User::where('type', '3')->where('status', User::STATUS_NORMAL)->get();
            if ($order->dealer) {
                $data['masters'] = User::where('type', '2')->where('status', User::STATUS_NORMAL)->where('finder_id', $order->dealer_id)->get();
            }
        }
        if ($order->type == 2) {
            $data['masters'] = User::where('type', '2')->where('status', User::STATUS_NORMAL)->get();
        }

        return view('admin.order.edit', $data);
    }
}
