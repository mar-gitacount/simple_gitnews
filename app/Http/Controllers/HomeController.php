<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     *     
     *  @return \Illuminate\Contracts\Support\Renderable
     * 
     */
    /**
      * requestメソッドだと呼びに行く。
       */  
    public function index(Request $request)
    {
        /**
         * user();には個々のユーザー情報が入っている
         * 
         * 
         * 
         * */
        /**
         * 
         * 個々のusertaleの情報が$userに入ってきている
        */
        $user = $request->user();
        /**
         * 
         * おそらくhomeurlにユーザー情報を流し込むイメージ
         * ルーティング側でgetを利用してhomeに移動していると思う。
         * conpact関数は配列を短く書くことができるuserの情報を配列に格納
         * userにはemail,username,passwordなどが格納されている。
         **
          */
        /**
         *
         * ここのhomeはblade.phpを指している??? 
         * homeURLにhome.blade.phpを読み込ませる???
         * with関数は配列型にしてデータをひとまとめにしている
         *  */
        //return view('home')->$user::with(['user'])->get();
        $user->articles = $user->articles()->paginate(5);
        return view('home')->with(compact('user'));  
    }

}