<!DOCTYPE html>
<html lang="zh-cn">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="Author" contect="http://www.webqin.net">
 <title>个人微商城- @yield('title')</title>
 <link rel="shortcut icon" href="/images/favicon.ico" />


 <!-- Bootstrap -->
 <link href="/css/bootstrap.min.css" rel="stylesheet">
 <link href="/css/style.css" rel="stylesheet">
 <link href="/css/response.css" rel="stylesheet">
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
 <!--[if lt IE 9]>
 <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
 <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
 <![endif]-->
</head>
<body>
<div class="maincont">
@section('title','微商城购物车')


    <div class="maincont">
     <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>


       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="allbox"/> 全选</a></td>
       </tr>
       @foreach($res as $key=>$val)
       <tr goods_number="{{$val->goods_number}}" goods_id="{{$val->goods_id}}">
        <td width="4%"><input type="checkbox" class="box"  name="1" /></td>
        <td class="dingimg" width="15%"><img src="http://www.weiimg.com/{{$val->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$val->goods_name}}</h3>
         <time>下单时间：2015-08-11  13:51</time>
        </td>
         <td class="aaa">
          {{--<input type="button"  value="+"  class="car_btn_2" >--}}
          {{--goods_id="{{$val->goods_id}}" buy_number="{{$val->buy_number}}"--}}
          {{--<input type="text"  value="1" style="width: 40px"/>--}}
          {{--<input type="button" value="－"  class="car_btn_1">购买数量--}}
          <div class="c_num  ccc">
           <input type="button" value="-"   class="car_btn_1"  />
           <input type="text" value="{{$val->buy_number}}" buy_number="{{$val->buy_number}}" class="car_ipt  bb" style="width: 40px"/>
           <input type="button" value="+" class="car_btn_2" />
          </div>
          {{--<h3> 小计：￥<span class="total">{$v.total}</span></h3>--}}
         </td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange" price="{{$val->shop_price}}"> ¥{{$val->shop_price}}</strong></th>
       </tr>
        @endforeach
      </table>
     </div>
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%"><span class="fr">商品总价：<b style="font-size:22px; color:#ff4e00;">￥<font id="count">0</font></b></span></td>
       <td width="40%"><a href="javaScript:;" class="jiesuan"  id="account">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
 <script>
  //点击加号
  $(document).on('click','.car_btn_2',function(){
   var _this=$(this);
   var buy_number=parseInt(_this.prev('input').val());
   var goods_number=_this.parents('tr').attr('goods_number');
   if(buy_number>=goods_number){
    _this.prop('distabled',true);
   }else{
    buy_number+=1;
    _this.prev('input').val(buy_number);
   }
   //调用方法是数据库或cookie更改购买数量
   var goods_id=_this.parents('tr').attr('goods_id');
   //alert(goods_id);
   //购买数量
   changeBuyNumber(goods_id,buy_number);
   //获取小计
   getSubTotal(goods_id,_this,buy_number);
   //给当前复选框选中

   boxChecked(_this);
   //计算重新获取价格
  // countTotal();


  })

  //点击减号
  $(document).on('click','.car_btn_1',function(){
   var _this=$(this);
   //获取库存
   var goods_number=$('#goods_number').text();
   var buy_number=parseInt(_this.next('input').val());
   if(buy_number<=1){
    _this.prop('disabled',true);
   }else{
    buy_number-=1;
    _this.next('input').val(buy_number);
    _this.parent().children('input').last().prop('disabled',false);

   }
   //调用方法是数据库或cookie更改购买数量
   var goods_id=_this.parents('tr').attr('goods_id');

   //购买数量
   changeBuyNumber(goods_id,buy_number);
   //获取小计
   getSubTotal(goods_id,_this,buy_number);
   //给当前复选框选中
   boxChecked(_this);
   // //计算重新获取价格
  // countTotal();



  })

  //点击单个复选框
  $(document).on('click','.box',function(){
   var _this = $(this);
   var goods_id=_this.parents('tr').attr('goods_id');
   //获取小计
   getSubTotal(goods_id,_this);
   //计算重新获取价格
   countTotal();
  })

  //失去焦点
  $(document).on('blur','.car_ipt',function(){
   //获取文本框的值
   var _this=$(this);
   var buy_number=_this.val();
   var goods_number=_this.parents('tr').attr('goods_id');
   //验证
   //console.log(goods_number);
   var reg=/^\d{1,}$/;

   if(buy_number==''||buy_number<1||!reg.test(buy_number)){
    _this.val(1);
   }else if(parseInt(buy_number)>parseInt(goods_number)){
    _this.val(goods_number);
   }else{
    _this.val(parseInt(buy_number));
   }
   //调用方法是数据库或cookie更改购买数量
   var goods_id=_this.parents('tr').attr('goods_id');
   //购买数量
   changeBuyNumber(goods_id,buy_number);
   //获取小计
   getSubTotal(goods_id,_this);
   //给当前复选框选中
   boxChecked(_this);
   //计算重新获取价格
   countTotal();

  })


  //全选  全不选
  $('#allbox').click(function(){
   var _this=$(this);
   var stutus=_this.prop('checked');
   $('.box').prop('checked',stutus);
   //调用商品总价格
   countTotal();

  })

  //确认结算
  $('#account').click(function(){
   //获取商品id
   //获取选中的复选框的id
   var _box=$('.box');
   var goods_id='';
   _box.each(function (i,v) {
    if($(this).prop('checked')==true){
     goods_id+=$(this).parents('tr').attr('goods_id')+',';
    }
   });
   if(goods_id==''){
    alert('请至少选择一个商品进行结算');
    return false;
   }else{
    goods_id=goods_id.substr(0,goods_id.length-1);

    alert('前往支付页面');location.href='/cart/pay/'+goods_id;
   }



  })
  //更改购买数量
  function changeBuyNumber(goods_id,buy_number){
      $.ajax({
       type:'post',
       url:"/cart/changeBuyNumber",
       data:{goods_id:goods_id,buy_number:buy_number},
       dataType:'html',
       // async:false
      }).done(function(res){
       console.log(res)

      })


  }

  //获取商品总价

  function countTotal(){
   //获取复选框中所有商品id
   var _box=$('.box');
   var goods_id='';
   _box.each(function(index){
    if($(this).prop('checked')==true){
     goods_id+=$(this).parents('tr').attr('goods_id')+',';
     //alert(goods_id);
     // var price=$(this).parents('tr').next('tr').find('th').find('strong').attr('price');
     // var num=$(this).parent('td').siblings('.aaa').find('.ccc').find('.bb').attr('buy_number');
     // goods_id=goods_id.substr(0,goods_id.length-1)
    }

    $.ajax({
     type:'post',
     url:"/cart/countTotal",
     data: {goods_id:goods_id},
    }).done(function(res){
     //alert(res);
     $("#count").text(res);
    })

    // var priceAll=0;
    // var all=0;
    // priceAll+=parseInt(price*num);
    // alert(priceAll);
   })

  }

  //获取小计
  function getSubTotal(goods_id,_this,buy_number){
   $.ajax({
    type:'post',
    url:"/cart/getSubTotal",
    data:{goods_id:goods_id,buy_number:buy_number},
    dataType:'html',
    // async:false
   }).done(function(res){
    $('#count').html(res);
   })
  }

  //复选框选中
  function boxChecked(_this){
   //console.log(_this);
   _this.parents("tr").find("input[class='box']").prop('checked',true);

  }








     // //点击加号
     // $(document).on('click','.add',function(){
     //  var _this=$(this);
     //  var goods_number=$('#goods_number').val();
     //  alert(goods_number);
     //  // var buy_number=parseInt($('#buy_number').val());
     //  var goods_id=_this.next().attr('goods_id');
     //  var buy_number=_this.next().attr('buy_number');
     //  //判断是否大于库存
     //  if(buy_number>=goods_number){
     //   //加号失效
     //   _this.prop('disabled',true);
     //   _this.next('input').prop('disabled',false);
     //   //_this.next()
     //  }else{
     //   buy_number=buy_number+1;
     //   $('#buy_number').val(buy_number);
     //  }
     //  //获取小计
     //  getSubTotal(goods_id,_this);
     //  //获取总价
     //  countTotal();
     // })
     // //点击减号
     // $(document).on('click','.less',function(){
     //  var _this=$(this);
     //  var goods_number=$('#goods_number').val();
     //  // var buy_number=parseInt($('#buy_number').val());
     //  var buy_number=_this.prev().attr('buy_number');
     //  alert(buy_number);
     //  var goods_id=_this.prev().attr('goods_id');
     //  //判断小于一
     //  if(buy_number<=1){
     //   //加号失效
     //   _this.prop('disabled',true);
     //   _this.prev('input').prop('disabled',false);
     //
     //  }else{
     //   buy_number=buy_number-1;
     //   $('#buy_number').val(buy_number);
     //  }
     // })
     // //失去焦点
     // $(document).on('blur','#buy_number',function(){
     //    //获取文本框的值
     //    var _this=$(this);
     //    var buy_number=_this.val();
     //    var goods_number=$('#goods_number').val();
     //
     //    //验证
     //    var reg=/^\d{1,}$/;
     //
     //    if(buy_number==''||buy_number<1||!reg.test(buy_number)){
     //     _this.val(1);
     //    }else if(parseInt(buy_number)>parseInt(goods_number)){
     //     _this.val(goods_number);
     //    }else{
     //     _this.val(parseInt(buy_number));
     //    }
     // })
     //
     //
     // //点击结算
     // $(document).on('click','.jiesuan',function(){
     //  var _this=$(this);
     //  var goods_id=$("#goods_id").val();
     //  var buy_number=$("#buy_number").val();
     //
     //  if(buy_number==''){
     //   layer.msg('购买数量不能为空',{icon:2});
     //   return false;
     //  }
     //  //改变价格
     //
     //     $.ajax({
     //         type:'post',
     //         url:"/cart/pay",
     //         data:{goods_id:goods_id,buy_number:buy_number},
     //         dataType:'json',
     //         // async:false
     //     }).done(function(res){
     //      alert('加入购物车成功');location.href='/cart/pay';
     //     })
     //
     // })
     //
     //  //点击单个复选框
     //  // $(document).on('click','.box',function(){
     //  //  var _this = $(this);
     //  //  var goods_id=$('#goods_id').val();
     //  //  //获取小计
     //  //  getSubTotal(goods_id,_this);
     //  //  //计算重新获取价格
     //  //  countTotal();
     //  // })
     //  //全选  全不选
     //  $('#allbox').click(function(){
     //   var _this=$(this);
     //   var stutus=_this.prop('checked');
     //   $('.box').prop('checked',stutus);
     //   //调用商品总价格
     //   countTotal();
     //
     //  })
     // //计算总价格
     // function countTotal(){
     //    //复选框选中的商品
     //     var box=$('.box');
     //     var goods_id='';
     //     box.each(function (res) {
     //         if($(this).prop('checked')==true){
     //             var goods_id=goods_id+=$(this).parents('tr').attr('goods_id')+',';
     //
     //         }
     //     })
     // }
     // //获取小计
     // function getSubTotal(goods_id,_this) {
     //     $.ajax({
     //         type:'post',
     //         url:"/cart/getSubTotal",
     //         data:{goods_id:goods_id},
     //         dataType:'json',
     //         // async:false
     //     }).done(function(res){
     //
     //     })
     // }

 </script>
</div>