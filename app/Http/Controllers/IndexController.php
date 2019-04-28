<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redis;
use App\Model\Goods;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    //首页视图
    public function index(){
//        Redis::set('name','heihei');
//        dd(Redis::get('name'));
//        cache(['data'=>''],3);
        $data=cache('data');
        $res=cache('res');
        if(!$data){
            $res=DB::select("select * from wei_category where cate_navshow in(1)");
            $data=Goods::get();
            cache(['data'=>$data],60*24);
            cache(['res'=>$res],60*24);
        }
//        dump($res);
//       dd($data);
        return view('index/index',compact('data','res','goods_name','goods_img','shop_price','market_price'));


    }
    //分类展示
    public function indexcate(){
        $cate_id = request()->id;
        $res=DB::select("select * from wei_category");
        if($cate_id==''){
            //查询所有
            $data=Goods::get();
        }else{

            $c_id=$this->cateGoods($res,$cate_id);
            $data=DB::table('wei_goods')->whereIn( 'cate_id',$c_id)->get();
            $res=DB::select("select * from wei_category  where cate_navshow in(1)");
            //dd($data);
            //根据分类查询商品
        }

        return view('index/index',compact('data','res','goods_name','goods_img','shop_price','market_price'));

    }
    //首页商品展示
//,$field='cate_id',,$level=1
    public function cateGoods($res ,$pid=0){
        //dd($res);
        static $result=[];
        if($res){
            //dd($res);
            foreach ($res as $key=>$val){
               //dd(($val->pid)==$pid);
                if(($val->pid)==$pid){
                    $result[]=$val->cate_id;
                    $this->cateGoods($res,$val->cate_id);
                }
            }
        }
        return $result;
    }


    //缓存
    public function show($id){
        $data=cache('data_'.$id);
        if(!$data){
            echo(1);
            $data=DB::table('wei_goods')->where(['goods_id'=>$id])->first();
            cache(['data_'.$id=>$data],60*24);
        }
//        dd($data);

        return view('index/show',compact('data'));
    }
}
