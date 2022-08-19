<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Models\User as ModelsUser;
use Exception;

class User extends Controller
{
  public function userList(UserRequest $request)
  {
    $request->validate('list');
    try {
      $name = $request->input('username');
      $limit = $request->input('limit', 20);
      $userService = new UserService();
      $res = $userService->userList($name, $limit);
      return $this->_success('成功', $res);
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function created(UserRequest $request)
  {
    $request->validate('created');
    try {
      $name = $request->input('username');
      $password = $request->input('password');
      $email = $request->input('email');
      $userService = new UserService();
      $userService->userCreated($name, $password, $email);
      return $this->_success('成功');
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function userStatus(UserRequest $request)
  {
    $request->validate('status');
    try{
      $id = $request->input('id');
      $userService = new UserService();
      $userService->userStatus($id);
      return $this->_success('成功');
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function userInfo(UserRequest $request)
  {
    $request->validate('info');
    try{
      $id = $request->input('id');
      $result = ModelsUser::where('id', $id)->select('id', 'name', 'email')->first();
      return $this->_success('成功', $result);
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function userUpdate(UserRequest $request)
  {
    $request->validate('updated');
    try{
      $id = $request->input('id');
      $name = $request->input('username');
      $password = $request->input('password');
      $email = $request->input('email');
      $userService = new UserService();
      $userService->updated($id, $name, $password, $email);
      return $this->_success('成功');
    }catch (Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function deletedUser(UserRequest $request)
  {
    $request->validate('deleted');
    try{
      $id = $request->input('id');
      $userService = new UserService();
      $userService->deleted($id);
      return $this->_success('成功');
    }catch (Exception $e) {
      return $this->_error($e->getMessage());
    }
  }
}
