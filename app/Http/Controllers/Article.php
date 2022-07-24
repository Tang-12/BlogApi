<?php
namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Services\ArticleService;

class Article extends Controller
{
  /**
   * 文章列表
   * Requests methods: GET
   * @url /adminApi/v1/articles/list
   * return 200 成功 >=400 失败
   */
  public function articleList(ArticleRequest $request)
  {
    try {
      $request->validate('list');
      $title = $request->input('title');
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
    
    try {
      $request->validate('add');
      $u_id = $this->getAuthenticatedInfo();
      $title = $request->input('title');
      $desc = $request->input('desc');
      $content = $request->input('content');
      $articleService = new ArticleService();
      $articleService->createArticle($u_id['u_id'], $title, $desc, $content);
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
    try{
      $request->validate('update');
      $id = $request->input('id');
      $title = $request->input('title');
      $desc = $request->input('desc');
      $content = $request->input('content');
      $articleService = new ArticleService();
      $articleService->updateArticle($id, $title, $desc, $content);
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
}