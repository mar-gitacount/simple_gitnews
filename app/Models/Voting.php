<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;
   /*  public $timestamps = false; */
   public function articles(){
    /**
     * リレーション一対多の関係
     * voting(1):article(多)
     * articleテーブルを新しい順で更新する。
     * 
     * 
    */
    return $this->hasMany('App\Models\Article')->latest();
   }
}
