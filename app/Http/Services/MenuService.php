<?php
namespace App\Http\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuService extends BaseService
{
  /**
   * 菜单列表
   */
  public function list($name, $limit)
  {
    $where = [];
    if(!empty($name))
    {
      $where[] = ['name', 'like', '%'.$name.'%'];
    }
    $list = Menu::where($where)->whereNull('deleted_time')->select('id', 'pid', 'name', 'level', 'status', 'created_at', 'is_nav')->paginate($limit);
    $result = $this->treeList($list);
    return $result;
  }

  public function createMenu($pid, $name, $is_nav)
  {
    $level = 0;
    if($pid > 0) {
      $parent_id = Menu::where('id', $pid)->first();
      $level = $parent_id['level'] + 1;
    }
    $menu = new Menu();
    $menu->pid = $pid;
    $menu->name = $name;
    $menu->is_nav = $is_nav;
    $menu->level = $level;
    $menu->save();
    return $menu;
  }

  public function updateMenu($id, $pid, $name, $is_nav)
  {
    $parent_id = Menu::where('id', $pid)->first();
    $menu = Menu::find($id);
    $level = 0;
    $time = date('Y-m-d H:i:s', time());
    if($parent_id['level'] == 0){
      $level = 0;
    }else{
      $level = $parent_id['level']+1;
    }
    $menu->pid = $pid;
    $menu->level = $level;
    $menu->name = $name;
    $menu->is_nav = $is_nav;
    $menu->updated_at = $time;
    return $menu->save();
  }

  public function changeStatus($id)
  {
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