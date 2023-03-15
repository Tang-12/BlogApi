<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article;
use App\Http\Controllers\Category;
use App\Http\Controllers\Index;
use App\Http\Controllers\Login;
use App\Http\Controllers\Menu;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::prefix('/v1')->group(function(){
    Route::post('register', [Login::class, 'register']);
    Route::post('login', [Login::class, 'login']);
});

Route::prefix('/v1')->middleware(['refresh.token'])->group(function(){
    Route::post('index/info', [Index::class, 'info']);
    Route::post('index/list', [Index::class, 'menuList']);
    // 文章Api路由
    Route::get('articles/list', [Article::class, 'articleList']);
    Route::post('articles/add', [Article::class, 'articleCreate']);
    Route::post('articles/update', [Article::class, 'editArticle']);
    Route::get('articles/info', [Article::class, 'articleInfo']);
    Route::get('articles/status', [Article::class, 'articleStatus']);
    Route::get('articles/deleted', [Article::class, 'deletedArticles']);
    //菜单权限api
    Route::get('menu/list', [Menu::class,'menuList']);
    Route::post('menu/create', [Menu::class,'createMenu']);
    Route::get('menu/info', [Menu::class,'infoMenu']);
    Route::post('menu/update', [Menu::class,'updateMenu']);
    Route::get('menu/status', [Menu::class,'menuStatus']);
    Route::get('menu/delete', [Menu::class,'deletedMenu']);
    // 分类路由
    Route::get('category/list', [Category::class, 'CategoryList']);
    Route::post('category/create', [Category::class, 'createdCategory']);
    Route::post('category/update', [Category::class, 'updatedCategory']);
    Route::get('category/info', [Category::class, 'info']);
    Route::get('category/status', [Category::class, 'categoryStatus']);
    Route::get('category/delete', [Category::class, 'categoryDelete']);
    Route::get('category/select', [Category::class, 'categorySelect']);
    // 用户
    Route::get('user/list', [\App\Http\Controllers\User::class, 'userList']);
    Route::post('user/created', [\App\Http\Controllers\User::class, 'created']);
    Route::get('user/info', [\App\Http\Controllers\User::class, 'userInfo']);
    Route::post('user/update', [\App\Http\Controllers\User::class, 'userUpdate']);
    Route::get('user/status', [\App\Http\Controllers\User::class, 'userStatus']);
    Route::get('user/deleted', [\App\Http\Controllers\User::class, 'deletedUser']);
    // 管理员
    Route::get('admin/list', [\App\Http\Controllers\Admin::class, 'listUsers']);
    Route::post('admin/add', [\App\Http\Controllers\Admin::class, 'addAdmin']);
    Route::get('admin/info', [\App\Http\Controllers\Admin::class, 'adminInfo']);
    Route::post('admin/edit', [\App\Http\Controllers\Admin::class, 'updateAdmin']);
    Route::get('admin/status', [\App\Http\Controllers\Admin::class, 'statusAdmin']);
    Route::get('admin/deleted', [\App\Http\Controllers\Admin::class, 'deletedAdmin']);
});