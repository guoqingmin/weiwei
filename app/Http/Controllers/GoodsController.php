<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GoodsController extends Controller
{
    //商品类表
    public function prolist(){
        $res=DB::select("select * from wei_goods");
        return view('goods/prolist',compact('res'));
    }
    //商品详情
    public function proinfo(){

        $goods_id=request()->id;
        //加入浏览历史表中DB::table('user')->insert($data);
//        $res=DB::insert("insert into wei_history('goods_id'),value(?),[$goods_id]");
//
//        dump($res);die;
       // dd($goods_id);
        cache(['data'=>''],3);
       $data=cache('data'.$goods_id);
        if(!$data){
            $where=[
                'goods_id'=>$goods_id
            ];
            //dd($where);
            $data=DB::table('wei_goods')->where($where)->first();
//            cache(['data'=>$data],60*24);
        }


//      dd($data);
        return view('goods/proinfo',compact('data'));
    }
    //商品展示条件
    public function getGoodsInfo(){
        $order_field=\request()->order_field;
        $order_type=\request()->order_type;
        $is_type=\request()->is_type;

        if(!empty($order_field)){
            if($order_field=='is_new'){
//                $res=DB::select("select * from wei_category where cate_navshow in(1)");
                $where=[
                    'is_new'=>1
                ];
                $res=DB::table('wei_goods')->where($where)->get();

            }else if($order_field=='is_hot'){
                $where=[
                    'is_hot'=>1
                ];
                $res=DB::table('wei_goods')->where($where)->get();
            }else{
                $res=DB::table('wei_goods')->orderBy($order_field,$order_type)->get();
            }

        }else{
            $res=DB::table('wei_goods')->get();
        }
        //return $res;
        return view('goods/getgoodsinfo',compact('res'));
    }
    //品牌商品

}
