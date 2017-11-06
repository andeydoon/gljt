<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class HomeController extends UserController
{
    public function index()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function publish(Request $request)
    {
        $type = $request->server('QUERY_STRING');
        if (!in_array($type, ['custom', 'service'])) {
            $type = 'custom';
        }

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__ . '-' . $type);
    }

    public function favorite()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function credit()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function coupon()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function coin()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function password()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function feedback()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function about()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function order()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function bond()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function project()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__);
    }

    public function apply(Request $request)
    {
        $user = $request->user();

        if ($request->has('status')) {
            $masters = $user->masters()->where('status', $request->status)->get();
        } else {
            $masters = $user->masters;
        }

        $request->flashOnly('status');

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . __FUNCTION__, compact('masters'));
    }
}
