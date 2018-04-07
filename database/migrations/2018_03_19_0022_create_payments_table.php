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
            $table->unsignedTinyInteger("channel_id");
            $table->unsignedDecimal("total", 10, 2)->comment("总价");
            $table->unsignedDecimal("tax", 10, 2)->default(0)->comment("税");
            $table->unsignedDecimal("freight", 10, 2)->default(0)->comment("运费");
            $table->unsignedDecimal("coupon", 10, 2)->default(0)->comment("优惠");
            $table->unsignedDecimal("pay", 10, 2)->comment("应付价");
            $table->timestamp("pay_time")->nullable();
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
