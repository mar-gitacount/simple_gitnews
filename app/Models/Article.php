<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    /**
     * 一対多の処理多側、articleの処理。
     * 
     *  */  
    public function user(){
        return $this->belongsTo('App\models\User');
    }
    
    /**
     * 一対多の多側、article
     * votingとarticleのリレーション
    */
    public function voting(){
        return $this->belongsTo('App\models\Voting');
    }
}
