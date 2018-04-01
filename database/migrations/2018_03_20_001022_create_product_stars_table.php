<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stars', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("product_id");
            $table->timestamps();
            $table->primary(["user_id", "product_id"]);
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
        Schema::dropIfExists('product_stars');
    }
}
