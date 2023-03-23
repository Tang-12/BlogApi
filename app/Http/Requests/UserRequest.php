<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
  /**
   * verified rules for admin requests
   * @return array
   */
  public function rules()
  {
    return [
      'id' => 'required|numeric',
      'username' => 'required|max: 8',
      'password' => 'required|min: 6|max: 12',
      'email' => 'email:rfc,dns',
      'limit' => 'numeric',
    ];
  }

  public function messages()
  {
    return [
      'id.required' => '用户id不能为空',
      'id.numeric' => '用户id必须是数字',
      'username.required' => '用户名必须',
      'username.max' => '用户名最多可为8个字符',
      'password.required' => '密码不能为空',
      'password.min' => '密码最少为6位',
      'password.max' => '密码最多可为12位',
      'email.email' => '邮箱格式错误',
      'limit.numeric' => '分页必须是数字'
    ];
  }

  public $scenes = [
    'list' => ['limit'],
    'created' => ['username', 'password','email'],
    'updated' => ['id', 'username', 'email'],
    'deleted' => ['id'],
    'status' => ['id'],
    'info' => ['id'],
  ];
}
