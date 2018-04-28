<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments("id");
            $table->string("userid", 32)->unique();
            $table->string("openid", 100)->unique();
            $table->string("mobile", 32)->unique();
            $table->string("name", 32);
            $table->string("englishname", 32)->nullable();
            $table->string("email", 100)->unique()->nullable();
            $table->boolean("status");
            $table->boolean("enable");
            $table->string("position", 64)->nullable();
            $table->boolean("isleader");
            $table->boolean("gender")->default(0);
            $table->string("avatar")->nullable();
            $table->string("rec_code", 9)->nullable();
            $table->rememberToken();
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
        Schema::drop('admin_users');
    }
}
