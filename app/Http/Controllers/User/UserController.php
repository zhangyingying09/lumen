<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\DB;
class UserController extends Controller{
//    注册
    public function reg(Request $request){
        $data=$request->input();
        $res=UserModel::insert($data);
        if($res){
            echo '注册成功';
        }else{
            echo '注册失败';
        }
    }
//    登陆
    public function login(Request $request){
        $data=$request->input();
        $where=[
            'user_name'=>$data['user_name']
        ];
        $one=DB::table('user')->where($where)->first();
        if($one){
            if($data['pass1']==$one->pass){
                echo '登录成功';
            }else{
                echo '账号或密码错误';
            }
        }else{
            //没有此用户
            echo '账号或密码错误';
        }
    }
//    修改密码
    public function update(Request $request){
        $data=$request->input();
        $where=[
            'user_name'=>$data['user_name']
        ];
        $one=DB::table('user')->where($where)->first();
        if($one){
            if($data['pass1']==$one->pass){
                $data1=[
                    'pass'=>$data['pass2']
                ];
//                dd($data1);
               $two=DB::table('user')->where($where)->update($data1);
               echo '密码修改成功';
            }else{
                echo '账号或密码错误';
            }
        }else{
        //没有此用户
            echo '账号或密码错误';
        }
    }
//    回复天气
    public function weather(Request $request){
        $cities=$request->input('text');
//        dd($cities);
        $city=substr($cities,0,-6);
        $url = file_get_contents('http://api.k780.com/?app=weather.future&weaid=' . $city . '&&appkey=42240&sign=8cc0be0300e48ab2152b3ec681219a82&format=json');
        $urls = json_decode($url, true);
        $msg = '';
        foreach ($urls['result'] as $k => $v) {
            $msg .= $v['days'] . "  " . $v['week'] . "  " . $v['citynm'] . "  " . $v['temperature'] . "  " . $v['weather'] . "\n";
        }
        echo $msg;


    }
}
?>