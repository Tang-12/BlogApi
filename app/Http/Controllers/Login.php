<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}