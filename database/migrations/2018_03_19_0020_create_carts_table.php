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
            $table->string("name")->nullable();
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("address_id");
            $table->timestamps();
            $table->foreign("user_id")->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->foreign("address_id")->references("id")
                ->on("addresses");
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
