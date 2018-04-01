<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("payment_id")->nullable();
            $table->unsignedInteger("shipment_id")->nullable();
            $table->unsignedInteger("admin_id")->nullable();
            $table->boolean("active")->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("shop_users");
            $table->foreign("payment_id")->references("id")->on("payments");
            $table->foreign("shipment_id")->references("id")->on("shipments");
            $table->foreign("admin_id")->references("id")
                ->on("admin_users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
