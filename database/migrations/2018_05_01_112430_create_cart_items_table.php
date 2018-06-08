<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("cart_id");
            $table->unsignedInteger("product_id")->nullable();
            $table->unsignedInteger("number")->default(1);
            $table->boolean("checked")->default(0);
            $table->foreign("cart_id")
                ->references("id")
                ->on("carts")
                ->onDelete("cascade");
            $table->foreign("product_id")
                ->references("id")
                ->on("products")
                ->onDelete("set null");
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
        Schema::dropIfExists('cart_items');
    }
}
