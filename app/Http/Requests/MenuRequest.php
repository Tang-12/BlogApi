<?php
namespace App\Http\Requests;

class MenuRequest extends BaseRequest
{
  /**
   * verify rules
   */
  public function rules()
  {
    return [
      'id' => 'required',
      'pid' => 'required|numeric',
      'title' => 'required|max: 10',
      'is_nav' => 'required|in:0,1',
      'limit' => 'numeric',
    ];
  }

  /**
   * verify message types
   */
  public function messages()
  {
    return [
      'id.required' => 'Id必须',
      'pid.required' => '父级Id必须',
      'pid.numeric' => 'Id必须是数字',
      'title.required' => '标题必须',
      'title.max' => '标题最多只能有10个字符',
      'is_nav.required' => '是否设为菜单',
      'is_nav.in' => '只能设置为菜单或者方法',
      'limit.numeric' => '分页必须是数字',
    ];
  }

  public $scenes = [
    'list' => ['limit'],
    'add' => ['pid', 'title', 'is_nav'],
    'update' => ['id', 'pid', 'title', 'is_nav'],
    'status' => ['id'],
    'deleted' => ['id'],
  ];
}