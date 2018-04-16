<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_distances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("from");
            $table->unsignedInteger("to");
            $table->unsignedBigInteger("distance");
            $table->timestamps();
            $table->unique(["from", "to"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_distances');
    }
}
