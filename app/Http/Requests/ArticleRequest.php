<?php
namespace App\Http\Requests;

class ArticleRequest extends BaseRequest
{
  /**
   * verified rules for article requests
   * @return array
   */
  public function rules()
  {
    return [
      'id' => 'required|integer',
      'title' => 'required|max: 50',
      'content' => 'required',
      'limit' => 'number',
    ];
  }
  /**
   * verified messages
   * @return strings
   */
  public function messages()
  {
    return [
      'title.required' => '文章标题必须', 
      'title.max' => '文章最多为50个字符', 
      'content.required' => '文章内容必须', 
    ];
  }

  // verification scenes
  public $scenes = [
    'list' => ['limit'],
    'add' => ['title', 'content'],
    'update' => ['id','title', 'content'],
    'status' => ['id'],
    'deleted' => ['id'],
  ];
}