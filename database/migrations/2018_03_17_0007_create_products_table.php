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
            $table->string("model", 32)->unique();
            $table->unsignedDecimal("content", 10, 2)->comment("含量(eg: 25)")->default(25);
            $table->string("measure_unit", 16)->comment("计量单位(eg: kg)")->default("kg");
            $table->string("packing_unit", 16)->comment("包装单位(eg: 包)")->default("包");
            // 25kg/包 <--> $content $unit / $packing_unit
            $table->boolean("is_ton")->default(false)->comment("是否可以按吨计价");
            $table->boolean("active")->default(true);
            $table->unsignedSmallInteger("sort_order")->default(1000);
            $table->string("keyword", 255)->nullable();
            $table->string("unique_code", 8)->nullable()->unique()
                ->comment("crc32(locale_id + name + brand_id + storage_id + model + content + measure_unit + packing_unit)");
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->foreign("storage_id")->references("id")->on("storages");
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
