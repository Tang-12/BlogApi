<?php
namespace App\Http\Services;

use App\Models\Article as ModelsArticle;
use Illuminate\Support\Facades\DB;

class ArticleService extends BaseService
{
  /**
   * 文章列表
   */
  public function articleList($keyword, $limit = 20)
  {
    $data = DB::table('articles')
    ->join('users','articles.u_id','=','users.id')
    ->join('categories', 'articles.category_id','=','categories.id')
    ->select('articles.id','articles.title','articles.status','articles.created_at','categories.title as category_name','users.name')
    ->where(function($query) use($keyword){
      $query->orWhere('articles.title', 'like', '%'.$keyword.'%');
      $query->orWhere('categories.title', 'like', '%'.$keyword.'%');
      $query->orWhere('users.name', 'like', '%'.$keyword.'%');
    })
    ->orderBy('articles.created_at', 'desc')
    ->get();    
    return $data;
  }

  /**
   * 添加文章
   */
  public function createArticle($u_id, $title, $desc, $content, $category_id)
  {
    $article = new ModelsArticle;
    $article->u_id = $u_id;
    $article->title = $title;
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
      $article->title = $title;
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
