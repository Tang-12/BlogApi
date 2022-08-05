<?php
namespace App\Http\Services;

use App\Models\Menu;

class IndexService extends BaseService
{
  public function indexList()
  {
    $list = Menu::where('is_nav', 0)->whereNull('deleted_time')->select('id', 'pid' ,'name as menuName', 'icon', 'path')->get()->toArray();
    // dd($list);
    return $this->treeList($list);
  }
}