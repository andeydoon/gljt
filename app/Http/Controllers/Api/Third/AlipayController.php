<?php

namespace App\Http\Controllers\Api\Third;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Omnipay\Omnipay;

class AlipayController extends Controller
{
    private $alipay;

    public function __construct()
    {
        $appId = env('ALIPAY_APP_ID');
        $privateKey = env('ALIPAY_PRIVATE_KEY');
        $publicKey = env('ALIPAY_PUBLIC_KEY');
        $notifyUrl = env('ALIPAY_NOTIFY_URL');

        $this->alipay = Omnipay::create('Alipay_AopPage');
        $this->alipay->setAppId($appId);
        $this->alipay->setPrivateKey($privateKey);
        $this->alipay->setAlipayPublicKey($publicKey);
        $this->alipay->setNotifyUrl($notifyUrl);
        $this->alipay->setReturnUrl(sprintf('%s/user/publish', config('app.url')));
    }

    public function purchase(Request $request)
    {
        if (!$order = Order::where('trade_id', $request->id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该订单']);
        }

        if (($order->type == 1 && !in_array($order->status, [2, 4])) || ($order->type == 2 && !in_array($order->status, [2]))) {
            return response()->json(['status' => 'error', 'message' => '该订单不在支付流程']);
        }

        $orderAmount = $order->total;
        $orderTradeId = $order->trade_id;
        if ($order->type == 1) {
            switch ($order->status) {
                case 2:
                    $orderAmount = bcmul($order->total, $this->order_part1_ratio, 2);
                    $orderTradeId .= 'A';
                    break;
                case 4:
                    $orderAmount = bcsub($order->total, bcmul($order->total, $this->order_part1_ratio, 2), 2);
                    $orderTradeId .= 'B';
                    break;
            }
        }
        if (app()->environment('local', 'testing')) {
            $orderAmount = 0.01;
        }

        $purchase = $this->alipay->purchase();
        $purchase->setBizContent([
            'subject' => '订单-' . $order->trade_id,
            'out_trade_no' => $orderTradeId,
            'total_amount' => $orderAmount,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);
        var_dump($purchase);exit;
        $response = $purchase->send();

        return response()->json(['status' => 'success', 'data' => ['url' => $response->getRedirectUrl()]]);
    }

    public function notify(Request $request)
    {
        $completePurchase = $this->alipay->completePurchase();
        $completePurchase->setParams($request->all());

        try {
            $response = $completePurchase->send();

            if ($response->isPaid()) {
                $tradeId = $response->data('out_trade_no');

                if (strlen($tradeId) > 18) {
                    $tradeId = substr($tradeId, 0, -1);
                }

                if ($order = Order::where('trade_id', $tradeId)->first()) {

                    if (($order->type == 1 && in_array($order->status, [2, 4])) || ($order->type == 2 && in_array($order->status, [2]))) {

                        if ($order->status == 2) {
                            $order->status = 3;
                        }
                        if ($order->status == 4) {
                            $order->status = 5;
                        }
                        $order->save();
                    }


                }
                return 'success';
            } else {
                return 'fail';
            }
        } catch (\Exception $e) {
            return 'fail';
        }
    }
}
