<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttrItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->unsignedInteger("attr_group_id");
            $table->enum("value_type", ["text", "single", "multiple"]);
            $table->text("options")->nullable();
            $table->timestamps();
            $table->foreign("attr_group_id")->references("id")->on("attr_groups");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attr_items');
    }
}
