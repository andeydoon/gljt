<?php

namespace App\Http\Controllers\Api\User;

use App\UserCard;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;

class CardController extends UserController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'number' => ['required'],
            'bank' => ['required'],
        ], [
            'name.required' => '姓名不能为空',
            'number.required' => '卡号不能为空',
            'bank.required' => '银行不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        $userCard = new UserCard;
        $userCard->name = $request->name;
        $userCard->number = $request->number;
        $userCard->bank = $request->bank;

        $user->cards()->save($userCard);

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        UserCard::destroy($id);

        return response()->json(['status' => 'success']);
    }
}
