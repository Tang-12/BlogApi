<?php
namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article as ModelsArticle;

class Article extends Controller
{
  public function articleList()
  {

  }

  /**
   * 添加博客文章
   * @url /adminApi/v1/articles/created
   */
  public function articleCreate(ArticleRequest $request)
  {
    $request->validate('add');
    try { 
      $u_id = $this->getAuthenticatedInfo();
      $article = new ModelsArticle;
      $article->user_id = $u_id['u_id'];
      $article->article_title = $request->input('title');
      $article->desc = $request->input('desc');
      $article->content = $request->input('content');
      $article->save();
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e);
    }
  }
}