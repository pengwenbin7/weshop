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
            $table->unsignedInteger("storage_id")->nullable();
            $table->string("sell_unit", 16);
            $table->unsignedInteger("number");
            $table->unsignedDecimal("price", 10, 2);
            // 以下为快照
            $table->string("product_name", 100);
            $table->string("category_name", 100);
            $table->string("model", 100);
            $table->string("brand_name", 100);
            $table->string("storage_name", 100);
            $table->timestamps();
            $table->foreign("order_id")->references("id")
                ->on("orders")->onDelete("cascade");
            $table->foreign("storage_id")->references("id")
                ->on("storages")->onDelete("set null");
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
