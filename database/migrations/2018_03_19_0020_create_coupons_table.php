<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedDecimal("discount", 10, 2);
            $table->unsignedDecimal("amount", 10, 2);
            $table->timestamp("expire")->nullable();
            $table->boolean("is_used")->default(false);
            $table->unsignedInteger("from_admin")->nullable();
            $table->string("description", 255)->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")
                ->on("users")->onDelete("cascade");
            $table->foreign("from_admin")->references("id")->on("admin_users")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
