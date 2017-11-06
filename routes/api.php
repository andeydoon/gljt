<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['namespace' => 'Api'], function () {
    Route::post('captcha/sms_send', 'CaptchaController@sms_send');
    Route::post('captcha/sms_verify', 'CaptchaController@sms_verify');
    Route::post('user/register', 'User\HomeController@register');
    Route::post('upload', 'HomeController@upload');
    Route::get('area', 'HomeController@area');
    Route::get('category', 'HomeController@category');
    Route::get('material', 'HomeController@material');
    Route::post('quote', 'HomeController@quote');

    Route::group(['namespace' => 'Third', 'prefix' => 'third'], function () {
        Route::post('alipay/purchase', 'AlipayController@purchase');
        Route::post('alipay/notify', 'AlipayController@notify');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('feedback', 'HomeController@feedback');
        Route::post('user/password', 'User\HomeController@password');
        Route::post('user/profile', 'User\HomeController@profile');

        Route::post('order/custom', 'OrderController@custom');
        Route::post('order/service', 'OrderController@service');

        Route::post('product/favorite', 'ProductController@favorite');

        Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {

            Route::resource('card', 'CardController');

            Route::group(['middleware' => 'user.cos:api'], function () {
                Route::resource('address', 'AddressController');
                Route::resource('product', 'ProductController');

                Route::post('publish/cancel', 'PublishController@cancel');
                Route::post('publish/take', 'PublishController@take');
                Route::post('publish/install', 'PublishController@install');
                Route::post('publish/comment', 'PublishController@comment');

                Route::post('order/service_scheme_create', 'OrderController@service_scheme_create');
                Route::post('order/custom_scheme_create', 'OrderController@custom_scheme_create');
                Route::post('order/custom_scheme_draft', 'OrderController@custom_scheme_draft');

                Route::post('order/make', 'OrderController@make');
                Route::post('order/send', 'OrderController@send');
                Route::post('order/visit', 'OrderController@visit');


                Route::patch('apply/{id}/patch', 'ApplyController@patch');
                Route::patch('product/{id}/patch', 'ProductController@patch');
            });
        });
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth:admin-api'], function () {

        Route::resource('user', 'UserController');
        Route::resource('order', 'OrderController');
        Route::resource('coupon', 'CouponController');
        Route::resource('product', 'ProductController');
        Route::resource('role', 'RoleController');
        Route::resource('permission', 'PermissionController');
        Route::resource('category', 'CategoryController');
        Route::resource('material', 'MaterialController');
    });
});