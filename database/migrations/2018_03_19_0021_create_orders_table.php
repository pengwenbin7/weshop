<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("orders", function (Blueprint $table) {
            $table->increments("id");
            $table->string("no", 18)->nullable();
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("address_id")->nullable();
            $table->unsignedInteger("coupon_id")->nullable()
                ->comment("优惠券");
            $table->unsignedInteger("tax_id")->nullable()
                ->comment("税");
            $table->unsignedTinyInteger("payment_status")
                ->default(0)->comment("付款状态:0-未付款,1-部分付款,2-已付款,3-退款,4-到付,5-错误");
            $table->unsignedTinyInteger("refund_status")
                ->default(0)->comment("退货状态:0-未退货,1-申请退货,2-等待退货,3-已退货");
            $table->boolean("active")->default(true);
            $table->boolean("shared")->default(false);
            $table->timestamp("expire")->nullable();
            $table->unsignedInteger("admin_id")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("address_id")->references("id")
                ->on("addresses")->onDelete("set null");
            $table->foreign("coupon_id")->references("id")
                ->on("coupons");
            $table->foreign("tax_id")->references("id")
                ->on("taxes");
            $table->foreign("admin_id")->references("id")
                ->on("admin_users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
