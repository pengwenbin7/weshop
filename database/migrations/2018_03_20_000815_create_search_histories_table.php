<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->increments('id');
            /* 为什么这两个字段都可以为空呢？
             * 我认为是存在这种情况的：有人没登录，然后用搜索功能随便看看 */
            $table->unsignedInteger("user_id")->nullable();
            $table->string("keyword", 100)->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_histories');
    }
}
