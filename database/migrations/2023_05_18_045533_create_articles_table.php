<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->default(0)->index('users_id');
            $table->integer('column_id')->default(0)->index('column_id')->comment('所属栏目');
            $table->string('title', 255)->index('title')->comment('文章标题');
            $table->string('seo_title', 255)->nullable()->index('seo_title')->comment('seo文章标题');
            $table->string('image', 255)->comment('缩略图');
            $table->string('copy_from', 255)->comment('文章来源');
            $table->text('keywords')->nullable()->comment('关键词');
            $table->text('seo_keywords')->nullable()->comment('seo关键词');
            $table->text('description')->comment('文章描述');
            $table->text('seo_description')->nullable()->comment('seo文章描述');
            $table->longText('content')->comment('文章内容');
            $table->longText('seo_content')->nullable()->comment('seo文章内容');
            $table->integer('views')->default(0)->index('views')->comment('浏览量');
            $table->integer('is_best')->default(0)->index('is_best')->comment('是否推荐');
            $table->integer('is_top')->default(0)->index('is_top')->comment('是否置顶');
            $table->integer('is_pay')->default(0)->index('is_pay')->comment('是否付费');
            $table->longText('extend')->nullable();
            $table->integer('state')->nullable()->index('state')->comment('状态');
            $table->timestamp('created_at')->nullable()->index('created_at');
            $table->timestamp('updated_at')->nullable()->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
