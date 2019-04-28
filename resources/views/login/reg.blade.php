
@extends('layouts.shop')
@section('title', '微商城注册')

@section('content')
    {{--<link href="/js/jquery-3.3.1.min.js" rel="stylesheet">--}}
    <script src="/js/jquery-3.3.1.min.js" rel="stylesheet">

    </script>
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->


      <h3>已经有账号了？点此<a class="orange" href="login.blade.php">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList" id="a"><input type="text" name="email_name" id="email_name" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="email_code" placeholder="输入短信验证码" /> <button id="emailcode">获取验证码</button></div>
       <div class="lrList"><input type="password" name="pwd" id="pwd1" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" nmae="pwd" id="pwd2" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" id="zhuce"/>
      </div>
        {{--底部--}}

    <script>
        //获取验证码
        $('#emailcode').click(function(){
            //获取邮箱的值
            var email_name=$('#email_name').val();
            $('#email_name').next().remove();
            if(email_name==''){
                $('#email_name').after("<b style='color:red'>用户邮箱不能为空</b>");
                return false;
            }
            //存储一个变量
            var flag=false;
            //正则验证
            var reg=/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/;
            var reg2=/^1(3|4|5|7|8)[0-9]{9}$/;
            //判断
            if(reg.test(email_name)){
                $.ajax({
                    type:'post',
                    url:"/login/send",
                    data:{email_name:email_name},
                    dataType:'json',
                    // async:false
                }).done(function(res){
                    console.log(res);
                })
            }else if(reg2.test(email_name)){
                $.ajax({
                    type:'post',
                    url:"/login/sendduan",
                    data:{email_name:email_name},
                    dataType:'json',
                    // async:false
                }).done(function(res){
                    console.log(res);
                })
            }else{
                $('#email_name').after("<b style='color:red'>邮箱格式不对</b>");
                 return false;
            }

        })

        //密码
        $('#pwd1').blur(function(){
            var _this=$(this);
            var pwd1=_this.val();
            var reg=/^.{6,12}$/;
            if(!reg.test(pwd1)){
                _this.after("<b style='color:red'>密码必须为6-12位</b>");
                return false;
            }
        })

        //确认密码
        $('#pwd2').blur(function(){
            var _this=$(this);
            var pwd1=$('#pwd1').val();
            var pwd2=$('#pwd2').val();
            $('#pwd2').next().remove();
            if(pwd2!=pwd1){
                _this.after("<b style='color:red'>确认密码有密码保持一致</b>");
                return false;
            }

        })

        //点击注册
        $('#zhuce').click(function(){
            //alert(1234567);
            //判断非空
            var email_name=$('#email_name').val();
            $('#email_name').next().remove();
            if(email_name==''){
                $('#email_name').after("<b style='color:red'>用户邮箱不能为空</b>");
                return false;
            }
            var reg=/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/;
            var reg2=/^1(3|4|5|7|8)[0-9]{9}$/;
            //判断
            if(reg.test(email_name)){

            }else if(reg2.test(email_name)){

            }else{
                $('#email_name').after("<b style='color:red'>邮箱格式不对</b>");
            }

           //密码
            var pwd1=$('#pwd1').val();
            var reg=/^.{6,12}$/;
            $('#pwd1').next().remove();
            if(!reg.test(pwd1)){
                $('#pwd1').after("<b style='color:red'>密码必须为6-12位</b>");
                return false;
            }

            //确认密码

            var pwd=$('#pwd1').val();
            var pwd2=$('#pwd2').val();
            $('#pwd2').next().remove();
            if(pwd2!=pwd){
                $('#pwd2').after("<b style='color:red'>确认密码有密码保持一致</b>");
                return false;
            }
            var email_code=$('input[name=email_code]').val();


            //注册提交
            $.ajax({
                type:'post',
                url:"/login/regdo",
                data:{email_name:email_name,pwd:pwd,email_code:email_code},
                dataType:'json',
                // async:false
            }).done(function(res){
                if(res==3){
                    alert('用户已存在');
                }else{
                    if(res==1){
                        alert('注册成功');location.href='/login/login/';
                    }else{
                        if(res==0){
                            alert('验证码输入有误');
                        }else{
                            alert('注册失败');
                        }

                    }

                }


            })

        })



    </script>


@endsection

