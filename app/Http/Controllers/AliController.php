<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class AliController extends Controller
{
    public function pay($id){

        //订单名称，必填
        $subject = "梓萌微商城支付";
        //付款金额，必填
        $total_amount =DB::table('wei_order')->where('order_no',$id)->value('order_amount');
        //商品描述，可空
        $body = '';

        $config= config('alipay');
        require_once app_path('/ali/alipay/pagepay/service/AlipayTradeService.php');
        require_once app_path('/ali/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($id);

        $aop = new \AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

    }

    //同步通知
    public function returnalipay(){
        $config=config('alipay');
        require_once app_path('/ali/alipay/pagepay/service/AlipayTradeService.php');

        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
            $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
            $count=DB::table('wei_order')->where($where)->count();
            $result=json_encode($arr);
            if(!$count){
                Log::channel('alipay')->info('订单和金额不符,没有当前记录'.$result);
            }
            if(htmlspecialchars($_GET['seller_id'])!=config('alipay.seller_id')||htmlspecialchars($_GET['app_id'])!=config('alipay.app_id')){
                Log::channel('alipay')->info('商户不符'.$result);
            }
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
           return redirect('alipay');
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            // echo "验证失败";
            echo "fail";
        }

    }
    //异步通知
    public function notifyalipay()
    {
        $config = config('alipay');
        require_once app_path('/ali/alipay/pagepay/service/AlipayTradeService.php');

        $arr = $_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
        Log::channel('alipay')->info('异步通知：' . $result);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */

        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if ($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知


                //商户订单号
                $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
                $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
                $count=DB::table('wei_order')->where($where)->count();
                $result=json_encode($arr);
                if(!$count){
                    Log::channel('alipay')->info('订单和金额不符,没有当前记录'.$result);
                }
                if(htmlspecialchars($_GET['seller_id'])!=config('alipay.seller_id')||htmlspecialchars($_GET['app_id'])!=config('alipay.app_id')){
                    Log::channel('alipay')->info('商户不符'.$result);
                }
                //支付宝交易号
                $trade_no = htmlspecialchars($_GET['trade_no']);
                Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
            }
            //订单状态
            DB::table('wei_order')->where($where)->update(['order_status'=>1]);
            //减少库存
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";    //请不要修改或删除
        }else {
            //验证失败
            // echo "验证失败";
            echo "fail";
        }
    }


}
