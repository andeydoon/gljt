<?php

namespace App\Http\Controllers\Api\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        return Datatables::collection(Role::all())->make(true);
    }
}
