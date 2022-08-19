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
      'article_title' => 'required|max: 50',
      'content' => 'required',
      'limit' => 'integer',
      'category_id' =>'required|integer',
    ];
  }
  /**
   * verified messages
   * @return strings
   */
  public function messages()
  {
    return [
      'article_title.required' => '文章标题必须',
      'article_title.max' => '文章最多为50个字符',
      'content.required' => '文章内容必须',
      'limit.integer' => '分页数必须是数字',
      'category_id.required' => '文章分类不能为空',
      'category_id.integer' => '文章分类id必须是数组'
    ];
  }

  // verification scenes
  public $scenes = [
    'list' => ['limit'],
    'add' => ['article_title', 'content', 'category_id'],
    'update' => ['id','article_title', 'content', 'category_id'],
    'status' => ['id'],
    'deleted' => ['id'],
  ];
}
