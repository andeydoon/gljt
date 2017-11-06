<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->comment('用户ID');
            $table->string('key')->unique()->comment('唯一索引');
            $table->decimal('amount', 10, 2)->comment('金额');
            $table->tinyInteger('type', false, true)->comment('类型');
            $table->tinyInteger('status', false, true)->comment('状态');
            $table->string('remark')->comment('备注');
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
        Schema::dropIfExists('user_coins');
    }
}
