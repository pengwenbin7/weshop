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
        Schema::create("regions", function (Blueprint $table) {
            $table->unsignedInteger("id");
            $table->unsignedInteger("parent_id");
            $table->string("name", 32)->nullable();
            $table->string("fullname", 32);
            $table->unsignedDecimal("lat", 9, 6);
            $table->unsignedDecimal("lng", 9, 6);
            $table->unsignedTinyInteger("level");
            $table->timestamps();
            $table->primary("id");
        });

        Schema::create("region_versions", function (Blueprint $table) {
            $table->increments("id");
            $table->string("version", 8);
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
        Schema::dropIfExists("regions");
        Schema::dropIfExists("region_versions");
    }
}
