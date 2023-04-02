<?php
namespace App\Http\Services;

use App\Models\Menu;

class IndexService extends BaseService
{
  public function indexList(string $menuIds)
  {
    $list = Menu::where('is_nav', 0)->whereNull('deleted_time')->whereIn($menuIds)->select('id', 'pid' ,'name as menuName', 'icon', 'path')->get()->toArray();
    return $this->treeList($list);
  }
}