<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer("id");
            $table->unsignedTinyInteger("locale_id")->default(1);
            $table->string("name", 100);
            $table->unsignedInteger("brand_id");
            $table->unsignedInteger("storage_id");
            $table->unsignedInteger("model_id");
            $table->unsignedDecimal("content", 10, 2)->comment("含量(eg: 25)")->default(25);
            $table->string("measure_unit", 16)->comment("计量单位(eg: kg)")->default("kg");
            $table->string("packing_unit", 16)->comment("包装单位(eg: 包)")->default("包");
            // 25kg/包 <--> $content $unit / $packing_unit
            $table->boolean("ton_sell")->default(true)->comment("是否可以按吨计价");
            $table->unsignedSmallInteger("sort_order")->default(1000);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->primary(["id", "locale_id"]);
        });

        Schema::table("products", function (Blueprint $table) {
            $table->integer("id", true, true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
