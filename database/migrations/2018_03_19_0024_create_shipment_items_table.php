<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("shipment_id");
            $table->string("product_name", 100);
            $table->string("product_model", 100);
            $table->string("brand_name", 100);
            $table->unsignedInteger("number");
            $table->string("packing_unit", 16)->nullable();
            $table->timestamps();
            $table->foreign("shipment_id")->references("id")
                ->on("shipments");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_items');
    }
}
