<?php
namespace App\Http\Services;

use App\Models\Article as ModelsArticle;

class ArticleService extends BaseService
{
  /**
   * 文章列表
   */
  public function articleList($title, $limit = 20)
  {
    $where = [];
    if(!empty($title)) {
      $where[] = ['article_title', 'like', '%'.$title.'%'];
    }
    $data = ModelsArticle::join('users', 'articles.user_id', '=', 'users.id')
      ->join('categories', 'articles.category_id', '=', 'categories.id')
      ->where($where)
      ->select('articles.id', 'articles.article_title', 'articles.desc', 'articles.status', 'articles.created_at', 'articles.category_id', 'users.name', 'categories.title as category_name')
      ->orderBy('created_at', 'desc')
      ->paginate($limit);
    return $data;
  }

  /**
   * 添加文章
   */
  public function createArticle($u_id, $title, $desc, $content, $category_id)
  {
    $article = new ModelsArticle;
    $article->user_id = $u_id;
    $article->article_title = $title;
    $article->desc = $desc;
    $article->content = $content;
    $article->category_id = $category_id;
    $article->save();
    return $article;
  }

  /**
   * 更新文章
   */
  public function updateArticle($id, $title, $desc, $content, $category_id)
  {
      $article = ModelsArticle::find($id);
      $article->article_title = $title;
      $article->desc = $desc;
      $article->content = $content;
      $article->updated_at = date('Y-m-d H:i:s', time());
      $article->category_id = $category_id;
      $article->save();
      return $article;
  }

  /**
   * 状态修改
   */
  public function articleStatus( int $id)
  {
    $article = ModelsArticle::find($id);
    $article->status = $article['status'] == 0 ? 1 : 0;
    $article->save();
    return $article;
  }

  /**
   * 删除文章
   * @param Array $id
   */
  public function deletedArticle($id)
  {
    return ModelsArticle::destroy($id);
  }
}
