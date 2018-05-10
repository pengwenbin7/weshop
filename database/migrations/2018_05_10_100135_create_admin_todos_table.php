<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_todos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("admin_id");
            $table->string("url");
            $table->string("note");
            $table->timestamps();
            $table->foreign("admin_id")
                ->references("id")->on("admin_users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_todos');
    }
}
