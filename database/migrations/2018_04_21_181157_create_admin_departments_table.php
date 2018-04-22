<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("admin_id");
            $table->unsignedInteger("department_id");
            $table->timestamps();
            $table->foreign("admin_id")
                ->references("id")
                ->on("admin_users")
                ->onDelete("cascade");
            $table->foreign("department_id")
                ->references("id")
                ->on("departments");
            $table->unique(["admin_id", "department_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_departments');
    }
}
