<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('login', 'HomeController@showLoginForm');
Route::post('login', 'HomeController@login');
Route::get('register', 'HomeController@register');
Route::get('logout', 'HomeController@logout');

Route::get('contact', 'HomeController@contact');
Route::get('process', 'HomeController@process');
Route::get('search', 'HomeController@search');
Route::get('product', 'ProductController@index');
Route::get('product/{id}', 'ProductController@show');

Route::group(['middleware' => ['auth']], function () {
    Route::get('message', 'HomeController@message');
    Route::get('product/{id}/custom', 'ProductController@custom');
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('/', 'HomeController@index');
        Route::get('password', 'HomeController@password');
        Route::get('feedback', 'HomeController@feedback');
        Route::get('about', 'HomeController@about');
        Route::get('coin', 'HomeController@coin');
        Route::resource('card', 'CardController');

        Route::group(['middleware' => ['user.cos']], function () {
            Route::get('favorite', 'HomeController@favorite');
            Route::get('credit', 'HomeController@credit');
            Route::get('coupon', 'HomeController@coupon');
            Route::resource('address', 'AddressController');
            Route::get('bond', 'HomeController@bond');
            Route::resource('product', 'ProductController');
            Route::resource('combine', 'CombineController');
            Route::get('project', 'HomeController@project');
            Route::get('apply', 'HomeController@apply');

            Route::get('publish', 'PublishController@index');
            Route::get('publish/custom_scheme/{id}', 'PublishController@custom_scheme');
            Route::get('publish/service_scheme/{id}', 'PublishController@service_scheme');
            Route::get('publish/pay_part1/{id}', 'PublishController@pay_part1');
            Route::get('publish/pay_part2/{id}', 'PublishController@pay_part2');
            Route::get('publish/pay/{id}', 'PublishController@pay');
            Route::get('publish/comment/{id}', 'PublishController@comment');

            Route::get('order', 'OrderController@index');
            Route::get('order/custom_scheme/{id}', 'OrderController@custom_scheme');
            Route::get('order/service_scheme/{id}', 'OrderController@service_scheme');
            Route::get('order/custom_scheme_create/{id}', 'OrderController@custom_scheme_create');
            Route::get('order/service_scheme_create/{id}', 'OrderController@service_scheme_create');
            Route::get('order/make/{id}', 'OrderController@make');
        });
    });
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('login', 'HomeController@showLoginForm')->name('login');
    Route::post('login', 'HomeController@login');
    Route::get('logout', 'HomeController@logout')->name('logout');

    Route::group(['middleware' => ['auth:admin-web']], function () {
        Route::get('/', 'HomeController@index');
        Route::get('dashboard', 'HomeController@dashboard')->middleware('permission:dashboard');
        Route::post('upload', 'HomeController@upload');

        Route::group(['middleware' => 'permission:configure'], function () {
            Route::get('configure', 'HomeController@showConfigureForm')->name('configure');
            Route::post('configure', 'HomeController@configure');
        });

        Route::group(['middleware' => 'permission:order'], function () {
            Route::resource('order', 'OrderController');
        });
        Route::group(['middleware' => 'permission:order'], function () {
            Route::resource('user', 'UserController');
        });
        Route::group(['middleware' => 'permission:product'], function () {
            Route::resource('product', 'ProductController');
        });
        Route::group(['middleware' => 'permission:coupon'], function () {
            Route::resource('coupon', 'CouponController');
        });
        Route::group(['middleware' => 'permission:role'], function () {
            Route::resource('role', 'RoleController');
        });
        Route::group(['middleware' => 'permission:permission'], function () {
            Route::resource('permission', 'PermissionController');
        });
        Route::group(['middleware' => 'permission:category'], function () {
            Route::resource('category', 'CategoryController');
        });
        Route::group(['middleware' => 'permission:material'], function () {
            Route::resource('material', 'MaterialController');
        });
    });

});


Route::group(['namespace' => 'Mobile', 'prefix' => 'mobile'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('login', 'HomeController@showLoginForm');
    Route::post('login', 'HomeController@login');
    Route::get('register', 'HomeController@register');
    Route::get('logout', 'HomeController@logout');

    Route::get('product', 'ProductController@index');
    Route::get('product/{id}', 'ProductController@show');

    Route::get('quote', 'HomeController@quote');

    Route::get('process', 'HomeController@process');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('message', 'HomeController@message');
        Route::get('product/{id}/custom', 'ProductController@custom');
        Route::get('service', 'HomeController@service');
        Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
            Route::get('to_order', 'HomeController@to_order');

            Route::get('/', 'HomeController@index');
            Route::get('password', 'HomeController@password');
            Route::get('feedback', 'HomeController@feedback');
            Route::get('about', 'HomeController@about');
            Route::get('setting', 'HomeController@setting');
            Route::resource('card', 'CardController');

            Route::get('coin', 'CoinController@index');
            Route::get('coin/history', 'CoinController@history');

            Route::group(['middleware' => ['user.cos']], function () {
                Route::get('favorite', 'HomeController@favorite');
                Route::get('credit', 'HomeController@credit');
                Route::get('coupon', 'HomeController@coupon');
                Route::resource('address', 'AddressController');
                Route::get('bond', 'HomeController@bond');
                Route::resource('product', 'ProductController');
                Route::get('project', 'HomeController@project');
                Route::get('apply', 'HomeController@apply');

                Route::get('publish', 'PublishController@index');
                Route::get('publish/custom_scheme/{id}', 'PublishController@custom_scheme');
                Route::get('publish/service_scheme/{id}', 'PublishController@service_scheme');
                Route::get('publish/pay_part1/{id}', 'PublishController@pay_part1');
                Route::get('publish/pay_part2/{id}', 'PublishController@pay_part2');
                Route::get('publish/pay/{id}', 'PublishController@pay');
                Route::get('publish/comment/{id}', 'PublishController@comment');

                Route::get('order', 'OrderController@index');
                Route::get('order/custom_scheme/{id}', 'OrderController@custom_scheme');
                Route::get('order/service_scheme/{id}', 'OrderController@service_scheme');
                Route::get('order/custom_scheme_create/{id}', 'OrderController@custom_scheme_create');
                Route::get('order/service_scheme_create/{id}', 'OrderController@service_scheme_create');
                Route::get('order/make/{id}', 'OrderController@make');
            });
        });
    });
});