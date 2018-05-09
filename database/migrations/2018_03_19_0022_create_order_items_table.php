<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("order_id");
            $table->unsignedInteger("product_id")->nullable();
            $table->unsignedInteger("number");
            $table->unsignedDecimal("price", 10, 2);
            // storage_id 不使用外键，程序可以保证不会出错
            $table->unsignedInteger("storage_id")->nullable();
            // 以下为快照
            $table->string("product_name", 100);
            $table->string("model", 100);
            $table->string("brand_name", 100);
            $table->string("packing_unit", 100);
            $table->timestamps();
            $table->foreign("order_id")->references("id")
                ->on("orders")->onDelete("cascade");
            $table->foreign("product_id")
                ->references("id")
                ->on("products")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
