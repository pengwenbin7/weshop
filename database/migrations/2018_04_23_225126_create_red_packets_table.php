<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('red_packets', function (Blueprint $table) {
            $table->increments('id');
            $table->string("mch_billno", 28);
            $table->string("mch_id", 32);
            $table->string("wxappid", 32);
            $table->string("send_name", 32);
            $table->string("re_openid", 32);
            $table->unsignedInteger("total_amount");
            $table->unsignedInteger("total_num")->default(1);
            $table->string("wishing", 128);
            
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
        Schema::dropIfExists('red_packets');
    }
}
