<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("invoice_id");
            $table->string("product_name", 100);
            $table->string("product_model", 100);
            $table->string("brand_name", 100);
            $table->unsignedDecimal("content", 10, 2);
            $table->string("measure_unit", 16);
            $table->string("packing_unit", 16);
            $table->unsignedInteger("number");
            $table->unsignedDecimal("price", 10, 2);
            $table->timestamps();
            $table->foreign("invoice_id")->references("id")->on("invoices");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
