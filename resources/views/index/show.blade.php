@extends('layouts.shop')
@section('title','微商城首页')

@section('content')

     <div class="head-top">
      <img src="/images/head.jpg" />
      <dl>
       <dt><a href="user.html"><img src="/images/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="/goods/prolist"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="/index/erweima"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="submit" name="goods_name" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     <ul class="reg-login-click">
      <li><a href="/login/login">登录</a></li>
      <li><a href="/login/reg" class="rlbg">注册</a></li>
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
     <div id="sliderA" class="slider">
      <img src="/images/image1.jpg" />
      <img src="/images/image2.jpg" />
      <img src="/images/image3.jpg" />
      <img src="/images/image4.jpg" />
      <img src="/images/image5.jpg" />
     </div><!--sliderA/-->
     {{--品牌--}}
     <ul class="pronav">
         @foreach($res as $key=>$val)
            <li><a href="/index/indexcate/{{$val->cate_id}}">{{$val->cate_name}}</a></li>
         @endforeach
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <div class="index-pro1">
      {{--商品首页展示--}}
      @foreach($data as $key=>$val)
         <div class="index-pro1-list">
       <dl>
        <dt>
         <a href="/goods/proinfo/{{$val->goods_id}}">
          <img src="http://www.weiimg.com/{{$val->goods_img}}">
         </a>
        </dt>
        <dd class="ip-text"><a href="/goods/proinfo/{{$val->goods_id}}/{{$val->goods_id}}">{{$val->goods_name}}</a><span></span></dd>
        <dd class="ip-price"><strong>¥{{$val->shop_price}}</strong> <span>¥{{$val->market_price}}</span></dd>
       </dl>
      </div>
      @endforeach
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     {{--<div class="prolist">--}}
      {{--<dl>--}}
       {{--<dt><a href="proinfo.blade.php"><img src="/images/prolist1.jpg" width="100" height="100" /></a></dt>--}}
       {{--<dd>--}}
        {{--<h3><a href="proinfo.blade.php">四叶草</a></h3>--}}
        {{--<div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>--}}
        {{--<div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>--}}
       {{--</dd>--}}
       {{--<div class="clearfix"></div>--}}
      {{--</dl>--}}
      {{--<dl>--}}
       {{--<dt><a href="proinfo.blade.php"><img src="/images/prolist1.jpg" width="100" height="100" /></a></dt>--}}
       {{--<dd>--}}
        {{--<h3><a href="proinfo.blade.php">四叶草</a></h3>--}}
        {{--<div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>--}}
        {{--<div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>--}}
       {{--</dd>--}}
       {{--<div class="clearfix"></div>--}}
      {{--</dl>--}}
      {{--<dl>--}}
       {{--<dt><a href="proinfo.blade.php"><img src="/images/prolist1.jpg" width="100" height="100" /></a></dt>--}}
       {{--<dd>--}}
        {{--<h3><a href="proinfo.blade.php">四叶草</a></h3>--}}
        {{--<div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>--}}
        {{--<div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>--}}
       {{--</dd>--}}
       {{--<div class="clearfix"></div>--}}
      {{--</dl>--}}
     {{--</div><!--prolist/-->--}}
     <div class="joins"><a href="/goods/proinfo/{{$val->goods_id}}"><img src="/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy <span class="blue">这是就是三级分销底部信息</span></div>

     @include('public.footer')
@endsection
