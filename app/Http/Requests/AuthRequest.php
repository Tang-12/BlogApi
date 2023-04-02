<?php
namespace App\Http\Requests;

class AuthRequest extends BaseRequest
{
  // verify rules
  public function rules()
  {
    return [
      'id' => 'required|integer',
      'name' => 'required|max:10|min:2',
      'desc' => 'string|max:50',
      'auth_id' => 'required|string',
      'limit' => 'integer'
    ];
  }

  public function messages()
  {
    return [
      'id.required' => 'id不能为空',
      'id.integer' => 'id必须是数字',
      'name.required' => '权限名不能为空',
      'name.max' =>'权限名最多不能超过10个字符',
      'name.min' =>'权限名最少不能低于2个字符',
      'auth_id.required' =>'权限id不能为空',
      'auth_id.string' => '权限id必须是字符串',
      'limit.integer' => '分页必须是数字'
    ];
  }

  public $scenes = [
    'list' => ['limit'],
    'add' => ['name', 'desc', 'auth_id'],
    'update' => ['id','name', 'desc', 'auth_id'],
    'status' => ['id'],
    'deleted' => ['id'],
  ];
}