<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("parent_id");
            $table->string("adcode", 9);
            $table->string("name", 32);
            $table->string("center")->nullable()->comment("经度,维度(longitude, latitude)");
            $table->enum("level", [
                "country", "province", "district",
                "city", "street",
            ]);
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
        Schema::dropIfExists('regions');
    }
}
