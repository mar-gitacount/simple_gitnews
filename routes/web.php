<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use App\Models\Voting;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\VotingController;
use App\Models\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;

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
/**
 * '/'にアクセスしたらvotingsを表示する処理。
  */
/*  Route::get('/', function () { 
    $votings = Voting::all();
    return view('votings', ['votings' => $votings]);
});  */

Route::resource('/',VotingController::class);
/* ログインするとトップページにいくこれをつかってマイページいける処理を書く */
/**
 * votingページにarticleの全てのページを並べる。
 * ルートゲットでarticleを持ってきて、投稿者と、投稿内容を表示する。
 * ユーザーページのようにテーブルにして表示するようにする。
 * コントローラを経由してコードを書く。
 * foreachで表示して、ページビューも行うようにする。(10くらい)
 * ここでvotingのarticleの処理をやはり書かないといけない。
 */
//Route::get('/',[App\Http\Controllers\ArticleController::class, 'index']);

// Route::post('/voting', function (Request $request) {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|max:255',
//     ]);
//     if ($validator->fails()) {
//         return redirect('/')
//             ->withInput()
//             ->withErrors($validator);    
//     } 
//     $voting = new Voting;
//     $voting->name = $request->name;
//     $voting->save();
//     return redirect('/');
// });


//ページネーションのルーティング

Route::delete('/voting/{voting}',function(Voting $voting){
    $voting->delete();
    /*トップページに置く*/
    return redirect('/');
});
/** 
 * 第一引数でuriに接続してhomeControllerを呼び出してdestoroyメソッドを利用する 
 *  index関数にuser情報かwithでひとまとめに渡されているはず!!
 * 
 * */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')/* rootで利用できるname設定 */;
/**
 * {}の中はコントローラの引数か
 */
Route::get('/home/user_manegement',[App\Http\Controllers\UserController::class,'index'])->name('user_manegemet');

Route::post('/user_manegement',[App\Http\Controllers\UserController::class,'update'])->name('update');

Route::delete('/home',[App\Http\Controllers\UserController::class, 'destroy'])->name('user_delete')->middleware('auth');
Auth::routes();
/** 
 *  第一引数のuriにarticle.blade.phpを入れている。
 * ここでarticleの各投稿ページのURLを生成する。
 * */
Route::get('/home/article','App\Http\Controllers\ArticleController@article')->name('article')->middleware('auth');
Route::post('/home/article',  [App\Http\Controllers\ArticleController::class, 'store'])->name('articlepost');

Route::post('/article_update_page_show', [App\Http\Controllers\ArticleController::class, 'update'])->name('article_update');

Route::get('/home/article_update_page_show/{id}',[App\Http\Controllers\ArticleController::class, 'article_update_page_show'])
->name('article_update_page_show')->middleware('auth');
Route::delete('/home/article','App\Http\Controllers\ArticleController@delete')->name('article_delete');
/**article/{id}に接続したとき、ArticleControllerのshowメソッドを呼び出す。{id}のブレードファイルに接続する。*/
Route::get('/articleview/{id}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article_display');

//掲示板をpost
Route::post("/articleview/{article_id_number}", 'App\Http\Controllers\ArticleController@article_bulletin_comment')->name('article_bulletin_comment');
//掲示板をgetして返信ボタンクリック⇨クリック時にidをルーティングに渡す。


//検索結果を返すコントローラへのルーティング
Route::get("/search",'App\Http\Controllers\ArticleController@article_search')->name('search');
//ジャンル事のページ設定
Route::get("/gunle/{gunle_num}",'App\Http\Controllers\ArticleController@article_gunle_page_show')->name('gunle');
