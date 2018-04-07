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
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("address_id")->nullable();
            $table->unsignedDecimal("freight", 10, 2)
                ->default(0)->comment("用户支付运费");
            $table->unsignedInteger("coupon_id")->nullable()
                ->comment("优惠券");
            $table->unsignedInteger("tax_id")->nullable()
                ->comment("税");
            $table->unsignedTinyInteger("status")
                ->default(0)->comment("订单状态:0-未处理，1-处理中,2-完成,3-异常结束");
            $table->unsignedTinyInteger("payment_status")
                ->default(0)->comment("付款状态:0-未付款,1-部分付款,2-已付款,3-退款");
            $table->unsignedTinyInteger("shipment_status")
                ->default(0)->comment("发货状态：0-未发货,1-部分发货,2-发货完成,3-确认收货");
            $table->unsignedTinyInteger("refund_status")
                ->default(0)->comment("退货状态:0-未退货,1-申请退货,2-等待退货,3-已退货");
            $table->boolean("active")->default(true);
            $table->timestamp("expire")->nullable();
            $table->unsignedInteger("admin_id")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("shop_users");
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
