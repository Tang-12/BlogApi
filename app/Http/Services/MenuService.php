<?php
namespace App\Http\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuService extends BaseService
{
  public function nav()
  {
    $data = Menu::where('status', 1)->select('parentId', 'id', 'name', 'url', 'menu', 'type', 'icon', 'sort', 'iframe')->get();
    return $data;
  }
  /**
   * 菜单列表
   */
  public function list()
  {
    $data = Menu::select('parentId', 'id', 'name', 'url', 'menu', 'type', 'icon', 'sort', 'iframe')->get();
    return $data;
  }

  public function createMenu($pid, $name,$icon, $path, $controller, $methods, $is_nav)
  {
    $level = 0;
    if($pid > 0) {
      $parent_id = Menu::where('id', $pid)->first();
      $level = $parent_id['level'] + 1;
    }
    $info = Menu::where(['name'=> $name, 'is_nav'=> $is_nav])->first();
    if($info) {
      throw new \Exception('该菜单已添加，请勿重复添加', 400);
    }
    $menu = new Menu();
    $menu->pid = $pid;
    $menu->name = $name;
    $menu->icon = $icon;
    $menu->path = $path;
    $menu->controller = $controller;
    $menu->methods = $methods;
    $menu->is_nav = $is_nav;
    $menu->level = $level;
    $menu->save();
    return $menu;
  }

  public function updateMenu($id, $pid, $name,$icon, $path, $controller, $methods, $is_nav)
  {
    $parent_id = Menu::where('id', $pid)->first();
    $menu = Menu::find($id);
    if($parent_id['pid'] == 0){
      $level = 0;
    }else{
      $level = $parent_id['level']+1;
    }
    $menu->pid = $pid;
    $menu->name = $name;
    $menu->icon = $icon;
    $menu->path = $path;
    $menu->level = $level;
    $menu->controller = $controller;
    $menu->methods = $methods;
    $menu->is_nav = $is_nav;
    $menu->updated_at = date('Y-m-d H:i:s', time());
    return $menu->save();
  }

  public function changeStatus($id)
  {
    $count = Menu::where('pid', $id)->count();
    if ($count > 0)
    {
      throw new ModelNotFoundException('有子级菜单无法禁用');
    }
    $menu = Menu::find($id);
    $menu->status = $menu['status'] == 0 ? 1 :0;
    return $menu->save();
  }
  /**
   * 单个删除&多个删除
   */
  public function deletedMenu($id)
  {
    if(!is_array($id))
    {
      $count = Menu::where('pid', $id)->count();
      if ($count > 0)
      {
        throw new ModelNotFoundException('有子级菜单无法删除');
      }
      return Menu::destroy($id);
    }
    return Menu::destroy($id);
  }
}
