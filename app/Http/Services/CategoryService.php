<?php
namespace App\Http\Services;

use App\Models\Category;
use Exception;

class CategoryService extends BaseService
{
  /**
   * 分类列表
   */
  public function list($title)
  {
    $where = array();
    if(!empty($title)) {
      $where[] = ['title', 'like', '%'.$title.'%'];
    }
    $result = Category::where($where)->get()->toArray();
    $result = $this->treeList($result);
    return $result;
  }

  /**
   * 新增分类
   */
  public function created($pid, $title)
  {
    if(Category::where(['title' => $title])->first())
    {
      throw new Exception('该分类已添加，请勿重复添加', 400);
    }
    $level = 0;
    if($pid > 0)
    {
      $parent = Category::where('id', $pid)->first();
      $level = $parent['level']+1;
    }
    $category = new Category();
    $category->pid = $pid;
    $category->title = $title;
    $category->level = $level;
    $category->save();
  }

  /**
   * 修改分类
   */
  public function update($id, $pid, $title)
  {
    $level = 0;
    if($pid > 0)
    {
      $parent = Category::where('id', $pid)->first();
      $level = $parent['level']+1;
    }
    $category = Category::find($id);
    $category->pid = $pid;
    $category->title = $title;
    $category->level = $level;
    $category->updated_at = date('Y-m-d H:i:s', time());
    $category->save();
  }

  /**
   * 修改分类状态
   */
  public function status($id)
  {
    if(Category::where('pid', $id)->first()){
      throw new Exception('有子级菜单,无法禁用', 400);
    }
    $category = Category::find($id);
    $category->status = $category['status'] == 0 ? 1 : 0;
    $category->updated_at = date('Y-m-d H:i:s', time());
    $category->save();
  }

  /**
   * 删除分类
   */
  public function deleted($id)
  {
    return Category::destroy($id);
  }

  /**
   * 分类选项
   */
  public function select()
  {
    $result = Category::whereNull('deleted_time')->select('id', 'pid', 'title')->get()->toArray();
    $data = $this->treeList($result);
    return $data;
  }
}
