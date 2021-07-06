<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use Laravel\Ui\Presets\React;
use App\developer_functions\Article_functions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ArticleController extends Controller
{


    public function __construct()
    {
        /* articleに行くときは認証判定 */
        //$this->middleware('auth');
    }



    public function index()
    {
    }

    public function store(Request $request)
    {
        /* 新しく記事を投稿する宣言 */
        $article = new Article();
        /** 
         * バリデーションを設定する。
         */

        $validator = Validator::make($request->all(), [
            /* 入力必須255文字 form のarticleのバリデーションチェック*/
            'article' => 'required|max:100',
            //'article_text' => 'required|min:1'
        ]);
        if ($validator->fails()) {
            return redirect('/home/article')
                ->withInput()
                ->withErrors($validator);
        }
        /**
         * 以下はブレードファイルのarticleのnameを指定して値をとっている。
         * この処理はarticleの内容を保存している。
         * ->articleはカラム
         * articleのidが表示される。
         */
        $article->user_id = $request->user()->id;
        $blade_text = $request->article_text;
        $create_time = Article_functions::timezone_ja();
        $article->created_at = $create_time;
        $past_articles = $request->user()->articles->first();
        if (!$past_articles == null) {
            $past_articles = $past_articles->id;
            $blade_file_name = $past_articles + 1;
        } else {
            $blade_file_name = 0;
        }
        $blade_file_name = $blade_file_name . ".php";
        /* ファイル作成 */
        /* ディレクトリ作成 */
        //View::makeDirectory('./public/user_articles/'.$article->user_id);
        /*  Storage::put($blade_file_name, $blade_text);
        Storage::move($blade_file_name, './public/user_articles/'.$article->user_id.'/'.$blade_file_name); */
        /* 投稿タイトルをarticleカラムに保存する */
        $article->article = $request->article;
        $gunle_num = $request->gunle_num;
        $gunle_num = (int)$gunle_num;
        //ジャンルの数字をarticleテーブルのgunle_numに保存する。
        $article->gunle_number = $gunle_num;
        /**
         * ブレードファイルの修正後試してみる
         * $create_time = Article_functions::timezone_ja();
         * $article->created_at = $create_time;
         */
        //$article->created_at = $create_time;
        /*curl -X POST https://api.github.com/markdown/raw -H 'Content-Type: text/plain' -d '## Hello World' > user_id_yymmdd.html  */
        /**
         * 例:
         * "user_id" => 3
         * "article" => "title"
         * "article_text" => 本文
         * "updated_at" => "2021-01-05 03:11:39"
         * "created_at" => "2021-01-05 03:11:39"
         * "id" => 34←これをURLにする。
         * 
         */
        $article->save();
        return redirect(("/home"));
    }
    public function article()
    {
        /**
         * 以下でarticle.blade.phpを表示している。
         * articleの作成ページの処理。
         *  */
        return view('article');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $articleUserResult = $article->user_id;
        $articleUser = User::find($articleUserResult);
        //以下をuser_articles/user_id/user_id_YYYY_MMMM.blade.phpに変更する。ブレードファイルの文言はDBに保存する。ディレクトリはarticleUserResultを利用する。
        //return view('article_display')->with('article', $article)->with( 'articleUser',$articleUser);
        return view('article_display')->with([
            'article' => $article,
            'articleUser' => $articleUser,
        ]);
    }
    public function article_update_page_show($id)
    {
        /** 
         *
         * 編集するためのページを表示、articleの値を呼び出してブレードファイルに吐き出すを呼び出す。 
         * return でブレードファイルであるarticle_update_page_showを返す。
         */
        $article = Article::findOrFail($id);
        return view('article_update_page_show', ['article' => $article]);
    }
    public function update(Request $request)
    {
        /** 
         * 投稿内容を編集するためのコントローラー
         * $article_form =  $request -> all();で更新した投稿内容を取得している。
         * 元のarticle→$article = Article::find($request->id);
         */
        $article = Article::find($request->id);
        $article_id = $article->id;
        $gunle_num = $request->gunle_num;
        $gunle_num = (int)$gunle_num;
        //ジャンルの数字をarticleテーブルのgunle_numに保存する。
        $article->gunle_number = $gunle_num;
        $validator = Validator::make($request->all(), [
            'article' => 'required|max:100',
            //'article_text' => 'required|min:1'
        ]);
        if ($validator->fails()) {
            return redirect('home/article_update_page_show/' . $article_id)
                ->withInput()
                ->withErrors($validator);
        }
        $article_form =  $request->article;

        $create_time = Article_functions::timezone_ja();
        $article->created_at = $create_time;

        $article->article = $article_form;
        $article->save();
        return redirect('home');
    }
    public function delete(Request $request)
    {
        $article = Article::find($request->id);
        $article->delete();
        return redirect('home');
    }
    public function article_search(Request $request)
    {
        $input = $request->input;
        //空文字が入ってきた時はトップにそのまま戻る。
        if ($input == null) {
            return redirect("/");
        }
        $article_query = Article::query();
        //$articles = Article::select(['article'])->get();
        //呼び出したいテーブルとそのカラムを引数に渡す。
        $articles = Article_functions::replace($input, $article_query)->paginate(5);
        return view('votings', ['articles' => $articles]);
    }
    public function article_gunle_page_show(Request $request)
    {
        $gunle = $request->gunle_num;
        $article_query = Article::query();
        $articles_gunle = Article_functions::gunle_choice($gunle, $article_query)->paginate(5);
        return view('votings', ['articles' => $articles_gunle]);
    }
    // 記事の掲示板の処理
    public function article_bulletin_comment(Request $request, $article_id_number)
    {
        // urlパラメータ(数字)
        $current_article_id_number = (int)$article_id_number;
        // 記事コメントに対しての掲示板コメントを設定
        $commment = $request->comment;
        return redirect('articleview/' . $current_article_id_number);
    }
}
