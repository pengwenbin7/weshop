<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 40)->nullable()->comment('标题');
            $table->string('text_type', 30)->comment('业务类型');
            $table->string('result', 30)->comment('变更结果');
            $table->string('ending', 40)->nullable()->comment('结尾说明');
            $table->string('link', 200)->comment('链接');
            $table->string('user_type', 10)->comment('用户类型');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing');
    }
}
