<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//use App\Address;
class AddressController extends Controller
{
    //收货地址添加页面
    public function addaddress(){

        //$post=DB::table('wei_area')->where($where)->get();
        $post=DB::table('wei_address')->get();
        return view('cart/addaddress',compact('post'));

    }
    //修改
    public function updaddress($id){
        if(!empty($id)){
            //$res=DB::table('wei_address')->where($id)->first();
            //$res=DB::select('select * from wei_address where address_id=:address_id',['address_id'=>$id]);
            $res=DB::table('wei_address')->where('address_id',$id)->first();
//            $province=DB::table('wei_address')->value('province');
//            $area=DB::table('wei_address')->value('area');
//            $city=DB::table('wei_address')->value('city');
            //dd($res);
//            $res=DB::table('wei_address')->where($id)->get();
//            dd($res);
            if($res==''){
                return redirect('/web/list');
            }

            $provinceInfo=$this->getAreaInfo(0);
//            dump($res);
//            dd($provinceInfo);
            $city=$this->getAreaInfo($res->province);
//
            $area=$this->getAreaInfo($res->city);
            $provinceInfo=$this->getAreaInfo(0);
            return view('cart/updaddress',compact('res','city','area','provinceInfo'));
        }
    }
    //修改执行
    public function updatedo(){
       // dd(111);
        $id=\request()->address_id;
        $post=\request()->all();
        $res=DB::table('wei_address')->where('address_id',$id)->update($post);
//        $user=DB::table('wei_address')->select($id);
//
//        $user->address_name=$post['address_name'];
//
//        $user->address_tel=$post['address_tel'];
//        $user->address_detail=$post['address_detail'];
        //$res=$user->save();
        if($res){
            return 1;
           // echo "<script>alert('修改成功');location.href='/cart/addaddress'</script>";
            //return redirect('/user/lists')->with('msg','修改成功');
        }else{
            return 2;
            //echo "<script>alert('未修改');location.href='/cart/addaddress'</script>";
        }


    }
    //地址
    public function address(){
        //获取省市区
        $provinceInfo=$this->getAreaInfo(0);
        return view('cart/address',compact('provinceInfo','areaInfo'));
    }

    //省
    public function getAreaInfo($pid){
        $where=[
            'pid'=>$pid
        ];
        $area_model=DB::table('wei_area')->where($where)->get();
        return $area_model;
    }

    //获取地区
    public function getarea(){
        $id=\request()->id;
        $areaInfo=DB::table('wei_area')->where('pid',$id)->get();

        //dd($areaInfo);
        return $areaInfo;
    }

    //收货地址添加执行
    public function addressdo(){
        $post=\request()->all();
       //添加
        $post=DB::table('wei_address')->insertGetId($post);
        if($post){
            //添加成功
            return 1;
        }else{
            //添加失败
            return 2;
        }
    }
}
