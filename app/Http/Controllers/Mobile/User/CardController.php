<?php

namespace App\Http\Controllers\Mobile\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Mobile\UserController;

class CardController extends UserController
{
    private $view_module = 'card.';

    public function index()
    {

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }

    public function create()
    {

        return view($this->view_prefix . $this->user_types[auth()->user()->type] . $this->view_module . __FUNCTION__);
    }
}
