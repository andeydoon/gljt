<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->format == 'datatables') {
            return Datatables::collection(User::with('profile')->orderBy('created_at', 'DESC')->get())->make(true);
        }

        $query = User::orderBy('created_at', 'ASC');
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('finder_id')) {
            $query->where('finder_id', $request->finder_id);
        }

        $users = $query->with('profile')->get();

        return response()->json(['status' => 'success', 'data' => compact('users')]);
    }
}
