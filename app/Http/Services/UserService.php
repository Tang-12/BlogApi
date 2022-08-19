<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\User as ModelUser;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
  public function userList($name, $limit)
  {
    $where = [];
    if(!empty($name)){
      $where[] = ['name', 'like', '%'.$name.'%'];
    }
    return ModelUser::where($where)
      ->select('id', 'name', 'email', 'created_at', 'status')
      ->withCount('articles')
      ->paginate($limit);
  }

  public function userCreated($name, $password, $email)
  {
    if (User::where('name', $name)->first()){
      throw new \Exception('该用户名已存在，请再想想', 400);
    }
    if (User::where('email', $email)->first()){
      throw new \Exception('该邮箱已存在，请换个邮箱再试试', 400);
    }
    $pwd = Hash::make($password);
    $user = new User();
    $user->name = $name;
    $user->password = $pwd;
    $user->email = $email;
    $user->save();
  }

  public function userStatus($id)
  {
    $user = User::find($id);
    $user->status = $user['status'] == 0 ? 1 : 0;
    $user->save();
    return $user;
  }

  public function updated($id, $name, $password, $email)
  {
    $user = User::find($id);
    $user->name = $name;
    if(!empty($password)){
      $user->password = Hash::make($password);
    }
    $user->email = $email;
    $user->updated_at = date('Y-m-d H:i:s', time());
    $user->save();
  }

  public function deleted($id)
  {
    return User::destroy($id);
  }
}
