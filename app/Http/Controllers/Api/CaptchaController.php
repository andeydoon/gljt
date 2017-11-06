<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Overtrue\EasySms\EasySms;

class CaptchaController extends Controller
{
    const SMS_SIGN_NAME = '铝行家';
    const SMS_TEMPLATE_CODE = 'SMS_94880007';

    public function sms_send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(13[0-9]|14[579]|15[0-3,5-9]|17[0135678]|18[0-9])\\d{8}$/'],
        ], [
            'mobile.required' => '手机号码不能为空',
            'mobile.regex' => '手机号码不符合规范',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $mobile = $request->mobile;

        $key = sprintf('captcha_sms_%s', $mobile);
        if (app()->environment('production') && Redis::TTL($key) > 60) {
            return response()->json(['status' => 'error', 'message' => '获取验证码过于频繁']);
        }

        $data = [];
        $code = str_pad(rand(1, 999999), 6, 0, STR_PAD_LEFT);
        if (app()->environment('local')) {
            $code = '123456';
            $data['code'] = '123456';
        }

        try {
            $config = [
                'timeout' => 5.0,
                'default' => [
                    'gateways' => [
                        'aliyun',
                    ],
                ],
                'gateways' => [
                    'aliyun' => [
                        'access_key_id' => env('ALIYUN_KEY'),
                        'access_key_secret' => env('ALIYUN_SECRET'),
                        'sign_name' => self::SMS_SIGN_NAME
                    ],
                ],
            ];
            $easySms = new EasySms($config);
            $easySms->send($mobile, [
                'template' => self::SMS_TEMPLATE_CODE,
                'data' => [
                    'code' => $code
                ],
            ]);

            Redis::SETEX($key, 120, $code);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            $message = '验证码获取失败';
            if (app()->environment('local', 'testing')) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function sms_verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^(13[0-9]|14[579]|15[0-3,5-9]|17[0135678]|18[0-9])\\d{8}$/'],
            'code' => ['required', 'captcha_sms:key,mobile'],
        ], [
            'mobile.required' => '手机号码不能为空',
            'mobile.regex' => '手机号码不符合规范',
            'code.required' => '验证码不能为空',
            'code.captcha_sms' => '验证码错误或过期',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $mobile = $request->mobile;

        if ($request->has('module')) {
            $module = $crypt = $request->module;
            switch ($module) {
                case 'register-master':
                    $crypt = Crypt::encrypt(sprintf('register_master_%s_%s', $mobile, time()));
                    break;
                case 'register-dealer':
                    $crypt = Crypt::encrypt(sprintf('register_dealer_%s_%s', $mobile, time()));
                    break;
            }

            return response()->json(['status' => 'success', 'data' => ['key' => $module, 'value' => $crypt]]);
        }


        return response()->json(['status' => 'success']);

    }
}
