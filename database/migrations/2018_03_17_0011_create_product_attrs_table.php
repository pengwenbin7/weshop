<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attrs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger("locale_id")->default(1);
            $table->unsignedInteger("product_id");
            $table->string("key", 100);
            $table->string("value", 100);
            $table->timestamps();
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->foreign("product_id")->references("id")
                ->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attrs');
    }
}
