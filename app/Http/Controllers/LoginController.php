<?php

namespace App\Http\Controllers;
use App\Model\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //发送邮件
//    public function send(){
//
//       //接收数据
//        $email=request()->email_name;
//        $send=rand(100000,999999);
//        if($email){
//            Mail::send('login/email',
//                ['name'=>$email,'send'=>$send],
//                function($message)use($email){
//                    $res=$message->subject('欢迎注册微商城有限公司');
//                    $message->to($email);
//                    if($res){
//                        $user=[
//                            'time'=>time(),
//                            'email'=>$email,
//
//                        ];
//                        request()->session('userInfo',$user);
//                        echo json_encode(['font'=>'发送成功','code'=>1]);
//                    }else{
//                        echo json_encode(['font'=>'发送失败','code'=>2]);
//                    }
//            });
//        }
//
//    }



    //邮箱注册邮件发送
    public function send(){
        //接收数据
        $rand=rand(111111,999999);
        $email= request()->email_name;
        //    dd($l_tel);
        if($email){
            Mail::send('login/email',['name'=>$rand],function($message)use($email){
                $message->subject("您的注册信息");
                $message->to($email);
            });
        }
        request()->session()->put('rand',$rand);
    }

    //登入
    public function logindo(){
        $email_name=request()->email_name;
        $pwd=\request()->pwd;
        $where=[
            'email_name'=>$email_name,
        ];
        //模型
        $data=Login::where($where)->first();

        //var_dump($data['email_id']);exit;

        if($data){
            if($pwd==$data['pwd']){
                //登入成功

                session(['email_id'=>$data['email_id']]);
                return 1;
//                request()->session()->put('isLoginSession',$data);
            }else{
                //密码错误
                return 2;
            }

        }else{
            //账号不存在
            return 3;
        }



//        if(Auth::attempt(['email_name'=>$data['email_name'],'pwd'=>$data['pwd']])){
//            return redirect()->intended('/');
//        }
    }

    //注册
    public function regdo(Request $request){
        $rand=$request->session()->get('rand');
        $post=request()->all();
        //唯一性
        $email_name=$request->email_name;
        $where=[
            'email_name'=>$email_name,
        ];
        //模型
        $data=Login::where($where)->first();
        if($data['email_name']==$email_name){
            return 3;
        }

        if($rand==$post['email_code']){
            $res=DB::table('wei_email')->insertGetId($post);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }else{
//            echo "<script>alert('验证码输入有误');location.href='/login/reg'</script>";
            return 0;
        }





    }

    //短信发送
    public function sendduan(){
        $host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "8f106ac02a704c1794bc1baebdf51755";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $rand=rand(100000,999999);
        $querys = "mobile=15733015119&param=code%3A".$rand."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));

        request()->session()->put('rand',$rand);
    }

    //退出
    public function  quit(){
        //清除session
        request()->session()->flush();
    }
    public function is_login(){
//        $rand=request()->session()->get('isLoginSession');
        $rand=session('email_id');
        dd($rand);
    }


}
