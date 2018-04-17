<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $func = [
                "area" => [
                    ["low" => 0, "up" => 5000, "factor" => 0, "const" => 245,],
                    ["low" => 5000, "up" => 30000, "factor" => 0.4 / 1000, "const" => 0,],
                ],
                "other" => [
                    "factor" => 0, "const" => 0,
                ],
            ];
            $table->increments('id');
            $table->unsignedTinyInteger("locale_id")->default(1);
            $table->string("name", 100)->unique();
            $table->unsignedInteger("brand_id");
            $table->unsignedInteger("address_id");
            $table->text("func")->default(json_encode($func));
            $table->text("description")->nullable();
            $table->boolean("active")->default(true);
            $table->timestamps();
            $table->foreign("locale_id")->references("id")->on("locales");
            $table->foreign("address_id")->references("id")->on("addresses");
            $table->foreign("brand_id")->references("id")->on("brands");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}
