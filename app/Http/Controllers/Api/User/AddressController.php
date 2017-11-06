<?php

namespace App\Http\Controllers\Api\User;

use App\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'phone' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'street' => ['required'],
            'floor' => ['required'],
            'lift' => ['required'],
        ], [
            'name.required' => '姓名不能为空',
            'phone.required' => '电话不能为空',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
            'district_id.required' => '区县不能为空',
            'street.required' => '详细地址不能为空',
            'floor.required' => '楼层信息不能为空',
            'lift.required' => '电梯情况不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        $userAddress = new UserAddress;
        $userAddress->name = $request->name;
        $userAddress->phone = $request->phone;
        $userAddress->province_id = $request->province_id;
        $userAddress->city_id = $request->city_id;
        $userAddress->district_id = $request->district_id;
        $userAddress->street = $request->street;
        $userAddress->floor = $request->floor;
        $userAddress->lift = $request->lift;
        $userAddress->default = $request->input('default', 0);

        $user->addresses()->save($userAddress);

        if ($userAddress->default) {
            $user->addresses()->where('id', '<>', $userAddress->id)->update(['default' => 0]);
        }

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'phone' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'street' => ['required'],
            'floor' => ['required'],
            'lift' => ['required'],
        ], [
            'name.required' => '姓名不能为空',
            'phone.required' => '电话不能为空',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
            'district_id.required' => '区县不能为空',
            'street.required' => '详细地址不能为空',
            'floor.required' => '楼层信息不能为空',
            'lift.required' => '电梯情况不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        if (!$userAddress = auth()->user()->addresses()->where('id', $id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该地址']);
        }

        $userAddress->name = $request->name;
        $userAddress->phone = $request->phone;
        $userAddress->province_id = $request->province_id;
        $userAddress->city_id = $request->city_id;
        $userAddress->district_id = $request->district_id;
        $userAddress->street = $request->street;
        $userAddress->floor = $request->floor;
        $userAddress->lift = $request->lift;
        $userAddress->default = $request->input('default', 0);

        $user->addresses()->save($userAddress);

        if ($userAddress->default) {
            $user->addresses()->where('id', '<>', $userAddress->id)->update(['default' => 0]);
        }

        return response()->json(['status' => 'success']);
    }
}
