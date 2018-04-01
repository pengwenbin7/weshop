<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("product_id")->nullable();
            $table->string("product_name", 100);
            $table->string("product_model_name", 100);
            $table->string("category_name", 100);
            $table->string("brand_name", 100);
            $table->string("storage_name", 100);
            $table->string("supplier_name", 100);
            $table->unsignedDecimal("content", 10, 2)->nullable();
            $table->string("measure_unit", 16)->nullable();
            $table->string("packing_unit", 16)->nullable();
            $table->unsignedInteger("number");
            $table->boolean("ton_sell")->default(1);
            $table->timestamps();
            $table->foreign("user_id")->references("id")
                ->on("shop_users")
                ->onDelete("cascade");
            $table->foreign("product_id")->references("id")
                ->on("products")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
