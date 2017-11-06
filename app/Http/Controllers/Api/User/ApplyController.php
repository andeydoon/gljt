<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplyController extends Controller
{
    public function patch(Request $request, $id)
    {
        $user = $request->user();

        if (!$master = $user->masters()->where('public_id', $id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该申请']);
        }

        if ($request->has('status')) {
            $master->status = $request->status;
        }

        $master->save();

        return response()->json(['status' => 'success']);
    }
}
