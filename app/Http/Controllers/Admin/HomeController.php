<?php

namespace App\Http\Controllers\Admin;

use App\Configure;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Krucas\Notification\Facades\Notification;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function dashboard()
    {
        $data = [];

        $data['count']['order_custom'] = Order::where('type', 1)->count();
        $data['count']['order_service'] = Order::where('type', 2)->count();
        $data['count']['user'] = User::count();
        $data['count']['product'] = Product::count();

        return view('admin.dashboard', $data);
    }

    public function upload(Request $request)
    {
        $funcNum = $request->input('CKEditorFuncNum');
        $message = $fileUrl = '';
        if ($request->hasFile('upload')) {
            if ($request->file('upload')->isValid()) {
                $file = $request->file('upload')->store('uploads');
                $url = sprintf('http://%s/%s/%s', env('OSS_DOMAIN'), env('OSS_PREFIX'), $file);
            } else {
                $message = '上传文件发生错误';
            }
        } else {
            $message = '未选择上传文件';
        }

        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

    public function showConfigureForm()
    {
        $data = [];
        foreach (Configure::all() as $configure) {
            $data[$configure->key] = $configure->value;
        }

        return view('admin.configure', $data);
    }

    public function configure(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            Configure::where('key', $key)->update(['value' => $value]);
        }

        Notification::success('配置修改成功');

        return redirect()->route('admin.configure');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->only(['mobile', 'remember']))
                ->withErrors($validator);
        }

        $mobile = $request->mobile;
        $password = $request->password;
        $remember = $request->remember;

        if (!auth()->guard('admin-web')->attempt(['mobile' => $mobile, 'password' => $password], $remember)) {
            return redirect()->back()
                ->withInput($request->only(['mobile', 'remember']))
                ->withErrors(['mobile' => '帐户不存在或密码错误',]);
        }

        return redirect()->intended('/admin');
    }

    public function logout()
    {
        auth()->guard('admin-web')->logout();

        return redirect()->route('admin.login');
    }
}
