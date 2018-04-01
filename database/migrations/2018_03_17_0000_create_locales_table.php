<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->tinyIncrements("id");
            $table->string("name", 16)->comment("https://en.wikipedia.org/wiki/IETF_language_tag");
            $table->string("currency", 16)->comment("https://en.wikipedia.org/wiki/ISO_4217");
            $table->string("full_name", 100)->nullable();
            $table->string("colors", 100)->nullable();
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
        Schema::dropIfExists('locales');
    }
}
