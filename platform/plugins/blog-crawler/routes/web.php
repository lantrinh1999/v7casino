<?php
Route::get('crawler', function(){
    \Artisan::call("cms:post-crawler");
});
Route::group(['namespace' => 'Botble\BlogCrawler\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'blog-crawlers', 'as' => 'blog-crawler.'], function () {
            Route::resource('', 'CrawlerCategoryController')->parameters(['' => 'blog-crawler']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CrawlerCategoryController@deletes',
                'permission' => 'blog-crawler.destroy',
            ]);
        });
    });

});
