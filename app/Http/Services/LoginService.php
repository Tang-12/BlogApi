<?php
namespace App\Http\Services;

use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService extends BaseService
{
  /**
   * 登录
   */
  public function login($name, $password)
  { 
    $info = Admin::where('username', $name)->select('id','username','password','status')->first();
    if (empty($info)) 
    {
        throw new ModelNotFoundException('用户不存在');
    } 
    if($info['status'] == 0)
    {
      throw new ModelNotFoundException('该账号已被禁用');
    }
    if(!Hash::check($password, $info['password'])) 
    {
        throw new ModelNotFoundException('密码错误');
    }   
    $data = Admin::where('username', $name)->select('id', 'username')->first();
    $token = JWTAuth::fromUser($data);
    $res = 'bearer '.$token;
    
    // TDO 
    $param = DB::table('admins')->join('auths', 'admins.auth_id', '=','auths.auth_ids')->select('auths.auth_ids')->where('admins.id', $data['id'])->get()->toArray();
    $list = serialize($param);
    Redis::set($res, $list);
    return $res;
  }
}