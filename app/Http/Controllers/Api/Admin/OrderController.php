<?php

namespace App\Http\Controllers\Api\Admin;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('member')->orderBy('created_at', 'DESC');
        switch (auth()->user()->type) {
            case User::TYPE_MASTER:
                $orders->where('master_id', auth()->user()->id);
                break;
            case User::TYPE_DEALER:
                $orders->where('dealer_id', auth()->user()->id);
                break;
        }

        return Datatables::of($orders)->make(true);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->has('status')) {
            if ($request->status > 0 && !$order->master_id) {
                return response()->json(['status' => 'error', 'message' => '未分配师傅，请先分配']);
            }

            $order->status = $request->status;
        }
        if ($request->has('dealer_id')) {
            $order->dealer_id = $request->dealer_id;
        }
        if ($request->has('master_id')) {
            if ($request->master_id > 0 && !$order->status) {
                $order->status = 1;
            }

            $order->master_id = $request->master_id;
        }

        $order->save();

        return response()->json(['status' => 'success']);

    }
}
