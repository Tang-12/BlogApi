<?php
namespace App\Http\Requests;

class AdminRequest extends BaseRequest
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
      'limit' => 'required|numeric',
      'auth_id' => 'required|numeric',
    ];
  }

  /**
   * verified msg for admin requests
   * @return strings
   */
  public function messages()
  {
    return [
      'username.required' => '用户名必须',
      'username.min' => '用户最多只能为8个字符',
      'password.required' => '密码必须',
      'password.min' => '密码最少不能低于6位',
      'password.max' => '密码最大不能超过12位',
      'limit.required' => '分页不能为空',
      'limit.numeric' => '分页必须是数字',
      'auth_id.required' => '权限不能为空',
      'auth_id.numeric' => '权限参数必须是数字',
    ];
  }

  public $scenes = [
    'list' => ['limit'],
    'add' => ['username', 'password', 'auth_id'],
    'update' => ['id', 'username', 'auth_id'],
    'delete' => ['id'],
    'status' => ['id'],
    'info' => ['id'],
    'login' => ['username', 'password'],
    'register' => ['username', 'password'],
  ];
}
