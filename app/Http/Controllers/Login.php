<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login extends Controller
{
    public function register(AdminRequest $request)
    {
        $request->validate('register');
        $name = $request->input('name');
        $password = $request->input('password');
        $repass = $request->input('repass');
        if($password !== $repass) {
            return $this->_error('密码不一致，请重新确认密码');
        }
        $info = Admin::where('name', $name)->first();
        if(isset($info))
        {
            return $this->_error('该用户名已存在，请再想想');
        }
        if($info['status'] == 1)
        {
            return $this->_error('该用户名已被禁用,禁止注册');
        }
        try{
            $passwordhash = Hash::make($password);
            $admin = new Admin();
            $admin->name = $name;
            $admin->password = $passwordhash;
            $admin->save();
            return $this->_success('成功');
        }catch(\Exception $e){
            return $this->_error($e);
        }
    }

    public function login (AdminRequest $request)
    {
        try{
            $request->validate('login');
            $name = $request->input('name');
            $password = $request->input('password');
            $info = Admin::where('name', $name)->first();
            if (!$info) {
                return $this->_error('用户不存在');
            }
            if($info['status'] == 1) {
                return $this->_error('用户已被冻结');
            }
            if(!Hash::check($password, $info['password'])) {
                return $this->_error('密码错误');
            }
            $data = Admin::where('name', $name)->select('id', 'name')->first();
            $token = JWTAuth::fromUser($data);
            return $this->_success('成功', $token);
        }catch(\Exception $e){
            return $this->_error($e->getMessage()); // 错误信息 $e->getMessage
        }
    }
}