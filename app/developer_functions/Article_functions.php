<?php
namespace App\developer_functions;

class Article_functions{
    //時間取得する。日本時間
    public static function timezone_ja(){
        date_default_timezone_set('Asia/Tokyo');
        $time = date('Y-m-d H:i:s');
        return $time;
    }
    //ファイル名を付けるための海外時間の時間後から↑↑を使って日本時間にするかも
    public static function file_name(){
        $time_name = date("Y-m-d H:i:s");
        return $time_name; 
    }
    // 検索機能の関数
    public static function replace($input,$quary){
        $quary = $quary -> where('article', 'LIKE' ,"%{$input}%")->orderBy('created_at', 'desc');
        return $quary;
    }
    //ジャンル一覧
    public function gunle_first($num){
        $nowgunle = array("ゲーム,漫画","おもしろ","ニュース","IT・テクノロジー");
        return $nowgunle[$num];
    }

    public function gunle(){
        $nowgunle = array("ゲーム,漫画","おもしろ","ニュース","IT・テクノロジー");
        return $nowgunle;
    }

    //ジャンル機能振り分け
    public static function gunle_choice($gunlenum,$query){
        $gunlenum = (int)$gunlenum;
        $query = $query -> where('gunle_number',"{$gunlenum}")->orderBy('created_at', 'desc');
        //dd($query);
        return $query;
    }
}
?>