<?php
namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Services\AdminService;
use App\Models\Admin as ModelsAdmin;
use Exception;

class Admin extends Controller
{
  public function listUsers(AdminRequest $request)
  {
    $request->validate('list');
    try{
      $name = $request->input('username');
      $limit = $request->input('limit', 10);
      $adminService = new AdminService();
      $res = $adminService->adminList($name, $limit);
      return $this->_success('成功', $res);
    }catch(Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  public function addAdmin(AdminRequest $request)
  {
    $request->validate('add');
    try {
      $name = $request->input('username');
      $nickname = $request->input('nickname');
      $password = $request->input('password');
      $repass = $request->input('repass');
      $authId = $request->input('auth_id');
      $adminService = new AdminService();
      $adminService->addAdmin($name, $password, $repass, $authId, $nickname);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }


  public function updateAdmin(AdminRequest $request)
  {
    $request->validate('update');
    try {
      $id = $request->input('id');
      $name = $request->input('username');
      $password = $request->input('password');
      $authId = $request->input('auth_id');
      $adminService = new AdminService();
      $adminService->updateAdmin($id, $name, $password, $authId);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function statusAdmin(AdminRequest $request)
  {
    $request->validate('status');
    try{
      $id = $request->input('id');
      $adminService = new AdminService();
      $adminService->statusAdmin($id);
      return $this->_success('成功');
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  public function deletedAdmin(AdminRequest $request) 
  {
    $request->validate('delete');
    try {
      $id = $request->input('id');
      $adminService = new AdminService();
      $adminService->deleteAdmin($id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }
}