<?php
namespace App\Http\Controllers\Text;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class TextController extends Controller{
    public function decrypt1(){
        $data=file_get_contents("php://input");
//       解密
        $data=base64_decode($data);
        echo $data;die;
        return $data;
    }

    public function decrypt2(){
        $method='AES-128-CBC';
        $key='password';   //加密密钥
        $iv='MGDZYYLSYZSYZDMI';        //初始向量
        $data=base64_decode(file_get_contents("php://input"));
//       解密
        $dec_data=openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;die;

    }


    public function decrypt3(){
        $enc_data=file_get_contents("php://input");
        $pub_key=openssl_get_publickey("file://".storage_path("keys/pub.key"));
        openssl_public_decrypt($enc_data,$dec_data,$pub_key);
        var_dump($dec_data);
    }

    public function sign(Request $request){
        $method='AES-128-CBC';
        $key='signsuccessly';
        $iv='VMUSTLIQUANXINGL';
        $data=unserialize(file_get_contents("php://input"));
        $data1=$data['data'];
//        dd($data1);
        $sign=$data['body'];
        $pub_key=openssl_get_publickey("file://".storage_path("keys/pub.key"));
//        dd($pub_key);

        $dec_data=openssl_decrypt($data1,$method,$key,OPENSSL_RAW_DATA,$iv);
        $sign1=openssl_verify($dec_data,$sign,$pub_key);
        //print_r($sign1);die;
//        dd($sign1);
      if($sign1=='1'){

//          echo  '验证签名成功';die;
          //var_dump($dec_data);echo "<br>";
          $data1=openssl_encrypt($dec_data,$method,$key,OPENSSL_RAW_DATA,$iv);
//         var_dump($data1);  echo "<br>";
          $key=storage_path("keys/priva.pem");
          $private_key=openssl_get_privatekey("file://".$key);
//          var_dump($private_key);echo "<b>";

//          生成 参一样
          $signs=openssl_sign($dec_data,$signatrue,$private_key,OPENSSL_ALGO_SHA256);
//          var_dump($signatrue);echo "<br>";die;
//          var_dump($signs);echo "<br>";die;
//         $data1="12321321321";
          $info=[
              'data'=>$data1,
              'body'=>$signatrue
          ];
//          dd($info);
          $infosign=serialize($info);
//         dd($info);echo "<br>";
          $client=new Client();
//         dd($client);die;
          $api="http://www.1810api.com/text/sign1";
          $r=$client->request('post',$api,[
              'body'=>$infosign
          ]);
//          dd($r);
          echo  $r->getBody();
      }else{
          echo  '验证签名失败';
      }

    }

    public function o1(){
        echo "<pre>";print_r($_POST);echo "</pre>";echo "<hr>";
        $data=$_POST;
        $signature=$_POST['signature'];
        $signature=base64_decode($signature);
        unset($data['signature']);
        $str='';
        foreach ($data as $k=>$v){
            $str .= $k."=".$v."&";
        }
        $str1=rtrim($str,'&');
        $pub_key=openssl_get_publickey("file://".storage_path("keys/pub.key"));
//        dd($pub_key);
        $sign=openssl_verify($str1,$signature,$pub_key);
        if($sign){
            echo '成功';
        }else{
            echo '失败';
        }
    }

}
?>