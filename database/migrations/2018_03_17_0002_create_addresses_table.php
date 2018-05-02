<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("addresses", function (Blueprint $table) {
            $table->increments("id");
            $table->string("contact_name", 32)->comment("联系人");
            $table->string("contact_tel", 16)->nullable()->comment("联系电话");
            $table->string("country", 100)->default("中华人民共和国");
            $table->string("province", 32);
            $table->string("city", 32);
            $table->string("district", 32)->nullable();
            $table->string("detail", 100);
            $table->unsignedInteger("code");
            $table->unsignedDecimal("lat", 9, 6)->nullable();
            $table->unsignedDecimal("lng", 9, 6)->nullable();
            $table->boolean("countable")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
