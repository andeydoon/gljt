<?php

namespace App\Http\Controllers\Api;

use App\UserFavorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function favorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'type' => ['required', 'in:PRODUCT'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        switch ($request->type) {
            case 'PRODUCT':
                $model = 'App\Product';
                break;

        }

        if (!${strtolower($request->type)} = $model::where('id', $request->id)->first()) {
            return response()->json(['status' => 'error', 'message' => '找不到该记录']);
        }

        $user = $request->user();

        $isFavorite = false;
        if ($favorite = $user->favorites()->where('related_id', ${strtolower($request->type)}->id)->where('type', constant('App\UserFavorite::TYPE_' . $request->type))->first()) {
            $favorite->delete();
        } else {
            $userFavorite = new UserFavorite;
            $userFavorite->related_id = ${strtolower($request->type)}->id;
            $userFavorite->type = constant('App\UserFavorite::TYPE_' . $request->type);

            $user->favorites()->save($userFavorite);

            $isFavorite = true;
        }

        return response()->json(['status' => 'success', 'data' => ['isFavorite' => $isFavorite]]);

    }
}
