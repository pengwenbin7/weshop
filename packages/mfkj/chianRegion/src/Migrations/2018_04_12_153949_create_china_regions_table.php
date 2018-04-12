<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChinaRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('china_regions', function (Blueprint $table) {
            $table->unsignedInteger("id");
            $table->string("name", 32);
            $table->string("fullname", 32);
            $table->unsignedDecimal("lat", 9, 6);
            $table->unsignedDecimal("lng", 9, 6);
            $table->unsignedInteger("parent_id")->default(0);
            $table->timestamps();
            $table->primary("id");
        });

        Schema::create("china_region_versions", function (Blueprint $table) {
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
        Schema::dropIfExists('china_regions');
        Schema::dropIfExists("china_region_versions");
    }
}
