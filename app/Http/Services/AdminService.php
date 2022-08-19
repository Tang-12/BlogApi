<?php
namespace App\Http\Services;

use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdminService extends BaseService
{
  public function adminList($name, $limit)
  {
    $where  = [];
    if(!empty($name)){
      $where[] = ['admins.name', 'like', '%'.$name.'%'];
    }
    $result = Admin::leftjoin('auth', 'admins.auth_id', '=', 'auth.id')
    ->where($where)
    ->select('admins.id','admins.name', 'admins.status', 'admins.created_at', 'auth.name as auth_name')
    ->orderBy('id', 'asc')
    ->paginate($limit);
    return $result;
  }

  public function addAdmin($name, $password, $repass, $authId)
  {
    if($password != $repass)
    {
      throw new Exception('密码不一致', 400);
    }
    $info = Admin::where('name', $name)->first();
    if($info)
    {
      throw new Exception('该用户名已存在');
    }
    if($info['status'] != 0)
    {
      throw new Exception('该管理员已被禁用，请换一个再试一下');
    }
    $admins = new Admin();
    $admins->name = $name;
    $admins->password = Hash::make($password);
    $admins->auth_id = $authId;
    $admins->save();
    return $admins;
  }

  public function updateAdmin($id, $name, $password, $authId)
  {
    if(Admin::where('name', $name)->count() > 1)
    {
      throw new Exception('该用户名已存在，请再想想');
    }
    $updated = [];
    $updated['name'] = $name;
    $updated['auth_id'] = $authId;
    $updated['created_at'] = date('Y-m-d H:i:s', time());
    if(!empty($password))
    {
      $updated['password'] = Hash::make($password);
    }
    return Admin::where('id', $id)->update($updated);
  }

  public function statusAdmin($id)
  {
    $auth = Admin::where('id', $id)->select('auth_id')->first();
    if($auth['auth_id'] != 1)
    {
      throw new Exception('没有该操作权限', 400);
    }
    $admins = Admin::find($id);
    $admins->status = $admins['status'] == 0 ? 1 : 0;
    $admins->save();
    return $admins;
  }

  public function deleteAdmin($id)
  {
    $info = Admin::select('id' ,'auth_id')->first();
    if($info['auth_id'] != 1)
    {
      throw new Exception('没有该操作权限', 400);
    }
    return Admin::destroy($id);
  }
}