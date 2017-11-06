<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('realname', 20)->nullable();
            $table->unsignedTinyInteger('sex')->default(0);
            $table->string('signature')->nullable();
            $table->string('card_number', 18)->nullable();
            $table->string('card_front')->nullable();
            $table->string('card_back')->nullable();
            $table->string('card_hold')->nullable();
            $table->string('business_license')->nullable();
            $table->string('service_item')->nullable();
            $table->string('service_area')->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
