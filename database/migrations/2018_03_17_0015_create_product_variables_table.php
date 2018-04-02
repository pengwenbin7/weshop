<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("product_id");
            $table->unsignedInteger("stock")->default(0)->comment("库存");
            $table->unsignedInteger("click")->default(0)->comment("点击");
            $table->unsignedInteger("star")->default(0)->comment("关注");
            $table->unsignedInteger("buy")->default(0)->comment("购买");
            $table->unsignedInteger("back")->default(0)->comment("退货");
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
        Schema::dropIfExists('product_variables');
    }
}
