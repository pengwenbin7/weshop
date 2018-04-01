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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger("channel_id");
            $table->unsignedDecimal("total", 10, 2)->comment("总价");
            $table->unsignedDecimal("tax", 10, 2)->default(0)->comment("税");
            $table->unsignedDecimal("freight", 10, 2)->default(0)->comment("运费");
            $table->unsignedDecimal("coupon", 10, 2)->default(0)->comment("优惠");
            $table->unsignedDecimal("pay", 10, 2)->comment("应付价");
            $table->unsignedTinyInteger("status")->default(0)
                ->comment("0: 未付款, 1: 待付款, 2: 已付款, 3: 退款中, 4: 驳回退款, 5: 退款确定");
            $table->timestamp("pay_time")->nullable();
            $table->timestamp("ask_return_time")->nullable()->comment("发起退款时间");
            $table->timestamp("refuse_time")->nullable()->comment("驳回退款时间");
            $table->timestamp("confirm_return_time")->nullable()->comment("确认退款时间");
            $table->timestamps();
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
