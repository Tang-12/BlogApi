<?php
namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Services\ArticleService;
use App\Models\Article as ModelsArticle;

class Article extends Controller
{
  /**
   * 文章列表
   * Requests methods: POST
   * @url /adminApi/v1/articles/list
   * return 200 成功 >=400 失败
   */
  public function articleList(ArticleRequest $request)
  {
    $request->validate('list');
    try {
      $title = $request->input('keyword');
      $limit = $request->input('limit', 20);
      $articleService = new ArticleService();
      $data = $articleService->articleList($title, $limit);
      return $this->_success('成功', $data);
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 添加博客文章
   * @url /adminApi/v1/articles/created
   * Request method: POST
   * returns 200 成功 >=400 失败
   */
  public function articleCreate(ArticleRequest $request)
  {
    $request->validate('add');
    try {
      $u_id = $this->getAuthenticatedInfo();
      $category_id = $request->input('category_id');
      $title = $request->input('article_title');
      $desc = $request->input('desc');
      $content = $request->input('content');
      $articleService = new ArticleService();
      $articleService->createArticle($u_id['u_id'], $title, $desc, $content, $category_id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 修改文章
   * Request method: POST
   * @url /adminApi/v1/articles/updated
   * returns 200 成功 >=400 失败
   */
  public function editArticle(ArticleRequest $request)
  {
    $request->validate('update');
    try{
      $id = $request->input('id');
      $category_id = $request->input('category_id');
      $title = $request->input('article_title');
      $desc = $request->input('desc');
      $content = $request->input('content');
      $articleService = new ArticleService();
      $articleService->updateArticle($id, $title, $desc, $content, $category_id);
      return $this->_success('成功');
    }catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 文章状态
   * Request method: GET
   * @url adminApi/v1/articles/status
   * returns 200 成功 >=400 失败
   */
  public function articleStatus(ArticleRequest $request)
  {
    try {
      $request->validate('status');
      $id = $request->get('id');
      $articleService = new ArticleService();
      $articleService->articleStatus($id);
      return $this->_success('成功');
    } catch (\Exception $e) {
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 删除文章
   * Request method: GET
   * @url /adminApi/v1/articles/deleted
   * @param Array $id
   * returns 200 成功 >=400 失败
   */
  public function deletedArticles(ArticleRequest $request)
  {
    try{
      $request->validate('deleted');
      $id = $request->input('id');
      $articleService = new ArticleService();
      $articleService->deletedArticle($id);
      return $this->_success('成功');
    } catch(\Exception $e){
      return $this->_error($e->getMessage());
    }
  }

  /**
   * 数据回显
   * Request method: GET
   * @url /api/v1/articles/info
   * @params int  id
   * return 200 成功 >=400失败
   */

  public function articleInfo(ArticleRequest $request)
  {

      try {
        $id = $request->input('id', 0);
        $data = ModelsArticle::join('users', 'articles.user_id', '=', 'users.id')
          ->where('articles.id', $id)
          ->select('articles.id', 'articles.article_title', 'articles.desc', 'articles.content', 'articles.category_id', 'users.name')
          ->first();
        return $this->_success('成功', $data);
      }catch (\Exception $e){
        return $this->_error('失败');
      }
  }
}
