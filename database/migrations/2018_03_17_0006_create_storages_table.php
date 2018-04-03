<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger("locale_id")->default(1);
            $table->string("name", 100)->unique();
            $table->unsignedInteger("brand_id");
            $table->unsignedInteger("address_id");
            $table->text("description")->nullable();
            $table->boolean("active")->default(true);
            $table->timestamps();
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->foreign("address_id")->references("id")->on("addresses");
            $table->foreign("brand_id")->references("id")->on("brands");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}
