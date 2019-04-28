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

//Route::get('/', function () {
//    return view('welcome');
//
//});
//个人中心
Route::prefix('user')->group(function () {
    Route::get('user', function () {
        return view('user/user');
    });
    //我的收藏
    Route::post('cartcollect','UserController@cartcollect');
    Route::post('likedel','UserController@likedel');
    //收藏展示
    Route::get('shoucang','UserController@shoucang');

    //浏览历史记录
    Route::get('lioulan','UserController@lioulan');
});
Route::get('/','IndexController@index');
//路由前缀 前台
Route::prefix('index')->group(function () {
    //首页商品
    Route::get('show/{id}','IndexController@show');
    Route::get('indexcate/{id}','IndexController@indexcate');
    //二维码
    Route::get('erweima',function (){
        return view('index/erweima');
    });
});

//商品
Route::prefix('goods')->group(function () {
    //商品分类，热卖，精品
    Route::get('prolist','GoodsController@prolist');
    //商品详情
    Route::get('proinfo/{id}','GoodsController@proinfo');
    //商品条件
    Route::post('getGoodsInfo','GoodsController@getGoodsInfo');


});

//登入注册
Route::prefix('login')->group(function () {
    Route::get('islogin','LoginController@is_login');
    //注册
    Route::get('reg', function () {
        return view('login/reg');
    });
    //注册执行
    Route::post('regdo','LoginController@regdo');
    //邮箱发送
    Route::post('send','LoginController@send');

    //短信短信发送
    Route::post('sendduan','LoginController@sendduan');

    //登入页面
    Route::get('login', function () {
        return view('login/login');
    });

    //登入执行
    Route::post('logindo','LoginController@logindo');

    //退出
    Route::post('quit','LoginController@quit');

});

//购物车
Route::prefix('cart')->group(function () {
    Route::post('cart','CartController@cart');
    Route::post('getSubTotal','CartController@getSubTotal');
    //小计
    Route::post('getSubTotal','CartController@getSubTotal');
    Route::post('countTotal','CartController@countTotal');
    Route::post('changeBuyNumber','CartController@changeBuyNumber');

//    //注册
//    Route::get('pay', function () {
//        return 111;
//        //return view('cart/pay');
//    });
    //Route::get('pay','CartController@pay');
    Route::get('addaddress','CartController@addaddress');


    Route::get('islogin','CartController@islogin');
    Route::get('cartlist','CartController@cartlist');

    Route::any('pay/{id}','CartController@pay');
    //我的订单
    Route::any('order','CartController@order');
    Route::any('orderdo','CartController@orderdo');
    //下单成功
    Route::any('success','CartController@success');

});

//收货地址
Route::prefix('address')->group(function () {
    //收货列表展示
    Route::get('addaddress','AddressController@addaddress');
    //修改
    Route::get('updaddress/{id}','AddressController@updaddress');
    Route::post('updatedo','AddressController@updatedo');
//        Route::post('updatedo', function () {
//        return 111;
//        //return view('cart/pay');
//    });
    Route::post('addressdo','AddressController@addressdo');

    Route::get('address','AddressController@address');
    Route::post('getarea','AddressController@getarea');

    //收获列表展示
    //Route::get('addresslist','AddressController@addresslist');
//    Route::get('address', function () {
//        echo 1123;
//    });
});
//
//Route::get('/alipay',function(){
//   $ordersn = date('YmdHis').rand(1000,9999);
//   return "<b><a href=/pay/".$ordersn.">支付宝支付</a></b>";
//});
//Route::get('/alipay','AliController@alipay');
Route::get('/pay/{id}','AliController@pay');

//同步通知
Route::get('/returnalipay','AliController@returnalipay');
//异步通知
Route::post('/notify_url','AlipayController@notifyalipay');

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
