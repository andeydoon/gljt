<?php

namespace App\Http\Middleware;

use Closure;

class UserCross
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $user_types = [1 => 'member', 2 => 'master', 3 => 'dealer'];

        $member_paths = ['user/publish', 'user/favorite', 'user/credit', 'user/coupon', 'user/address'];
        $master_paths = ['user/order', 'user/bond'];
        $dealer_paths = ['user/product', 'user/project', 'user/combine', 'user/order', 'user/apply', 'user/bond'];

        foreach (${$user_types[auth()->user()->type] . '_paths'} as $path) {
            if ($request->is("$path*") || $request->is("api/$path*") || $request->is("mobile/$path*")) {
                return $next($request);
            }
        }

        if ($role == 'api') {
            return response()->json(['status' => 'error', 'message' => '无权限使用该模块']);
        }

        return redirect('user');
    }
}
