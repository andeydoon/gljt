<?php

namespace App\Http\Controllers\Mobile;

use App\Category;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->where('type', 1)->take(2)->get();
        $combines = Product::where('status', 1)->where('type', 2)->take(4)->get();

        $data['products'] = $products;
        $data['combines'] = $combines;

        return view('mobile.index', $data);
    }

    public function showLoginForm()
    {
        return view('mobile.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile' => ['required'],
            'password' => ['required'],
        ], [
            'mobile.required' => '手机号码不能为空',
            'password.required' => '密码不能为空',
        ]);

        $mobile = $request->mobile;
        $password = $request->password;
        $remember = $request->remember;

        if (!auth()->attempt(['mobile' => $mobile, 'password' => $password, 'status' => User::STATUS_NORMAL], $remember)) {
            return redirect()->back()
                ->withInput($request->only(['mobile', 'remember']))
                ->withErrors(['mobile' => '账户待审核、帐户不存在或密码错误',]);
        }

        return redirect()->intended();
    }

    public function register(Request $request)
    {
        $type = $request->server('QUERY_STRING');
        if (!in_array($type, ['member', 'master', 'dealer'])) {
            $type = '';
        }

        if (empty($type)) {
            return view('mobile.register');
        }

        return view("mobile.register-$type");
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/mobile');
    }

    public function process()
    {
        return view('mobile.process');
    }

    public function message()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return view('mobile.message');
    }

    public function service()
    {
        $categories = Category::where('parent_id', 0)->get();

        $data['categories'] = $categories;

        return view('mobile.service', $data);
    }

    public function quote()
    {
        return view('mobile.quote');
    }
}
