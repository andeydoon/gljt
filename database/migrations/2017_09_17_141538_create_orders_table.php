<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trade_id', 20)->comment('订单ID');
            $table->unsignedInteger('member_id')->comment('用户ID');
            $table->unsignedInteger('master_id')->default(0)->comment('师傅ID');
            $table->unsignedInteger('dealer_id')->default(0)->comment('供应商ID');
            $table->unsignedInteger('address_id')->comment('地址ID');
            $table->decimal('total', 8, 2)->comment('金额');
            $table->unsignedTinyInteger('quantity')->comment('数量');
            $table->tinyInteger('type', false, true)->comment('类型');
            $table->tinyInteger('status', false, true)->default(0)->comment('状态');
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
        Schema::dropIfExists('orders');
    }
}
