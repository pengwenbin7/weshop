<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("product_id");
            $table->unsignedDecimal("unit_price", 10, 2)->comment("每包装单位价(eg: ￥/kg)");
            $table->unsignedDecimal("ton_price", 10, 2)->comment("吨价")->nullable();
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
}
