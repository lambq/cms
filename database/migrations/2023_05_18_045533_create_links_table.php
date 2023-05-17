<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('网站名称');
            $table->string('url', 255)->comment('网站链接');
            $table->string('logo', 255)->nullable()->comment('LOGO');
            $table->boolean('type')->default(false)->comment('友情链接类型（文字或LOGO）');
            $table->integer('sort')->default(0)->comment('排序');
            $table->boolean('state')->default(false)->comment('审核，1为审核，0为未审核');
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
        Schema::dropIfExists('links');
    }
}
