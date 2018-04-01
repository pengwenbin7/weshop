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
            $table->increments('id');
            $table->unsignedInteger("order_id");
            $table->string("product_name", 100);
            $table->string("category_name", 100);
            $table->string("product_model", 100);
            $table->string("brand_name", 100);
            $table->string("supplier_name", 100);
            $table->string("storage_name", 100);
            $table->unsignedDecimal("content", 10, 2)->nullable();
            $table->string("measure_unit", 16)->nullable();
            $table->string("packing_unit", 16)->nullable();
            $table->boolean("ton_sell")->default(true);
            $table->unsignedInteger("price");
            $table->unsignedInteger("number");
            $table->timestamps();
            $table->foreign("order_id")->references("id")
                ->on("orders")->onDelete("cascade");
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
