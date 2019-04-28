
@extends('layouts.shop')
@section('title','微商城首页')

@section('content')
    <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <form action="#" method="get" class="prosearch"><input type="text" /></form>
      </div>
     </header>
     <ul class="pro-select">
         {{--class="pro-selCur"--}}
      <li id="is_new" class=" isgoods" is_type="1">
          <a href="javascript:;"   field="is_new">
              <p>新品</p>
          </a>
      </li>
      <li class=" isgoods" id="is_hot"   is_type="2">
          <a href="javascript:;" field="is_hot">
              <p>热卖</p>
          </a>

      </li>
      <li class=" isgoods" id="goods_price" is_type="3">
          <a href="javascript:;" field="shop_price">
              <span>价格</span>
              <span>↓</span>
          </a>

      </li>
     </ul><!--pro-select/-->
     <div class="prolist"  id="show">
         @foreach($res as $key=>$val)
         <dl>
             <dt>
                 <a href="proinfo/{{$val->goods_id}}" >
                     <img src="http://www.weiimg.com/{{$val->goods_img}}">
                 </a>
             </dt>
               <dd>
                <h3><a href="proinfo/{{$val->goods_id}}">{{$val->goods_name}}</a></h3>
                <div class="proinfo/{{$val->goods_id}}"><strong>¥{{$val->shop_price}}</strong> <span>¥{{$val->market_price}}</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em id="goods_number">库存：{{$val->goods_number}}</em></div>
               </dd>
               <div class="clearfix"></div>
         </dl>
         @endforeach
     </div><!--prolist/-->
     @include('public.footer')
     <script>

         $(document).on('click','.isgoods',function () {
                var _this=$(this);
                _this.addClass('pro-selCur');
                 _this.siblings('li').removeClass('pro-selCur');
                 var is_type=_this.attr('is_type');


                getGoodsInfo();
         })
         //
         function getGoodsInfo(){
             var _default=$('.pro-selCur.isgoods');
             var is_type=_default.attr('is_type');
             var order_field=_default.children().attr('field');
             var flag=_default.children().children('span').last().text();

             if(is_type==1){
                 var field='is_new'
             }else if(is_type===2){
                 var field='is_hot'
             }else{
                 if(flag=='↓'){
                     _default.children().children('span').last().text('↑');
                     var order_type='asc';
                 }else{
                     _default.children().children('span').last().text('↓');
                     var order_type='desc';
                 }
                 var field='shop_price';
                 //alert(field);
             }

             $.ajax({
                 type:'post',
                 url:"/goods/getGoodsInfo",
                 data:{is_type:is_type,order_field:order_field,order_type:order_type},
                dataType:'html',
                 // async:false
             }).done(function(res){
                 $('#show').html(res);
             })


         }

         //点击加减号
         $(document).on('click','.add',function(){
            var _this=$(this);
            var goods_number=$('#goods_number').text();
            //alert(goods_number);
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
     </script>
@endsection
