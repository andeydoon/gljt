<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Krucas\Notification\Facades\Notification;

class AddressController extends UserController
{
    private $view_module = 'address.';

    public function index()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

    public function create()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

    public function edit($id)
    {
        if (!$userAddress = auth()->user()->addresses()->where('id', $id)->first()) {
            Notification::error('找不到该地址');
            return redirect('/user/address');
        }

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__, compact('userAddress'));
    }
}
