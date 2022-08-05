<?php
namespace App\Http\Requests;

class CategoryRequest extends BaseRequest
{
  // category verify rules
  public function rules()
  {
    return [
      'id' => 'required|numeric',
      'pid' => 'numeric',
      'title' => 'required|string|min: 2|max:12',
    ];
  }
  // verify message
  public function messages()
  {
    return [
      'id.required' => 'id不能为空',
      'id.numeric' => 'id必须是数字',
      'pid.numeric' => '父级id必须是数字',
      'title.required' => '分类标题不能为空',
      'title.string' => '分类标题必须是字符串',
      'title.min' => '分类标题最少不能低于2个字符',
      'title.max' => '分类标题最少不能多于12个字符',
    ];
  }

  public $scenes = [
    'list' => ['title'],
    'created' => ['pid', 'title'],
    'updated' => ['id' ,'pid', 'title'],
    'status' => ['id'],
    'deleted' => ['id']
  ];
}