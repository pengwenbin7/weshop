<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("payments", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("order_id");
            $table->string("prepay_id", 64)->nullable()
                ->comment("微信预支付ｉｄ");
            $table->unsignedTinyInteger("channel_id");
            $table->unsignedDecimal("total", 10, 2)->comment("总价");
            $table->unsignedDecimal("tax", 10, 2)->default(0)->comment("税");
            $table->unsignedDecimal("freight", 10, 2)->default(0)->comment("运费");
            $table->unsignedDecimal("coupon_discount", 10, 2)->default(0)->comment("优惠券减免");
            $table->unsignedDecimal("share_discount", 10, 2)->default(0)->comment("分享减免");
            $table->unsignedDecimal("pay_discount", 10, 2)->default(0)->comment("支付方式减免");
            $table->unsignedDecimal("pay", 10, 2)->nullable()->comment("应付价");
            $table->unsignedDecimal("paid", 10, 2)->default(0)->comment("已支付");
            $table->bigInteger("pay_time", false, true)->nullable();
            $table->timestamps();
            $table->foreign("order_id")->references("id")
                ->on("orders")->onDelete("cascade");
            $table->foreign("channel_id")->references("id")->on("pay_channels");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
