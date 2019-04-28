
@extends('layouts.shop')
@section('title','微商城首页')

@section('content')
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
          <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
       <h1>我的收藏</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">收藏栏共有：<strong class="orange">1</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">全部删除</a></td>
      </tr>
     </table>
     

     @foreach($res as $k=>$v)
            {{--onClick="window.location.href='proinfo.html'"--}}
     <div class="dingdanlist" >
      <table>
       <tr>
        <td colspan="2" width="65%"></td>
        <td width="35%" align="right"><div class="qingqu" goods_id="{{$v->goods_id}}"><a href="#" class="orange">取消收藏</a></div></td>
       </tr>
       <tr>
        <td class="dingimg" width="15%"><img src="http://www.weiimg.com/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：2015-08-11  13:51</time>
        </td>
        <td align="right"><img src="/images/jian-new.png" /></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">¥{{$v->shop_price}}</strong></th>
       </tr>
      </table>
     </div><!--dingdanlist/-->

    @endforeach
    </div>
    <script>
        $(document).on('click','.orange',function () {
            var goods_id=$(this).parent('div').attr('goods_id');
            $.ajax({
                type:'post',
                url:"/user/likedel",
                data:{goods_id:goods_id},
                // dataType:'json',
                // async:false
            }).done(function(res){
                if(res==1){
                    alert('取消收藏成功');
                }else{
                    alert('取消收藏失败');
                }
            })

        })
    </script>
@endsection