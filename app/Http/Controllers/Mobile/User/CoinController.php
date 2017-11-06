<?php

namespace App\Http\Controllers\Mobile\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Mobile\UserController;

class CoinController extends UserController
{
    private $view_module = 'coin.';

    public function index()
    {

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

    public function history()
    {
        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

}
