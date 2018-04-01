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
            $table->string("country", 100);
            $table->string("province", 100);
            $table->string("city", 100);
            $table->string("district", 100);
            $table->string("street", 100);
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
