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

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Auth::routes();
Route::group(['middleware'=>'auth'],function(){
    Route::group(['middleware'=>'email_verified'],function(){
        Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
        Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
        Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
        Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
        Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
        Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
        // 商品收藏
        Route::post('products/{product}/favorite','ProductsController@favor')->name('products.favor');
        // 取消收藏
        Route::delete('products/{product}/favorite','ProductsController@disfavor')->name('products.disfavor');
        // 商品收藏列表
        Route::get('products/favorites','ProductsController@favorites')->name('products.favorites');
        // 添加购物车
        Route::post('cart','CartController@add')->name('cart.add');
        // 购物车列表
        Route::get('cart','CartController@index')->name('cart.index');
        // 删除购物车
        Route::delete('cart/{sku}','CartController@remove')->name('cart.remove');
        // 提交订单
        Route::post('orders', 'OrdersController@store')->name('orders.store');
        // 订单列表
        Route::get('orders', 'OrdersController@index')->name('orders.index');
        // 订单详情
        Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
        // 支付宝支付订单
        Route::get('payment/{order}/alipay','PaymentController@payByAlipay')->name('payment.alipay');
        // 支付宝前端回调
        Route::get('payment/alipay/return','PaymentController@alipayReturn')->name('payment.alipay.return');
        // 微信支付
        Route::get('payment/{order}/wechat','PaymentController@payByWechat')->name('payment.wechat');
        //确认收货
        Route::post('order/{order}/received','OrdersController@received')->name('orders.received');

    });
});
// 商品详情
Route::get('products/{product}', 'ProductsController@show')->name('products.show');
// 支付宝服务器回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
// 微信服务器回调
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');
// 测试
Route::get('/test', 'TestController@index')->name('test');
