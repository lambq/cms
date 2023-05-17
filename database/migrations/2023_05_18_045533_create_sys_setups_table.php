<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('webname', 255)->comment('网站名称');
            $table->string('keywords', 255)->comment('网站关键词');
            $table->text('description')->comment('网站描述');
            $table->text('copyright')->comment('版权信息');
            $table->string('welcome', 255)->comment('欢迎访客信息');
            $table->string('tel', 255)->comment('服务热线');
            $table->string('qq', 255)->comment('客服');
            $table->string('beian', 255)->comment('网站备案号');
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
        Schema::dropIfExists('sys_setups');
    }
}
