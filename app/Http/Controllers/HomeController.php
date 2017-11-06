<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->where('type', 1)->take(4)->get();
        $combines = Product::where('status', 1)->where('type', 2)->take(4)->get();
        $services = Service::all();
        $categories = Category::where('parent_id', 0)->get();

        $data['products'] = $products;
        $data['combines'] = $combines;
        $data['services'] = $services;
        $data['categories'] = $categories;

        return view('index', $data);
    }

    public function showLoginForm()
    {
        return view('login');
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
            $type = 'member';
        }

        return view("register-$type");
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->intended();
    }

    public function contact()
    {
        return view('contact');
    }

    public function process()
    {
        return view('process');
    }

    public function search(Request $request)
    {
        $request->flashOnly(['q']);

        $q = $request->q;

        $data = [];

        $data['products'] = Product::where('status', 1)->where('type', 1)->where('name', 'LIKE', "%$q%")->orderBy('updated_at', 'DESC')->paginate(8);
        $data['queries'] = $request->only('q');

        return view('search', $data);
    }

    public function message()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return view('message');
    }
}
