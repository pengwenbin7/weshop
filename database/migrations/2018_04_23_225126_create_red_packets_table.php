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
        /**
         * reference:
         * https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_4&index=3
         */
        Schema::create('red_packets', function (Blueprint $table) {
            // 以下为请求参数
            $table->increments('id');
            $table->string("mch_billno", 28);
            $table->string("mch_id", 32);
            $table->string("wxappid", 32);
            $table->string("send_name", 32);
            $table->string("re_openid", 32);
            $table->unsignedInteger("total_amount");
            $table->unsignedInteger("total_num")->default(1);
            $table->string("wishing", 128);
            $table->string("client_ip", 15)->nullable();
            $table->string("act_name", 32);
            $table->string("scene_id", 32)->nullable();
            $table->string("risk_info", 128)->nullable();
            $table->string("consume_mch_id", 32)->nullable();
            // 以下为回调参数
            $table->string("return_code", 16)->comment("SUCCESS/FAIL")->nullable();
            $table->string("return_msg", 128)->nullable();
            $table->string("sign", 32)->nullable();
            $table->string("result_code", 16)->nullable()->comment("SUCCESS/FAIL");
            $table->string("err_code", 32)->nullable();
            $table->string("err_code_des", 128)->nullable();
            $table->string("send_listid", 32)->nullable();
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
