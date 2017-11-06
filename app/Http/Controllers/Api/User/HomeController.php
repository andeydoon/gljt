<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'finder' => ['exists:users,public_id,type,3'],
            'mobile' => ['required', 'regex:/^(13[0-9]|14[579]|15[0-3,5-9]|17[0135678]|18[0-9])\\d{8}$/', 'unique:users,mobile'],
            'type' => ['required', 'in:MEMBER,MASTER,DEALER'],
            'password' => ['required', 'between:6,20'],
            'code' => ['required_if:type,MEMBER', 'captcha_sms:key,mobile'],
            'crypt' => ['required_if:type,MASTER,DEALER'],
            'realname' => ['required_if:type,MASTER,DEALER'],
            'card_number' => ['required_if:type,MASTER,DEALER', 'regex:/^(\d{18}$)|(^\d{17}(\d|X|x))$/'],
            'card_front' => ['required_if:type,MASTER,DEALER', 'url'],
            'card_back' => ['required_if:type,MASTER,DEALER', 'url'],
            'card_hold' => ['required_if:type,MASTER,DEALER', 'url'],
            'business_license' => ['required_if:type,DEALER', 'url'],
            'service_item' => ['required_if:type,MASTER,DEALER', 'array'],
            'service_area' => ['required_if:type,MASTER', 'array'],
        ], [
            'finder.exists' => '经销商不存在',
            'mobile.required' => '手机号码不能为空',
            'mobile.regex' => '手机号码不符合规范',
            'mobile.unique' => '手机号码已注册',
            'type.required' => '类型不能为空',
            'type.in' => '类型不符合规范',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度有误',
            'code.required_if' => '验证码不能为空',
            'code.captcha_sms' => '验证码错误或过期',
            'realname.required_if' => '真实姓名不能为空',
            'card_number.required_if' => '身份证号码不能为空',
            'card_number.regex' => '身份证号码不符合规范',
            'card_front.required_if' => '身份证正面不能为空',
            'card_front.url' => '身份证正面文件有误',
            'card_back.required_if' => '身份证反面不能为空',
            'card_back.url' => '身份证反面文件有误',
            'card_hold.required_if' => '身份证手持不能为空',
            'card_hold.url' => '身份证手持文件有误',
            'business_license.required_if' => '营业执照不能为空',
            'business_license.url' => '营业执照文件有误',
            'service_item.required_if' => '服务项目不能为空',
            'service_item.array' => '服务项目格式有误',
            'service_area.required_if' => '服务区域不能为空',
            'service_area.array' => '服务区域格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            if (in_array($request->type, ['MASTER', 'DEALER'])) {
                $crypts = explode('_', Crypt::decrypt($request->crypt));
                if (strcasecmp($crypts[1], $request->type) || strcasecmp($crypts[2], $request->mobile)) {
                    throw new \Exception('表单窜改，请重新提交');
                }

                if (time() - $crypts[3] > 900) {
                    throw new \Exception('表单超时，请重新注册');
                }
            }

            $user = new User;
            $user->mobile = $request->mobile;
            $user->type = constant('App\User::TYPE_' . $request->type);
            $user->status = ($request->type == 'MEMBER') ? 1 : 0;
            $user->password = bcrypt($request->password);

            if ($request->type == 'MASTER') {
                if ($finder = User::where('public_id', $request->finder)->first()) {
                    $user->finder_id = $finder->id;
                }
            }

            $publicId = '';
            while (empty($publicId)) {
                $publicId = str_pad(mt_rand(0, pow(10, 8) - 1), 8, 0, STR_PAD_LEFT);
                if (User::where('public_id', $publicId)->exists()) {
                    $publicId = '';
                }
            }
            $user->public_id = $publicId;

            $user->save();

            $userProfile = new UserProfile;
            $userProfile->user_id = $user->id;
            if (in_array($request->type, ['MASTER', 'DEALER'])) {
                $userProfile->realname = $request->realname;
                $userProfile->card_number = $request->card_number;

                $userProfile->card_front = $request->card_front;
                $userProfile->card_back = $request->card_back;
                $userProfile->card_hold = $request->card_hold;

                $userProfile->service_item = implode('|', $request->service_item);
            }

            if ($request->type == 'MASTER') {
                $userProfile->service_area = implode('|', $request->service_area);
            }
            if ($request->type == 'DEALER') {
                $userProfile->business_license = $request->business_license;
            }
            $userProfile->save();

            DB::commit();

            return response()->json(['status' => 'success', 'data' => ['mobile' => $user->mobile]]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = '系统繁忙，请稍后再试';
            if (app()->environment('local')) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'message' => $message]);
        }

    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_old' => ['required'],
            'password' => ['required', 'between:6,20', 'confirmed'],
        ], [
            'password_old.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.between' => '新密码长度有误',
            'password.confirmed' => '新密码不一致',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        if (!Hash::check($request->password_old, $user->password)) {
            return response()->json(['status' => 'error', 'message' => '旧密码输入错误']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $userProfile = $user->profile;

        if ($request->has('realname')) {
            $userProfile->realname = $request->realname;
        }

        if ($request->has('sex')) {
            $userProfile->sex = $request->sex;
        }

        if ($request->has('signature')) {
            $userProfile->signature = $request->signature;
        }

        if ($request->has('master_commission')) {
            $userProfile->master_commission = $request->master_commission;
        }

        $userProfile->save();

        return response()->json(['status' => 'success']);
    }


}
