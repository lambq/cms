<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',200)->nullable()->comment('信息名称');
            $table->string('keywords',200)->nullable()->comment('信息关键词');
            $table->text('description')->comment('简短描述');
            $table->longText('content')->comment('信息内容');
            $table->integer('class')->default(0)->comment('所属栏目');
            $table->integer('no_order')->default(0)->comment('排序');
            $table->string('img_url',255)->nullable()->comment('缩略图路径');
            $table->string('img_urls',255)->nullable()->comment('原图路径');
            $table->integer('com_ok')->default(0)->comment('推荐信息，1为推荐，0为不推荐');
            $table->string('issue',100)->nullable()->comment('发布者');
            $table->integer('hits')->default(0)->comment('点击次数');
            $table->integer('top_ok')->default(0)->comment('是否置顶，1为置顶，0为不置顶');
            $table->integer('hide')->default(0)->comment('是否在前台显示，1显示，0不显示');
            $table->text('tag')->comment('TAG（标签）内容');
            $table->string('links',200)->nullable()->comment('外部链接地址');
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
        Schema::dropIfExists('news');
    }
}
