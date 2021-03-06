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
      'username' => 'required|max: 8',
      'password' => 'required|min: 6|max: 12',
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
      'name.min' => '用户最多只能为8个字符',
      'password.required' => '密码必须',
      'password.min' => '密码最少不能低于6位',
      'password.max' => '密码最大不能超过12位',
    ];
  }

  public $scenes = [
    'login' => ['name', 'password'],
    'register' => ['name', 'password'],
  ];
}