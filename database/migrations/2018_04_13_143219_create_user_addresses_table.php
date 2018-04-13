<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("address_id");
            $table->timestamps();
            $table->foreign("user_id")->references("id")
                ->on("users");
            $table->foreign("address_id")->references("id")
                ->on("addresses");
            $table->unique(["user_id", "address_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
