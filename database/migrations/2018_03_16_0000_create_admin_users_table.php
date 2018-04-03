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
            $table->string("name")->unique();
            $table->string("email")->unique()->nullable();
            $table->string("wechat_openid")->unique()->nullable();
            $table->string("wework_openid")->unique()->nullable();
            $table->string("phone")->unique()->nullable();
            $table->string("password");
            $table->string("rec_code");
            $table->softDeletes();
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