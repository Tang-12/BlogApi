<?php
namespace App\Http\Services;

use App\Models\Article as ModelsArticle;

class ArticleService extends BaseService
{
  /**
   * 文章列表
   */
  public function articleList($title, int $limit)
  {
    $where = [];
    if(!empty($title)) {
      $where[] = ['article_title', 'like', '%'.$title.'%'];
    } 
    $data = ModelsArticle::where($where)
    ->select('id', 'user_id', 'article_title', 'desc', 'status', 'created_at')
    ->paginate($limit);
    return $data;
  }

  /**
   * 添加文章
   */
  public function createArticle($u_id, $title, $desc, $content)
  {
    $article = new ModelsArticle;
    $article->user_id = $u_id;
    $article->article_title = $title;
    $article->desc = $desc;
    $article->content = $content;
    $article->save();
    return $article;
  }

  /**
   * 更新文章
   */
  public function updateArticle($id, $title, $desc, $content)
  {
      $article = ModelsArticle::find($id);
      $article->article_title = $title;
      $article->desc = $desc;
      $article->content = $content;
      $article->updated_at = date('Y-m-d H:i:s', time());
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