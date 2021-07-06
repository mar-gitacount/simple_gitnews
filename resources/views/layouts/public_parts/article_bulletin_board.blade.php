
<section class="comment">
    <h3>記事にコメントする</h3>
    {{-- article_postした後にルーティングに$article_id_numberを渡して記事ページに戻るようにする。 --}}
    <form id = "comment_form" name = "comment_form" method = "POST" action = "{{ route('article_bulletin_comment',['article_id_number' => $article_id_number ])}}">
        {{ csrf_field() }}
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <div class="submit">
            <input class="button" id = "comment_btn" type="submit" name="" value="投稿する" onclick="devalert()">
        </div>
    </form>
    {{-- DBから渡された値をここにaタグ --}}
    <div class="comment_items_containar">
        {{-- for文でコメントを回してその中でaタグ,返信とする。 --}}
        <dl>
            1 名前:<span>名無し</span>
        </dl>
    </div>
    <script>
        function devalert(){
            alert("現在作成中の機能です。");
        }
    </script>
</section>