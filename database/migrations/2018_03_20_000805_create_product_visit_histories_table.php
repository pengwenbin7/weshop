<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVisitHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_visit_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->nullable();
            $table->unsignedInteger("product_id");
            $table->enum("platform", ["pc", "phone", "tablet", "android-app", "ios-app", "unknow"])->default("unknow");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("shop_users")
                ->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("products")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_visit_histories');
    }
}
