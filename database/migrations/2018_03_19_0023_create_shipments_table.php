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
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedDecimal("freight", 10, 2)->comment("运费");
            $table->string("from_address")->comment("发货地");
            $table->string("to_address")->comment("收货地");
            $table->string("ship_no")->comment("物流单号");
            $table->string("contact_name", 100)->nullable();
            $table->string("contact_phone", 100)->nullable();
            $table->date("expect_arrive_date")->nullable();
            $table->date("arrive_date")->nullable();
            $table->softDeletes();
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
