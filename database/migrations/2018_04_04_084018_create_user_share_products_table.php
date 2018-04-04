<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShareProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_share_products', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("product_id");
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("shop_users")
                ->onDelete("cascade");
            $table->foreign("product_id")->references("id")
                ->on("products")->onDelete("set null");
            $table->unique(["user_id", "product_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_share_products');
    }
}
