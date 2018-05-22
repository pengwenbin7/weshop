<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_channels', function (Blueprint $table) {
            $table->tinyIncrements("id");
            $table->string("name", 100);
            $table->text("params")->nullable();
            $table->boolean("active")->default(true);
            $table->boolean("is_vip")->default(false);
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
        Schema::dropIfExists('pay_channels');
    }
}
