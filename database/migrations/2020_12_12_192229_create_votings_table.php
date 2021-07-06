<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()/*up()メソッド内はSchemaクラスのメソッドcreate()を利用してテーブルの作成コードなどを記述します。*/
    {
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->timestamps();
        });
        /* softdeleteの処理を書く、正しく動くかはわからない、、 */
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()/* down()メソッド内は、同じくSchemaクラスのdropIfExists()メソッドを利用してテーブルの削除コードを記述します。 */
    {
        Schema::dropIfExists('votings');
    }
}
