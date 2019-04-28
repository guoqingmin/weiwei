<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class CartController extends Controller
{
    //加入购物车
    public function cart()
    {
        //接收id 和购买数量
        $goods_id = \request()->goods_id;
        $buy_number = \request()->buy_number;
        //判断是否登入
        if ($this->islogin()) {
            //登入存数据库
            $this->cartDb($goods_id, $buy_number);
        } else {
            //未登入存cookie
            $this->cartCookie();
        }


        //

    }

    //购物车数据库
    public function cartDb($goods_id, $buy_number)
    {
        $email_id = $this->islogin();
        $where = [
            ['email_id', '=', $email_id],
            ['goods_id', '=', $goods_id]
        ];
        //判断当前用户
        $cartInfo = $post = DB::table('wei_cart')->where($where)->value('buy_number');
        if (!empty($cartInfo)) {
            //买过
            $res = $this->checkGoodsNumber($goods_id, $buy_number, $cartInfo);
            if ($res == true) {

                $updateInfo = [
                    'buy_number' => $cartInfo + $buy_number,
                ];
                $result = DB::table('wei_cart')
                    ->where('goods_id', $goods_id)
                    ->update($updateInfo);
            } else {
                //购买数量超过库存
//                dd(111);
                echo 3;
            }
        } else {
            //未买过
            $res = $this->checkGoodsNumber($goods_id, $buy_number, $cartInfo['buy_number']);
            if ($res) {
                $info = ['goods_id' => $goods_id, 'buy_number' => $buy_number, 'email_id' => $email_id];
                $result = DB::table('wei_cart')->insertGetId($info);
            } else {
                //超过库存
                echo 3;
            }
        }
        if ($result) {
            //加入购物车成功
            echo 1;
        } else {
            //加入购物车失败
            echo 2;
        }
    }

    //购物车cookie
    public function cartCookie()
    {
        echo 4;
    }

    //购物车列表
    public function cartlist()
    {
        $email_id = $this->islogin();
        //$res=DB::table('wei_goods')->->select('goods_name','shop_price','goods_img')->get($goods_id);
        $res = DB::table('wei_cart')
            ->join('wei_goods', 'wei_cart.goods_id', '=', 'wei_goods.goods_id')
            ->where('email_id', $email_id)
            ->get();
        return view('cart/cart', compact('res'));
    }


    //获取小计
    public function getSubTotal()
    {
        $goods_id = \request()->goods_id;
        $buy_number = \request()->buy_number;
        if ($goods_id == '') {
            echo "0";
            exit;
        }
        if ($this->islogin()) {
            $count = 0;
            //获取单价
            $shop_price = DB::table('wei_goods')->where('goods_id', '=', $goods_id)->value('shop_price');
            $count += $buy_number * $shop_price;
            return $count;
            //$cart_model=DB::table('wei_cart');
        } else {
            dd('请先登入');
        }
    }

    //获取商品总价
    public function countTotal()
    {
        $goods_id = \request()->goods_id;
//        $num=\request()->num;
//        $price=\request()->price;
        if (empty($goods_id)) {
            echo '0';
            exit;
        }
        $email_id = $this->islogin();
//        $where=[
//            ['email_id'=>$email_id],
//            ['wei_cart.goods_id'=>$goods_id]
////            ['wei_cart.goods_id','in',$goods_id],
////            ['email_id','=',$email_id]
//        ];
//        $info=DB::table('wei_goods')->where('goods_id','=',$goods_id)->value('shop_price');
        $info = DB::table('wei_cart')->where('goods_id', '=', $goods_id)->get();
        $shop_price = DB::table('wei_goods')->where('goods_id', '=', $goods_id)->value('shop_price');
        $count = 0;
        foreach ($info as $k => $v) {
            $count += $v->buy_number * $shop_price;
        }
        return $count;
    }


    //更改购买数量
    public function changeBuyNumber()
    {
        $goods_id = \request()->goods_id;
        $buy_number = \request()->buy_number;
        //检测库存
        $res = $this->checkGoodsNumber($goods_id, $buy_number);
        if ($buy_number < $res) {
            $result = DB::table('wei_cart')->where(['goods_id' => $goods_id])->update(['buy_number' => $buy_number]);
            if ($result) {
                echo('修改数量成功');
            } else {
                echo('修改数量失败');
            }
        } else {
            echo('购买数量超过了库存量');
        }

    }

    //检测库存,$buy_number,$number=0
    public function checkGoodsNumber($goods_id, $buy_number)
    {
        $goods_number = DB::table('wei_goods')->where('goods_id', $goods_id)->value('goods_number');
        return $goods_number;
    }
    //确认结算
    //展示结算页面
    public function pay()
    {
        $goods_id = \request()->id;
        //查询数据库
        $res = DB::table('wei_goods')->where('goods_id', $goods_id)->get();
        $buy_number = DB::table('wei_cart')->where('goods_id', $goods_id)->value('buy_number');
        $count = 0;
        //获取单价
        $shop_price = DB::table('wei_goods')->where('goods_id', '=', $goods_id)->value('shop_price');
        $count += $buy_number * $shop_price;
        //检测是否有商品
        if (empty($goods_id)) {
            echo('请至少选择一个商品进行结算');
        }
        //获取购物车数据
        return view('cart/pay', compact('res', 'buy_number', 'count'));
    }

    //提交订单
    public function orderdo()
    {
        $goods_id = \request()->goods_id;
//        $res=DB::table('wei_cart')->where('goods_id',$goods_id)->get();
//        $buy_number=DB::table('wei_cart')->where('goods_id',$goods_id)->value('buy_number');
//        $count=0;
//        //获取单价
//        $shop_price=DB::table('wei_goods')->where('goods_id','=',$goods_id)->value('shop_price');
//        $count+=$buy_number*$shop_price;
        $email_id = $this->islogin();
//        try {
            $order_model = DB::table('wei_order')->get();
            //开启事务
//            $order_model->startTrans();
            //订单信息写入订单表  （订单号生成规则）  总金额 用户id

            //生成订单号
            $order_no = $this->createOrderNo();

            //总金额
            $order_amount = $this->getOrderAmount($goods_id);
            //dd($order_amount);
            $orderInfo['order_no'] = $order_no;
            $orderInfo['order_amount'] = $order_amount;
            $orderInfo['user_id'] = $email_id;
            $res1 = DB::table('wei_order')->insertGetId($orderInfo);

//            if(empty($res1)){
//                //抛出异常
//                throw new Exception('订单信息添加失败');
//            }

            //订单详情添加 订单id （获取刚刚添加的自增id） 多条数据的添加准备的数据格式


            $order_id = DB::getPdo()->lastInsertId();

            $goodsInfo = $this->getOrderDetail($goods_id);

            foreach ($goodsInfo as $k => $v) {
                $goodsInfo[$k]->user_id = $email_id;
                $goodsInfo[$k]->order_id = $order_id;
                $goodsInfo[$k]->create_time = time();
                unset($goodsInfo[$k]->email_id);
            }
            if (empty($goodsInfo)) {
                throw new Exception('没有商品详情数据');
            }

            $goodsInfo = json_decode(json_encode($goodsInfo), true);
            $res2 = DB::table('wei_order_detail')->insert($goodsInfo);

            if (empty($res2)) {
                throw new Exception('订单详情写入失败');
            }
            //订单收获地址的添加
            $addressInfo = DB::table('wei_address')
                ->where('is_default', '=', 1)
                ->first();

            if (empty($addressInfo)) {
                throw new Exception('没有此收货地址，请重新选择');
            }
            $addressInfo = json_decode(json_encode($addressInfo), true);
            unset($addressInfo['create_time']);
            unset($addressInfo['address_id']);
            unset($addressInfo['is_del']);
            unset($addressInfo['email_id']);
            unset($addressInfo['is_default']);
            $addressInfo['order_id'] = $order_id;
            $addressInfo['user_id'] = $email_id;

            $res3 = DB::table('wei_order_address')->insertGetId($addressInfo);
            if (empty($res3)) {
                throw new Exception('订单收货地址添加失败');
            }
            //下单成功
            return  json_encode(['order_no'=>$order_no,'code'=>1]);
//
//            //删除购物车数据
//            $cart_model=model('Cart');
//            $cartWhere=[
//                ['email_id','=',$email_id],
//                ['goods_id','in',$goods_id],
//                ['is_del','=',1]
//            ];
//            //dump($cartWhere);exit;
//            $res4=$cart_model->where($cartWhere)->update(['is_del'=>2]);
//            if(empty($res4)){
//                throw new Exception('购物车删除失败');
//            }
            //减少库存
//
//            foreach($goodsInfo as $k=>$v){
//                $goodsWhere=[
//                    ['goods_id','=',$v['goods_id']],
//                ];
//                $updateInfo=[
//                    'goods_number'=>$v['goods_number']-$v['buy_number']
//                ];
//                $res5=DB::table('wei_goods')->where($goodsWhere)->update($updateInfo);
//            }
//            dd($goodsInfo);
//            $order_model->commit();
//            $arr=[
//                'code'=>1,
//                'font'=>'下单成功',
//                'order_id'=>$order_id
//            ];
//            echo json_encode($arr);
//        } catch (Exception $e) {
//            echo $e->getMessage();
//        }

    }

    /*生成订单号的方法*/
    public  function createOrderNo(){
        return datE('Ymd').rand(1000,9999).$this->islogin();
    }
    /**订单总金额*/
    public function getOrderAmount($goods_id){
        $email_id=$this->islogin();
        $goods_id=explode(',',$goods_id);
        $cartInfo=DB::table('wei_cart')
            ->join('wei_goods','wei_cart.goods_id','=','wei_goods.goods_id')
            ->where('email_id',$email_id)
            ->whereIn('wei_cart.goods_id',$goods_id)
            ->get();
        $count=0;
        foreach($cartInfo as $k=>$v){
            $count+=$v->shop_price*$v->buy_number;

        }
        return $count;
    }
    /*订单详情表*/
    public function getOrderDetail($goods_id){
        $goods_id=explode(',',$goods_id);
        $email_id=$this->islogin();
        $goodsInfo=DB::table('wei_cart')
            ->select('wei_goods.goods_id','goods_name','email_id','shop_price','goods_img','buy_number')
            ->join('wei_goods','wei_cart.goods_id','=','wei_goods.goods_id')
            ->where('email_id',$email_id)
            ->whereIn('wei_cart.goods_id',$goods_id)
            ->get();
        return $goodsInfo;
    }
    //下单成功
    public function success(){
        return view('cart/success');
    }






    //判断是否登入
    public function islogin(){
//        $rand=request()->session()->get('isLoginSession');
        $rand=session('email_id');

        return $rand;
    }

}
