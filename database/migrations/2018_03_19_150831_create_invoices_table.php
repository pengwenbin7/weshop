<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("order_id")->unique();
            $table->string("admin_name")->nullable();
            $table->boolean("status")->default(0)
                ->comment("0: 未申请; 1： 已申请; 2: 已开票; 3: 已发出");
            $table->string("ship_no")->nullable()->comment("快递单号");
            $table->unsignedInteger("address_id");
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("order_id")->references("id")->on("orders");
            $table->foreign("address_id")->references("id")->on("addresses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
