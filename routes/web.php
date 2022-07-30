<?php

use App\Http\Controllers\Article;
use App\Http\Controllers\Login;
use App\Http\Controllers\Menu;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('adminApi/v1')->group(function(){
    Route::post('register', [Login::class, 'register']);
    Route::post('login', [Login::class, 'login']);
});

Route::prefix('adminApi/v1')->middleware(['refresh.token', 'api.cross'])->group(function(){
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