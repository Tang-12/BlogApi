<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article;
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
    Route::get('articles/status', [Article::class, 'articleStatus']);
    Route::get('articles/deleted', [Article::class, 'deletedArticles']);
    //菜单权限api
    Route::get('auth/list', [Menu::class,'menuList']);
    Route::post('auth/create', [Menu::class,'createMenu']);
    Route::post('auth/update', [Menu::class,'updateMenu']);
    Route::get('auth/status', [Menu::class,'menuStatus']);
    Route::get('auth/delete', [Menu::class,'deletedMenu']);
});