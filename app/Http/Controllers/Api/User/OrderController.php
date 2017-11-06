<?php

namespace App\Http\Controllers\Api\User;

use App\Order;
use App\OrderCustomExpress;
use App\OrderCustomMake;
use App\OrderCustomScheme;
use App\OrderCustomSchemeDraft;
use App\OrderServiceScheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function custom_scheme_create(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'order' => ['required', sprintf('exists:orders,trade_id,%s_id,%d,status,1,type,1', substr($this->user_types[$user->type], 0, -1), $user->id)],
            'content' => ['required'],
            'total' => ['required', 'numeric', 'between:0.01,9999999'],
            'parameters' => ['array'],
            'pictures' => ['array'],
        ], [
            'order.required' => '订单不能为空',
            'order.exists' => '找不到该订单',
            'content.required' => '方案内容不能为空',
            'total.required' => '总费用不能为空',
            'total.numeric' => '总费用格式有误',
            'total.between' => '总费用大小为0.01~9999999',
            'parameters.array' => '参数格式有误',
            'pictures.array' => '图片格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $order = Order::where('trade_id', $request->order)->first();
        $product = $order->custom->product;

        $parameters = [];
        if ($request->has('parameters')) {
            foreach ($request->parameters as $key => $value) {
                if (!$product->parameters()->where('name', $key)->exists() || empty($value)) {
                    continue;
                }
                $parameters[$key] = $value;
            }
        }

        try {
            DB::beginTransaction();

            $order->total = $request->total;
            $order->status = 2;
            $order->save();

            $orderCustomScheme = new OrderCustomScheme;
            $orderCustomScheme->order_id = $order->id;
            $orderCustomScheme->order_custom_id = $order->custom->id;
            $orderCustomScheme->content = $request->content;
            $orderCustomScheme->thickness = $request->thickness;
            $orderCustomScheme->height = $request->height;
            $orderCustomScheme->width = $request->width;
            $orderCustomScheme->parameters = serialize($parameters);
            if ($request->has('pictures')) {
                $orderCustomScheme->pictures = implode(';', $request->pictures);
            }
            $orderCustomScheme->save();

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

    public function custom_scheme_draft(Request $request)
    {
        $order = Order::where('trade_id', $request->order)->first();
        $product = $order->custom->product;

        $parameters = [];
        if ($request->has('parameters')) {
            foreach ($request->parameters as $key => $value) {
                if (!$product->parameters()->where('name', $key)->exists() || empty($value)) {
                    continue;
                }
                $parameters[$key] = $value;
            }
        }

        try {
            DB::beginTransaction();

            if (!$orderCustomSchemeDraft = $order->custom_scheme_draft) {
                $orderCustomSchemeDraft = new OrderCustomSchemeDraft;
                $orderCustomSchemeDraft->order_id = $order->id;
                $orderCustomSchemeDraft->order_custom_id = $order->custom->id;
            }
            $orderCustomSchemeDraft->content = $request->content;
            $orderCustomSchemeDraft->thickness = $request->thickness;
            $orderCustomSchemeDraft->height = $request->height;
            $orderCustomSchemeDraft->width = $request->width;
            $orderCustomSchemeDraft->total = $request->total;
            $orderCustomSchemeDraft->parameters = serialize($parameters);
            if ($request->has('pictures')) {
                $orderCustomSchemeDraft->pictures = implode(';', $request->pictures);
            }
            $orderCustomSchemeDraft->save();

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

    public function service_scheme_create(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'order' => ['required', sprintf('exists:orders,trade_id,%s_id,%d,status,1,type,2', substr($this->user_types[$user->type], 0, -1), $user->id)],
            'content' => ['required'],
            'cost_labor' => ['required', 'numeric', 'between:0,9999999'],
            'total' => ['required', 'numeric', 'between:0.01,9999999'],
            'parts' => ['array'],
            'pictures' => ['array'],
        ], [
            'order.required' => '订单不能为空',
            'order.exists' => '找不到该订单',
            'content.required' => '方案内容不能为空',
            'cost_labor.required' => '人工费用不能为空',
            'cost_labor.numeric' => '人工费用格式有误',
            'cost_labor.between' => '人工费用大小为0~9999999',
            'total.required' => '总费用不能为空',
            'total.numeric' => '总费用格式有误',
            'total.between' => '总费用大小为0.01~9999999',
            'parts.array' => '配件格式有误',
            'pictures.array' => '图片格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $parts = [];
        if ($request->has('parts')) {
            for ($i = 0; $i < count($request->parts['name']); $i++) {
                if (empty($request->parts['name'][$i]) && empty($request->parts['price'][$i]) && empty($request->parts['quantity'][$i])) {
                    continue;
                }
                if (empty($request->parts['name'][$i]) || empty($request->parts['price'][$i]) || empty($request->parts['quantity'][$i])) {
                    return response()->json(['status' => 'error', 'message' => '配件信息未完善']);
                }
                if ($request->parts['price'][$i] < 0.01 || $request->parts['price'][$i] > 9999999) {
                    return response()->json(['status' => 'error', 'message' => '颜色价格大小为0.01~9999999']);
                }

                $parts[] = ['name' => $request->parts['name'][$i], 'price' => $request->parts['price'][$i], 'quantity' => $request->parts['quantity'][$i]];
            }
        }

        try {
            DB::beginTransaction();

            $order = Order::where('trade_id', $request->order)->first();

            $order->total = $request->total;
            $order->status = 2;
            $order->save();

            $orderServiceScheme = new OrderServiceScheme;
            $orderServiceScheme->order_id = $order->id;
            $orderServiceScheme->order_service_id = $order->service->id;
            $orderServiceScheme->cost_labor = $request->cost_labor;
            $orderServiceScheme->content = $request->content;
            $orderServiceScheme->parts = serialize($parts);
            if ($request->has('pictures')) {
                $orderServiceScheme->pictures = implode(';', $request->pictures);
            }
            $orderServiceScheme->save();

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

    public function make(Request $request)
    {
        $user = $request->user();

        if (!$order = $user->{substr($this->user_types[$user->type], 0, -1) . '_orders'}()->where('status', 3)->where('trade_id', $request->order)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该订单']);
        }

        try {
            DB::beginTransaction();

            $order = Order::where('trade_id', $request->order)->first();
            $order->status = 4;
            $order->save();

            $orderCustomMake = new OrderCustomMake;
            $orderCustomMake->order_id = $order->id;
            if ($request->has('pictures')) {
                $orderCustomMake->pictures = implode(';', $request->pictures);
            }
            $order->custom->make()->save($orderCustomMake);

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

    public function send(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'order' => ['required', sprintf('exists:orders,trade_id,%s_id,%d,status,5,type,1', substr($this->user_types[$user->type], 0, -1), $user->id)],
            'company' => ['required'],
            'number' => ['required'],
        ], [
            'order.required' => '订单不能为空',
            'order.exists' => '找不到该订单',
            'company.required' => '快递公司不能为空',
            'number.required' => '快递单号不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $order = Order::where('trade_id', $request->order)->first();

            $order->status = 6;
            $order->save();

            $orderCustomExpress = new OrderCustomExpress;
            $orderCustomExpress->order_id = $order->id;
            $orderCustomExpress->order_custom_id = $order->custom->id;
            $orderCustomExpress->company = $request->company;
            $orderCustomExpress->number = $request->number;
            $orderCustomExpress->save();

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
