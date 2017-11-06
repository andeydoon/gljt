<?php

namespace App\Http\Controllers\Api\User;

use App\Order;
use App\OrderComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PublishController extends Controller
{
    public function cancel(Request $request)
    {
        $user = $request->user();

        if (!$order = $user->member_orders()->where('trade_id', $request->id)->where('status', '<=', 2)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该订单']);
        }

        $order->status = 101;
        $order->save();

        return response()->json(['status' => 'success']);
    }

    public function take(Request $request)
    {
        $user = $request->user();

        if (!$order = $user->member_orders()->where('trade_id', $request->id)->where('status', 6)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该订单']);
        }

        $order->status = 7;
        $order->save();

        return response()->json(['status' => 'success']);
    }

    public function install(Request $request)
    {
        $user = $request->user();

        if (!$order = $user->member_orders()->where('trade_id', $request->id)->where('status', 7)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该订单']);
        }

        $order->status = 8;
        $order->save();

        return response()->json(['status' => 'success']);
    }

    public function comment(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'order' => ['required', 'exists:orders,trade_id'],
            'type' => ['required', 'in:1,2'],
            'service_score' => ['required'],
            'service_content' => ['required'],
            'product_score' => ['required_if:type,1'],
            'product_content' => ['required_if:type,1'],
            'pictures' => ['array'],
        ], [
            'order.required' => '订单不能为空',
            'order.exists' => '找不到该订单',
            'service_score.required' => '服务分数不能为空',
            'service_content.required' => '服务评价不能为空',
            'product_score.required_if' => '产品分数不能为空',
            'product_content.required_if' => '产品评价不能为空',
            'pictures.array' => '图片格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $order = Order::where('trade_id', $request->order)->first();

        if ($order->type == 1) {
            if (empty($request->product_score) || empty($request->product_content)) {
                return response()->json(['status' => 'error', 'message' => '产品的分数或评价不能为空']);
            }

            if ($order->status != 7) {
                return response()->json(['status' => 'error', 'message' => '订单不在可操作状态']);
            }
        }

        if ($order->type == 2) {
            if ($order->status != 3) {
                return response()->json(['status' => 'error', 'message' => '订单不在可操作状态']);
            }
        }

        try {
            DB::beginTransaction();

            if ($order->type == 1) {
                $order->status = 8;
            }
            if ($order->type == 2) {
                $order->status = 4;
            }
            $order->save();

            $orderComment = new OrderComment;
            $orderComment->user_id = $user->id;
            $orderComment->order_id = $order->id;
            $orderComment->service_id = $order->master->id;
            $orderComment->service_score = $request->service_score;
            $orderComment->service_content = $request->service_content;
            if ($order->type == 1) {
                $orderComment->product_id = $order->custom->product->id;
                $orderComment->product_score = $request->product_score;
                $orderComment->product_content = $request->product_content;
            }
            if ($request->has('pictures')) {
                $orderComment->pictures = implode(';', $request->pictures);
            }
            $orderComment->save();

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = '系统繁忙，请稍后再试';
            if (app()->environment('local')) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }
}
