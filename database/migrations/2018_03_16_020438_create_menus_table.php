<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->default(0)->comment('父级菜单');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('module')->default(0)->comment('所属模块，1简介模块，2新闻模块，3产品模块，4下载模块，5图片模块，6招聘模块，7留言系统，8反馈系统，9友情链接，10会员中心，11全站搜索，12网站地图，100产品列表，101图片列表，0外部模块。');
            $table->string('name',200)->nullable()->comment('栏目路径');
            $table->string('title',200)->nullable()->comment('栏目名称');
            $table->string('keywords',200)->nullable()->comment('栏目关键词');
            $table->text('description')->comment('栏目简短描述');
            $table->longText('content')->comment('简介模块为栏目内容，产品，新闻，下载，图片模块为附加内容');
            $table->integer('hide')->default(0)->comment('是否在前台显示，1显示，0不显示');
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
        Schema::dropIfExists('menus');
    }
}
