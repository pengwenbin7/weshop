<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_records', function (Blueprint $table) {
            $table->increments("id");
            $table->string("admin_name", 100);
            $table->string("company_name", 100)->nullable();
            $table->string("contact_name", 100)->nullable();
            $table->string("contact_number", 100)->nullable();
            $table->string("contact_channel", 100)->default("电话");
            $table->text("note")->nullable();
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
        Schema::dropIfExists('connection_records');
    }
}
