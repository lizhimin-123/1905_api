<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Model\Pusers;


class TestController extends Controller
{
    public function test(){
//        echo "111";
        $user_info=[
            'name'=>'zhangsan',
            'age'=>1,
            'email'=>'zhangsan@qq.com'
        ];
        return json_encode($user_info);
    }
    public function reg(Request $request){
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        if($pass1!=$pass2){
            die('两次输入的密码不一致');
        }
        $password=password_hash($pass1,PASSWORD_BCRYPT);
        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$password,
            'last_login'=>time(),
            'last_ip'=>$_SERVER['REMOTE_ADDR'],
        ];
        $res=Pusers::insertGetId($data);
    }
    public function login(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        $u=Pusers::where(['name'=>$name])->first();
        if($u){
            if(password_verify($pass,$u['password'])) {
                echo "登录成功";
                $token = Str::random(32);
                $response = [
                    'erron' => 0,
                    'msg' => 'ok',
                    'data' => [
                        'token' => $token
                    ]
                ];
            }else {
                $response = [
                    'error' => 400003,
                    'msg' => "密码不正确",
                ];
            }
        }else{
            $response=[
                'errno'=>400004,
                'msg'=>"用户不存在"
            ];
        }
        return $response;
    }

    /**
     * 获取用户列表
     */
    public function userList(){
        $list=Pusers::all();
        echo '<pre>';print_r($list->toArray());echo '</pre>';

    }

    /**2.4postman防刷测试 */
//    public function postman1()
//    {
//        //获取用户标识
//        $token =$_SERVER['HTTP_TOKEN'];
//        //当前url
//        $request_uri=$_SERVER['REQUEST_URI'];
//        $url_hash=md5($token.$request_uri);
//
//        //echo'url_hash:'.$url_hash;echo '</br>';
//        $key='count:url'.$url_hash;
//        //echo 'Key:'.$key;echo '</br>';
//
//        //检查  次数是否已经超过限制
//        $count=Redis::get($key);
//        echo "当前接口访问次数为:".$count;echo '</br>';
//
//        if($count >= 3){
//            $time=5;   //时间秒
//            echo "请勿频繁请求接口,$time 秒后重试";
//            Redis::expire($key,$time);
//            die;
//        }
//        //访问数+1
//        $count=Redis::incr($key);
//        echo 'count:'.$count;
//    }postamanl

    public function postamanl()
    {

        $data = [
            'user_name' => 'zhangsan',
            'email' => 'zhangsan@qq.com',
            'amount' => 10000
        ];

        echo json_encode($data);
    }

    //非对称加密
    public function encrypt3(){
        $data="憨憨抱拳";
        //使用非对称加密使用私钥加密
        $path=storage_path('keys/privkey3');
        $prive_key=openssl_pkey_get_private("file://".$path);
        openssl_private_encrypt($data, $encrypt_data,$prive_key,OPENSSL_PKCS1_PADDING);
        var_dump($encrypt_data);
        $base64_str=base64_encode($encrypt_data);
        echo '</br>';
        echo $base64_str;
    }





}