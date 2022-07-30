<?php
namespace App\Http\Services;

class BaseService 
{
  public function _success($msg = '', $data = [])
  {
    echo json_encode(['code' => 200, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
  }

  public function _error($msg = '', int $code = 400, $data = array())
  {
    echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>$data], JSON_UNESCAPED_UNICODE);
  }
  /**
   * 无限极分类
   */
  protected function treeList($data) 
  {
    $items = [];
    foreach($data as $value) 
    {
      $items[$value['id']] = $value;
    }
    $tree = [];
    foreach($items as $k=> $v)
    {
      if(isset($items[$v['pid']]))
      {
        $items[$v['pid']]['children'][] = &$items[$k];
      }else{
        $tree = &$items[$k];
      }
    }
    return $tree;
  }
}