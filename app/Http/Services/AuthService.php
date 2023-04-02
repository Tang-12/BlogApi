<?php
namespace App\Http\Services;

use App\Models\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthService extends BaseService
{
  public function authList($name, $limit)
  {
    $where = array();
    if (!empty($name))
    {
      $where[] = ['name', 'like', '%' . $name. '%'];
    }
    $list = Auth::where($where)->orderBy('created_at', 'desc')->get();
    return $this->treeList($list);
  }
  /**
   * 添加权限
   */
  public function addAuth($name, $desc, $auth_ids)
  {
    $info = Auth::where('name', $name)->first();
    if (isset($info)) {
      throw new ModelNotFoundException('该权限已添加，请勿重复添加');
    }
    $auth = new Auth();
    $auth->name = $name;
    $auth->desc = $desc;
    $auth->auth_ids = $auth_ids;
    $auth->save();
  }

  /**
   * 更新权限
   */
  public function updateAuth($id, $name, $desc, $auth_id)
  { 
    $auth = Auth::find($id);
    $auth->name = $name;
    $auth->desc = $desc;
    $auth->auth_ids = $auth_id;
    $auth->updated_at = date('Y-m-d H:i:s', time());
    $auth->save();
  }

  /**
   * 修改权限状态
   */
  public function authStatus($id)
  {
    $auth = Auth::find($id);
    $auth->status = $auth['status'] == 0 ? 1 : 0;
    $auth->updated_at = date('Y-m-d H:i:s', time());
    $auth->save();
  }

  /**
   * 删除权限
   */
  public function deletedAuth($id)
  {
    if ($id == 1)
    {
      throw new ModelNotFoundException('超级管理员禁止删除');
    }
    return Auth::destroy($id);
  }
}
