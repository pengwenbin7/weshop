<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 考虑到可能会清理地址，而在from, to 唯一的情况下，不需要清理距离缓存
         * 这里的 from, to 是 addresses 表的 id， 但不使用外键约束
         */
        Schema::create('address_distances', function (Blueprint $table) {
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
        Schema::dropIfExists('address_distances');
    }
}
