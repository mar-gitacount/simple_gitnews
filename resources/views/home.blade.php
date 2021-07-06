@extends('layouts.app')
@section('content')
<link href="{{ asset('css/home.blade.css')}}" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" class="col-sm-offset-2 col-sm-8">
                <div class="card-header">{{ __('マイページ') }}</div>
                <div class="home_profile_wrap">
                    <div class="row">
                    <div class="col-4 home_pic"><img src="public/storage/user_images/{{$user->user_prf}}" alt=""></div>
                    <div class="col-8 home_my_profile_info">
                        <div class="home_name">{{ Auth::user()->name }}</div>                     
                        <div class="mail">{{ Auth::user()->email }}</div>
                        <div class="user_id">{{ Auth::user()->id }}</div>
                    </div>
                    </div>
                </div>
                <!-- ここにユーザーの記事一覧を表示する。 -->
                <table class="table table-striped">
                <thead>
                　　@if (count($user -> articles) > 0)
                        <tr>
                            <th>{{ __('あなたの投稿一覧') }}</th>
                        </tr>
                    @endif
                    <!-- ログイン中のユーザー=user その中のarticles -->
                    @foreach($user -> articles as $article)
                        <tr>
                            <td>
                                <!-- articleテーブルのarticletitleに変更 -->                 
                                <?php
                                        $articleresult = $article->article;
                                        $string_dot = "..";
                                        //articleの文字列を0～5まで指定して切り取り代入
                                        $string_mb_substr = mb_substr($articleresult,0,10);
                                        $string_mb_substr = $string_mb_substr.$string_dot;
                                ?>
                                    <a href = "{{ route('article_display', ['id' => $article->id])}}">{{$string_mb_substr}} </a><br>		                    <div class = "row">
                                    <a href="{{ route('article_update_page_show', ['id' => $article->id])}}"><img src="public/storage/icon_edit.png" class="icon-image"></a>
                                    <form action="{{ route('article_delete' , ['id' => $article->id])}}" method="post">
                                    @method('DELETE')
                                    @csrf           
                                    <input type="image" src="public/storage/icon_trash.png" class="icon-image">
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </thead>
                </table>
                <a  href="{{ url('/') }}">
                    <button type="submit" class="btn btn-light">おすすめ記事一覧へ飛ぶ</button>
                </a>
                <a href="{{route('article')}}"><button type="submit" class="btn btn-light">記事作成ページへ移動する。</button></a>
                <a href="{{route('user_manegemet')}}"><button type="submit" class="btn btn-secondary active">ユーザー情報を編集、管理はこちら</button></a>
                <!-- <form action="{{ route('user_delete')}}" method="post" id="user_delete_form">
                    @method('DELETE')
                    @csrf                
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Okボタンを押すとすべてのユーザー情報を削除してしまい、復活もできません。よろしいですか？')">
                    <i class="fa fa-trash">{{ __('ユーザー情報を削除する。(直ぐ消えます)') }}</i>       
                    </button>
                </form> -->
                <!--  -->
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('ログインされています。') }}
                </div>
            </div>
        </div>      
    </div>
    <div class="d-flex justify-content-center mb-5">{{$user->articles->links()}}</div>
</div>
@endsection
