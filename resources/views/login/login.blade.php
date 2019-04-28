@extends('layouts.shop')
@section('title','微商城首页')

@section('content')
    <script src="/js/jquery-3.3.1.min.js" rel="stylesheet"></script>
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员登入</h1>
        </div>
    </header>

    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->

    <form action="" method="post" class="reg-login">
        @csrf
        <h3>还没有三级分销账号？点此<a class="orange" href="/login/reg">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" name="email_name" id="email_name" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList"><input type="password" name="pwd" id="pwd" placeholder="输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="" id="btn" value="立即登录" />
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
    @include('public.footer')
    <script>
        //账号
        $('#email_name').blur(function(){
            email_names();
        })
        ///密码
        $('#pwd').blur(function(){
            pwds();
        })

        //登入
        $('#btn').click(function(){
           var  email_name=$('#email_name').val();
            var pwd=$('#pwd').val();

            $.ajax({
                type:'post',
                url:"/login/logindo",
                data:{email_name:email_name,pwd:pwd},
                dataType:'json',
                // async:false
        }).done(function(res){
            if(res==1){
                alert('登入成功');location.href='/';
            }else if(res==3){
                alert('账号不存在');
            }else{
                alert('密码或账号有误');
            }
        })
        email_names();
            pwds();

        })

        //账号
        function email_names(){
            var email_name=$('#email_name').val();
            $('#email_name').next().remove();
            if(email_name==''){
                $('#email_name').after('<b style="color:red">请输入账号</b>');
                return false;
            }
            var reg=/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/;
            var reg2=/^1(3|4|5|7|8)[0-9]{9}$/;

            if(reg.test(email_name)){

            }else if(reg2.test(email_name)){

            }else{
                $('#email_name').after("<b style='color:red'>邮箱格式不对</b>");
                return false;
            }
        }
        //密码
        function pwds(){
            var pwd=$('#pwd').val();
            $('#pwd').next().remove();
            if(pwd==''){
                $('#pwd').after('<b style="color:red">请输入密码</b>');
                return false;
            }



        }

    </script>
@endsection
