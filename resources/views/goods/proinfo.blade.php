@extends('layouts.shop')
@section('title','微商城首页')

@section('content')
 <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
         @foreach($data as $key=>$val)
      {{--<img src="/images/image1.jpg" />--}}
             <img src="http://www.weiimg.com/{{$data->goods_img}}" width="636" height="822">
             @endforeach
     </div><!--sliderA/-->
     <table class="jia-len">
      <input type="hidden" id="goods_number" value="{{$data->goods_number}}">
      <input type="hidden" id="goods_id" value="{{$data->goods_id}}">
      <tr>
       <th><strong class="orange">￥{{$data->shop_price}}</strong></th>
       <td>
        <input type="button" value="+"  class="add">
        <input type="text" id="buy_number" value="1"/>
        <input type="button" value="－" class="less">购买数量
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$data->goods_name}}</strong>
        <p class="hui">富含纤维素，平衡每日膳食</p>
       </td>
       <td align="right">
        {{--收藏--}}
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
             <img src="http://www.weiimg.com/{{$data->goods_img}}" width="636" height="822">

     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
        {{--点击加入购物车--}}
     <table class="jrgwc">
      <tr>
       <th>
        <a href="javaScript:;"><span class="glyphicon glyphicon-home" class="addCart"></span></a>
       </th>
       {{--/cart/cart/{{$data->goods_id}}--}}
       <td><a href='javaScript:;' class="addCart">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    <script>

     //点击加号
     $(document).on('click','.add',function(){
         var _this=$(this);
         var goods_number=$('#goods_number').val();
         var buy_number=parseInt($('#buy_number').val());
         //判断是否大于库存
         if(buy_number>=goods_number){
          //加号失效
          _this.prop('disabled',true);
          _this.next('input').prop('disabled',false);
          //_this.next()
         }else{
          buy_number=buy_number+1;
          $('#buy_number').val(buy_number);
         }
     })
     //点击减号
     $(document).on('click','.less',function(){
      var _this=$(this);
      var goods_number=$('#goods_number').val();
      var buy_number=parseInt($('#buy_number').val());
      //判断小于一
      if(buy_number<=1){
           //加号失效
           _this.prop('disabled',true);
           _this.prev('input').prop('disabled',false);

      }else{
           buy_number=buy_number-1;
           $('#buy_number').val(buy_number);
      }
      })
     //失去焦点
     $(document).on('blur','.buy_number',function(){
      //获取文本框的值
      var _this=$(this);
      var buy_number=_this.val();
      var goods_number=$('#goods_number').val();

      //验证
      var reg=/^\d{1,}$/;

      if(buy_number==''||buy_number<1||!reg.test(buy_number)){
       _this.val(1);
      }else if(parseInt(buy_number)>parseInt(goods_number)){
       _this.val(goods_number);
      }else{
       _this.val(parseInt(buy_number));
      }
     })
     //点击加入购物车
     $(document).on('click','.addCart',function(){;
      var _this=$(this);
      var goods_id=$("#goods_id").val();
      var buy_number=$("#buy_number").val();
      if(goods_id==''){
       layer.msg('请选择一个商品',{icon:2});
       return false;
      }
      if(buy_number==''){
       layer.msg('购买数量不能为空',{icon:2});
       return false;
      }
      $.ajax({
       type:'post',
       url:"/cart/cart",
       data:{goods_id:goods_id,buy_number:buy_number},
       dataType:'json',
       // async:false
      }).done(function(res){
          //console.log(res);

           if(res==1){
               alert('加入购物车成功');location.href='/cart/cartlist';
           }else if(res==2){
               alert('加入购物车失败');
           }else if(res==3){
               alert('购买数量超过库存');
           }else if(res==4){
               alert('请先登入');location.href='/login/login';
           }
      })
     })

     //收藏
     $(document).on('click','.shoucang',function () {
          var goods_id=$("#goods_id").val();
          $.ajax({
           type:'post',
           url:"/user/cartcollect",
           data:{goods_id:goods_id},
           dataType:'json',
           // async:false
          }).done(function(res){
              if(res===1){
               alert('收藏成功');
              }else if(res==2){
               alert('收藏失败');
              }else{
               alert('已收藏');
              }
             //
          })
     })
    </script>
@endsection
