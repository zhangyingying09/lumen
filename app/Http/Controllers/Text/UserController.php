<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/18
 * Time: 14:09
 */

namespace App\Http\Controllers\Text;


use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Model\UserModel;

class UserController extends Controller
{
    //注册
    public function reg(Request $request){
        header("Access-Control-Allow-Origin:*");
        $data  = $request->input();
//        return $data;die;
        if($data['account']==''){
            return $msg=json_encode(['code'=>2,'font'=>'姓名不为空']);die;
        }
        if($data['password']==''){
            return $msg=json_encode(['code'=>2,'font'=>'密码不为空']);die;
        }
        if($data['password_confirm']==''){
            return $msg=json_encode(['code'=>2,'font'=>'确认密码不为空']);die;
        }
        if($data['password']!=$data['password_confirm']){
            return $msg=json_encode(['code'=>2,'font'=>'密码与确认密码不一致']);die;
        }
        $info=UserModel::where('account',$data["account"])->get();
        if($info){
            return $msg=json_encode(['code'=>2,'font'=>'此用户已注册']);die;
        }

        unset($data['password_confirm']);
//        return $data;die;
        $res=UserModel::insert($data);
        if($res){
            return $msg=json_encode(['code'=>1,'font'=>'注册成功']);
        }else{
            return $msg=json_encode(['code'=>2,'font'=>'注册失败']);die;
        }
    }
//    登陆
    public function login(Request $request){
        header("Access-Control-Allow-Origin:*");
        $data  = $request->input();
        if($data['account']==''){
            return $msg=json_encode(['code'=>2,'font'=>'姓名不为空']);die;
        }
        if($data['password']==''){
            return $msg=json_encode(['code'=>2,'font'=>'密码不为空']);die;
        }
        $info=UserModel::where('account',$data["account"])->get();
        if($info){
            if($data['password']==$info[0]['password']){
                return $msg=json_encode(['code'=>1,'font'=>'登陆成功']);
                cache(['u_id'.$info[0]['id']=>$info[0]['id'],7200]);
            }else{
                return $msg=json_encode(['code'=>2,'font'=>'账号或密码错误']);die;
            }
        }else{
            return $msg=json_encode(['code'=>2,'font'=>'此用户还没有注册']);die;
        }
    }
}