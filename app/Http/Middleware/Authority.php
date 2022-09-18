<?php
namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Auth;
use App\Models\Menu;
use Closure;

class Authority
{
  public function handle($request, Closure $next)
  {
    $path = substr($request->path(), 7);
    $menu = Menu::where(['path' => $path])->select(['id', 'path'])->first()->toArray(); // 查询菜单表
    $controller = new Controller();
    $info = $controller->getAuthenticatedInfo();
    $admin = Admin::where(['id' => $info['u_id']])->select('id','name', 'auth_id')->first()->toArray(); // 查询管理员表
    $auth = Auth::where(['id' => $admin['auth_id']])->select('id', 'name', 'auth_ids')->first()->toArray(); // 查询权限表
    $authIds = explode(',', $auth['auth_ids']);
    if(!in_array($menu['id'], $authIds)){
      echo json_encode(['code'=> 400, 'msg'=> '没有操作该权限，请联系管理员'], JSON_UNESCAPED_UNICODE);exit();
    }
    return $next($request);
  }
}