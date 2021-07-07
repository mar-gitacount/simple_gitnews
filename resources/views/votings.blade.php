@extends('layouts.app')
@section('content')
{{-- <head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/top.css') }}">
</head> --}}
<div class="container">
    <div class="col-sm-10 main_items">
        <!-- 記事一覧 -->
        <!-- 以下の変数を置き換える検索を押したらserch_resultにする -->
        @if (count($articles)>0)
        <div class="panel-body">
            <div class="panel-heading article_top">
                記事一覧
            </div>
            @inject('gunle', 'App\developer_functions\Article_functions')
            <div class="panel-heading">
                {{-- <div class="gunle_wrap">
                    <div class=""><a href = "{{route('gunle', ['gunle_num' => 0])}}">{{$gunle -> gunle(0)}}</a></div>
                    <div class=""><a href = "{{route('gunle', ['gunle_num' => 1])}}">{{$gunle -> gunle(1)}}</a></div>
                    <div class=""><a href = "{{route('gunle', ['gunle_num' => 2])}}">{{$gunle -> gunle(2)}}</a></div>
                    <div class=""><a href = "{{route('gunle', ['gunle_num' => 3])}}">{{$gunle -> gunle(3)}}</a></div>
                </div> --}}
                    @inject('gunle', 'App\developer_functions\Article_functions')
                    <div class="gunle_wrap"> 
                        <?php
                            $gunle = $gunle -> gunle();
                        ?>
                        <?php foreach ($gunle as $index => $item):?>
                        <div class="gunle"><a href = "{{route('gunle', ['gunle_num' =>  $index  ])}}"><?php echo $item?></a></div> 
                        <?php endforeach;?>
                    </div>
                    {{-- <div id="app">
                        <example-component></example-component>
                    </div> --}}
            </div>
            <div class="panel-body">
                <table class="table table-striped task-table">
                        <tbody>
                        @foreach ($articles as $article)
                        　　@csrf
                                <tr>
                                <!-- ここにurlの投稿一覧を表示する -->
                                <!-- 以下にaタグをつかってとりあえずarticle_idをddできるようにする。
                                接続するにはまずコントローラ側で/article/{id}で指定しなければならない。 
                                'id' => $article->id←これでarticleのidを取得している。
                                -->
                                <?php
                                  //以下でarticleの値を格納する。
                                $articleresult = $article->article;
                                  //削られた文字に足し合わせるためのドット
                                $string_dot = "..";
                                  //articleの文字列を0～5まで指定して切り取り代入
                                $string_mb_substr = mb_substr($articleresult,0,30);
                                $string_mb_substr = $string_mb_substr.$string_dot;
                                ?>
                                <td class="table-text">
                                    <div class="table-text">
                                        <a href = "{{ route('article_display', ['id' => $article->id])}}">
                                        　{{$string_mb_substr}}
                                        </a>
                                    </div>
                                </td>
                                <td class="table-text"><div class="table-text">{{ $article->user_id }}</div></td>
                                <td class="table-text"><div class="table-text">{{ $article->id }}</div></td>
                                <td class="table-text"><div class="table-text">{{ $article->created_at }}</div></td>
                            　  </tr>
                            @endforeach
                        </tbody>
                    </table>      
                </div>
            </div>
        @endif     
    </div>
    {{-- ページネーション --}}
    {{$articles->appends(request()->input())->links('pagination::simple-bootstrap-4') }}
</div>
@endsection
