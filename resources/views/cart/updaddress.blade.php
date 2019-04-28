@extends('layouts.shop')
@section('title','微商城首页')

@section('content')
 <div class="maincont">
  <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
  <header>
   <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
   <div class="head-mid">
    <h1>收货地址</h1>
   </div>
  </header>
  <input type="hidden" id="address_id" value="{{$res->address_id}}">
  <div class="head-top">
   <img src="/images/head.jpg" />
  </div><!--head-top/-->
  <div class="lrBox">
   <div class="lrList"><input type="text" id="user_name"  value="{{$res->address_name}}" name="address_name" placeholder="收货人"/></div>
   <div class="lrList"><input type="text" name="address_detail" id="address_detail" placeholder="详细地址" value="{{$res->address_detail}}"/></div>
   <div class="lrList">
    <select class="provinceInfo" id="province" >
     <option >省市</option>
     @foreach($provinceInfo as $key=>$val)
      @if($val->id==$res->province)
         <option value="{{$val->id}}" selected>{{$val->name}}</option>
      @else
         <option value="{{$val->id}}">{{$val->name}}</option>
      @endif
     @endforeach
    </select>
   </div>
   <div class="lrList">
    <select class="provinceInfo" id="city">
     @foreach($city as $key=>$val)
       @if($val->id==$res->city)
        <option value="{{$val->id}}" selected>{{$val->name}}</option>
       @else
        <option value='0'>区县</option>
       @endif
      @endforeach


    </select>
   </div>
   <div class="lrList">
    <select class="provinceInfo" id="area">
     @foreach($area as $key=>$val)
      @if($val->id==$res->area)
       <option value="{{$val->id}}" selected>{{$val->name}}</option>
      @else
       <option value='0'>区县</option>
      @endif
     @endforeach
    </select>
   </div>
   <div class="lrList"><input type="text" id='tel' name="address_tel" placeholder="手机" value="{{$res->address_tel}}"/></div>
   <div class="lrList2"><input type="text" placeholder="设为默认地址" /> <button id="mo">设为默认</button></div>
  </div><!--lrBox/-->
  <div class="lrSub">
   <input type="submit" id="sub" value="保存修改" />
  </div>

 </div>
 <script>
  //收货地址
  $(document).on('change','.provinceInfo',function(){
   var _this=$(this);
   var _option="<option value='0' selected='selected'>区县</option>";
   var nes=_this.nextAll('select').html(_option);
   var id=_this.val();
   $.ajax({
    type:'post',
    url:"/address/getarea",
    data:{id:id},
    dataType:'json',
    // async:false
   }).done(function(res){
    for(var i in res){
     _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
    }
    _this.parent('div').next('div').children('select').html(_option);

   })

  })
  //收货人
  $(document).on('blur','#user_name',function () {
   user_name();
  })
  //手机号
  $(document).on('blur','#tel',function () {
   tel();
  })
  //修改
  $(document).on('click','#sub',function () {
   var address_id=$('#address_id').val();
   var address_name=$('#user_name').val();
   var address_tel=$('#tel').val();
   var province=$('#province').val();
   var city=$('#city').val();
   var area=$('#area').val();
   var address_detail=$('#address_detail').val();
   //收货人

   if(address_name==''){
    alert('用户必填');
    return false;
   }else if(address_tel==''){
    alert('手机号必填');
    return false;
   }
   $.ajax({
    type:'post',
    url:"/address/updatedo",
    data:{address_id:address_id,address_name:address_name,address_tel:address_tel,province:province,city:city,area:area,address_detail:address_detail},
    dataType:'json',
    // async:false
   }).done(function(res){
    if(res==1){
     alert('修改成功');location.href='/cart/addaddress';
    }else{
     alert('修改失败');location.href='/cart/addaddress';
    }
   })
   user_name();
   tel();


  })
  //点击默认地址
  $(document).on('click','#mo',function () {
   var add=$('.provinceInfo').val();
   //alert(add);
  })
  //设置默认地址
  function address() {

  }


  //手机号
  function tel() {
   var tel=$('#tel').val();
   var reg=/^1(3|4|5|7|8)[0-9]{9}$/;
   if(tel==''){
    alert('手机号必填');
    return false;
   }else if(!reg.test(tel)){
    alert('请输入正确手机号');
    return false;
   }
  }
  //收货人
  function user_name() {
   var user_name=$('#user_name').val();
   var reg=/^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/;
   if(user_name==''){
    alert('用户名不能为空');
    return false;
    // _this.after("<b style='color:red'>用户名不能为空</b>");
   }else if(!reg.test(user_name)){
    alert('请输入正确用户名');
    return false;
    //_this.after("<b style='color:red'>请输入正确用户名</b>");
   }
  }

 </script>
@endsection


