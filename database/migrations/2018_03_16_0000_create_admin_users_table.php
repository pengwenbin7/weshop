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
            $table->string("name", 100)->unique();
            $table->string("email", 100)->unique()->nullable();
            $table->string("wechat_openid", 100)->unique()->nullable();
            $table->string("wework_openid", 100)->unique()->nullable();
            $table->string("wework_userid", 100)->unique();
            $table->string("phone", 32)->unique()->nullable();
            $table->string("password", 100);
            $table->string("rec_code", 9);
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
