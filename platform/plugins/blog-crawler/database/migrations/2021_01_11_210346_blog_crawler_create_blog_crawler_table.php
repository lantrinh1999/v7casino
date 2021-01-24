<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class BlogCrawlerCreateBlogCrawlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawler_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('link', 255)->nullable();
            $table->json('categories_id')->nullable();
            $table->string('post_link_selector', 100)->nullable();
            $table->string('title_selector', 100)->nullable();
            $table->string('image_selector', 100)->nullable();
            $table->string('description_selector', 100)->nullable();
            $table->string('content_selector', 100)->nullable();
            $table->string('content_image_attr_selector', 100)->nullable();
            $table->string('tag_selector', 100)->nullable();
            $table->string('crawl_status', 60)->nullable()->default('not_running')->comment('not_running: chưa chạy; done: hoàn thành; running: đang chạy');
            $table->string('crawl_type', 60)->nullable()->default('now')->comment('now:chạy ngay; after: chạy sau');
            $table->string('status', 60)->nullable()->default('published');
            $table->dateTime('complete_at')->nullable();
            $table->timestamps();
        });

        Schema::create('crawler_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('crawler_category_id')->unsigned()->references('id')->on('crawler_categories')->onDelete('cascade');
            $table->bigInteger('post_id')->unsigned()->references('id')->on('posts')->onDelete('cascade');
            $table->string('link', 255)->nullable();
            $table->string('crawl_status', 60)->nullable()->default('not_running')->comment('not_running: chưa chạy; done: hoàn thành; running: đang chạy');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('crawler_categories');
        Schema::dropIfExists('crawler_posts');
    }
}
