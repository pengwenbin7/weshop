<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("shipments", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("order_id");
            $table->boolean("purchase")->default(0)
                ->comment("采购状态");
            $table->boolean("status")->default(0)
                ->comment("发货状态");
            $table->unsignedDecimal("cost", 10, 2)
                ->default(0)->comment("采购成本");
            $table->unsignedDecimal("freight", 10, 2)
                ->default(0)->comment("运费");            
            $table->string("from_address")->comment("发货地");
            $table->string("to_address")->comment("收货地");
            $table->string("ship_no")->nullable()->comment("物流单号");
            $table->string("contact_name", 100)->nullable();
            $table->string("contact_phone", 100)->nullable();
            $table->string("license_plate", 32)->comment("车牌号")->nullable();
            $table->date("expect_arrive")->nullable();
            $table->date("arrive")->nullable();
            $table->timestamp("ship_time")->nullable();
            $table->foreign("order_id")->references("id")
                ->on("orders");
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
        Schema::dropIfExists('shipments');
    }
}
