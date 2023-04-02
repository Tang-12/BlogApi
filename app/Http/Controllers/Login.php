<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Services\LoginService;
use Illuminate\Support\Facades\Redis;

class Login extends Controller
{

    /**
     * @url /index.php/api/v1/lgoin
     * @param string username 用户名
     * @param string password 密码 
     * return code 200 成功 >= 400失败
     */
    public function login (AdminRequest $request)
    {
        $request->validate('login');
        $name = $request->input('username');
        $password = $request->input('password');
        $ip = $request->ip();
        $info = $name.$ip;
        $num = Redis::get($info);
        if( $num > 3){
            return $this->_error('登录错误次数过多请在5分钟后再试！');
        }
        try{
            Redis::set($name, 1, 300);
            $loginService = new LoginService();
            $data = $loginService->login($name, $password);
            return $this->_success('成功', ['token' => $data]);
        }catch(\Exception $e){
            Redis::incr($name);
            return $this->_error($e->getMessage()); // 错误信息 $e->getMessage
        }
    }
}