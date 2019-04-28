<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //个人中心
    public function user(){

    }

    //浏览历史记录
    public function history(){
        //判断是否登入
        if($this->islogin()){
            $this->historyDb();
        }else{
            $this->historyCookie();
        }
    }
    //浏览历史从数据库
    public function historyDb(){
        //获取该用户的id
        //链接数据库
        //按照时间倒叙排序
        //非空验证去重
    }
    public function historyCookie(){

    }


    ///个人收藏

    //加入收藏
    public function cartcollect(){
        $goods_id=\request()->goods_id;

        if($this->islogin()){
            $email_id=$this->islogin();

            $where=[
                'email_id'=>$email_id,
                'goods_id'=>$goods_id
            ];
            //dd($where);
            //$Info=DB::table('wei_like')->where($where)->first();
            $Info=DB::table('wei_like')->where(['goods_id'=>$goods_id,'email_id'=>$email_id])->get();
            $count=count($Info);
//            dump($count);
//            dd($Info);
            if($count>0){
                return 3;
            }else{
//                $collectInfo=DB::table('wei_like')->in(['u_id'=>$user_id,'goods_id'=>$goods_id]);
                $res=DB::insert('insert into wei_like(goods_id,email_id) values(?,?)',[$goods_id,$email_id]);
                if($res){
                    //收藏成功
                    return 1;
                }else{
                    //收藏失败
                    return 2;
                }
            }
        }else{
//            $this->error('请先登入','login/login');
//            return view();
            return('请先登入');
        }
    }

    //收藏展示
    public function shoucang(){
//        $goods_id=DB::table('wei_like')->select('goods_id')->get();
//        //$count=count($goods_id);
//        $post=DB::table('wei_goods')->where(['goods_id'=>$goods_id])->get();
//        dd($post);



        $res =DB::table('wei_like')
            ->join('wei_goods', 'wei_like.goods_id', '=', 'wei_goods.goods_id')
            ->get();

        return view('user/shoucang',compact('res'));
    }
    //收藏删除
    public function likedel(){
        $goods_id=\request()->goods_id;
        $res=DB::table('wei_like')->where(['goods_id'=>$goods_id])->delete();
        if($res==1){
            return 1;
        }else{
            return 2;
        }
    }
    //浏览历史记录
    public function lioulan(){
        //
        dump(1);
    }


    //判断是否登入
    public function islogin(){
//        $rand=request()->session()->get('isLoginSession');
        $rand=session('email_id');

        return $rand;
    }

}
