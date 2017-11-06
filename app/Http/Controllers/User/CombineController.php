<?php

namespace App\Http\Controllers\User;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Krucas\Notification\Facades\Notification;

class CombineController extends UserController
{
    private $view_module = 'combine.';

    public function create()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

    public function edit($id)
    {
        if (!$product = auth()->user()->products()->where('id', $id)->first()) {
            Notification::error('找不到该产品');
            return redirect('/user/product');
        }

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, compact('product'));
    }
}
