<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Services\LoginService;
use Illuminate\Support\Facades\Redis;

class Login extends Controller
{

    public function register(AdminRequest $request)
    {
        try{
            $name = $request->input('username');
            $password = $request->input('password');
            $repass = $request->input('repass');
            $request->validate('register');
            $loginService = new LoginService();
            $loginService->register($name, $password, $repass);
            return $this->_success('成功');
        }catch(\Exception $e){
            return $this->_error($e->getMessage());
        }
    }

    public function login (AdminRequest $request)
    {
        $request->validate('login');
        $name = $request->input('username');
        $password = $request->input('password');
        $num = Redis::get($name);
        if( $num > 3){
            return $this->_error('登录错误次数过多请在5分钟后再试！');
        }
        try{
            Redis::set($name, 1, 300);
            $loginService = new LoginService();
            $data = $loginService->login($name, $password);
            return $this->_success('成功', ['token' => $data, 'name' => $name]);
        }catch(\Exception $e){
            Redis::incr($name);
            return $this->_error($e->getMessage()); // 错误信息 $e->getMessage
        }
    }
}