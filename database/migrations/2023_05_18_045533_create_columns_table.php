<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0)->comment('父级菜单');
            $table->string('title', 255)->comment('标题');
            $table->string('name', 255)->comment('名称');
            $table->string('keywords', 255)->comment('关键词');
            $table->text('description')->comment('文章描述');
            $table->integer('order')->default(0)->comment('排序');
            $table->integer('state')->nullable()->comment('状态');
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
        Schema::dropIfExists('columns');
    }
}
