<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_stars', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("brand_id");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("shop_users")
                ->onDelete("cascade");
            $table->foreign("brand_id")->references("id")->on("brands")
                ->onDelete("cascade");
            $table->primary(["user_id", "brand_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_stars');
    }
}
