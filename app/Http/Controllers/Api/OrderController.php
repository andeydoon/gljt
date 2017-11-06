<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Order;
use App\OrderCustom;
use App\OrderService;
use App\Product;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function custom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required'],
            'address_id' => ['required'],
            'quantity' => ['required', 'integer', 'between:1,255'],
            'content' => ['required'],
        ], [
            'product_id.required' => '产品不能为空',
            'address_id.required' => '地址不能为空',
            'quantity.required' => '数量不能为空',
            'quantity.integer' => '数量必须为整数',
            'quantity.between' => '数量范围在1~255',
            'content.required' => '服务内容详情不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        if (!$user->addresses()->where('id', $request->address_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => '找不到该地址']);
        }

        if (!$product = Product::where('status', 1)->where('id', $request->product_id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该产品']);
        }

        if ($product->colours()->count()) {
            if (!$request->has('product_colour_id')) {
                return response()->json(['status' => 'error', 'message' => '颜色不能为空']);
            }
            if (!$productColour = $product->colours()->where('product_colours.id', $request->product_colour_id)->first()) {
                return response()->json(['status' => 'error', 'message' => '找不到该颜色']);
            }
            $_orderPrice = bcmul($productColour->price, $request->quantity, 2);
        } else {
            $_orderPrice = bcmul($product->price, $request->quantity, 2);
        }

        try {
            DB::beginTransaction();

            $order = new Order;
            $order->trade_id = Carbon::now()->format('YmdHis') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $order->member_id = $user->id;
            $order->address_id = $request->address_id;
            $order->total = $_orderPrice;
            $order->type = Order::TYPE_CUSTOM;
            $order->quantity = $request->quantity;
            $order->save();

            $orderCustom = new OrderCustom;
            $orderCustom->product_id = $product->id;
            $orderCustom->content = $request->content;
            if ($request->has('product_colour_id'))
                $orderCustom->product_colour_id = $request->product_colour_id;

            $order->custom()->save($orderCustom);

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => '系统繁忙，请稍后再试']);
        }


    }

    public function service(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => ['required'],
            'category_id' => ['required'],
            'address_id' => ['required'],
            'scheme' => ['required_if:service_id,1'],
            'quantity' => ['required', 'integer', 'between:1,255'],
            'content' => ['required'],
        ], [
            'service_id.required' => '服务不能为空',
            'category_id.required' => '分类不能为空',
            'address_id.required' => '地址不能为空',
            'scheme.required_if' => '方案不能为空',
            'quantity.required' => '数量不能为空',
            'quantity.integer' => '数量必须为整数',
            'quantity.between' => '数量范围在1~255',
            'content.required' => '服务内容详情不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        if (!$user->addresses()->where('id', $request->address_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => '找不到该地址']);
        }

        if (!$service = Service::where('id', $request->service_id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该服务']);
        }

        if (!$category = Category::where('id', $request->category_id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该分类']);
        }

        try {
            DB::beginTransaction();

            $order = new Order;
            $order->trade_id = Carbon::now()->format('YmdHis') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $order->member_id = $user->id;
            $order->address_id = $request->address_id;
            $order->total = 0;
            $order->type = Order::TYPE_SERVICE;
            $order->quantity = $request->quantity;
            $order->save();

            $orderService = new OrderService;
            $orderService->service_id = $service->id;
            $orderService->category_id = $category->id;
            $orderService->content = $request->content;
            if ($request->has('scheme'))
                $orderService->scheme = $request->scheme;
            if ($request->has('pictures'))
                $orderService->pictures = implode(';', $request->pictures);

            $order->service()->save($orderService);

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => '系统繁忙，请稍后再试']);
        }


    }
}
