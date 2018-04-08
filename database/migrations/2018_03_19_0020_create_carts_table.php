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
            $table->string("product_model", 100);
            $table->boolean("is_ton")->default(false)
                ->comment("是否按吨购买");
            $table->unsignedInteger("number");
            $table->unsignedDecimal("init_price");
            $table->boolean("active")->default(true);
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
