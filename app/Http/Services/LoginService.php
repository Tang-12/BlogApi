<?php
namespace App\Http\Services;

use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService extends BaseService
{
  /**
   * 注册
   */
  public function register($name, $password, $repass)
  {
    if($password !== $repass) {
      throw new ModelNotFoundException('密码不一致，请重新确认密码');
    }
    $info = Admin::where('name', $name)->first();
    if(isset($info))
    {
      throw new ModelNotFoundException('该用户名已存在，请再想想');
    }
    if($info['status'] == 1)
    {
      throw new ModelNotFoundException('该用户名已被禁用,禁止注册');
    }
    $passwordhash = Hash::make($password);
    $admin = new Admin();
    $admin->name = $name;
    $admin->password = $passwordhash;
    $admin->save();
    return $admin;
  }

  /**
   * 登录
   */
  public function login($name, $password)
  {
    $info = Admin::where('name', $name)->first();
    if (!$info) {
        throw new ModelNotFoundException('用户不存在');
    }
    if($info['status'] == 1) {
        throw new ModelNotFoundException('用户已被冻结');
    }
    if(!Hash::check($password, $info['password'])) {
        throw new ModelNotFoundException('密码错误');
    }
    $data = Admin::where('name', $name)->select('id', 'name')->first();
    $token = JWTAuth::fromUser($data);
    $res = 'bearer '.$token;
    return $res;
  }
}