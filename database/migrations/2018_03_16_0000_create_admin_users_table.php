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
            $table->string("password", 100)->nullable();
            $table->string("english_name", 32)->nullable();
            $table->string("email", 100)->nullable();
            $table->boolean("enable")->default(true);
            $table->unsignedTinyInteger("status")->default(1);
            $table->string("position", 64)->nullable();
            $table->boolean("isleader");
            $table->boolean("gender")->default(0);
            $table->string("avatar", 255)->nullable();
            $table->string("hide_mobile", 32)->nullable();
            $table->string("rec_code", 9)->nullable();
            $table->string("qr_code", 255)->nullable();
            $table->string("spread_qr", 255)->nullable();
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
