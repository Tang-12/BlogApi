<?php
namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;

class Auth extends Controller
{
  public function authList(AuthRequest $request)
  {
    $request->scene('list');
    try {
      $name = $request->input('name');
      $limit = $request->input('limit', 10);
      $AuthService = new AuthService();
      $reult = $AuthService->authList($name, $limit);
      return $this->_success('成功', $reult);
    }catch (\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function createAuth(AuthRequest $request)
  {
    $request->scene('add');
    try {
      $name = $request->input('name');
      $desc = $request->input('desc');
      $auth_id = $request->input('auth_id');
      $authService = new AuthService();
      $authService->addAuth($name, $desc, $auth_id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function authInfo(AuthRequest $request)
  {
    $request->scene('info');
    try{
      $id = $request->input('id');
      $authService = new AuthService();
      $result = $authService->authInfo($id);
      return $this->_success('成功', $result);
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function editAuth(AuthRequest $request)
  {
    $request->scene('update');
    try {
      $id = $request->input('id');
      $name = $request->input('name');
      $desc = $request->input('desc');
      $auth_id = $request->input('auth_id');
      $authService = new AuthService();
      $authService->updateAuth($id, $name, $desc, $auth_id);
      return $this->_success('成功');
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function authStatus(AuthRequest $request)
  {
    $request->scene('status');
    try {
      $id = $request->input('id');
      $authService = new AuthService();
      $authService->authStatus($id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function deletedAuth(AuthRequest $request)
  {
    $request->scene('deleted');
    try {
      $id = $request->input('id');
      $authService = new AuthService();
      $authService->deletedAuth($id);
      return $this->_success('成功');
    }catch(\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }
}
