<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name', 20)->nullable();
            $table->string('phone', 50)->nullable();
            $table->unsignedInteger('province_id')->default(0);
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('district_id')->default(0);
            $table->string('street')->nullable();
            $table->string('floor')->nullable();
            $table->boolean('lift')->default(0);
            $table->boolean('default')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
