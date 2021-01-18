<?php

Route::group(['namespace' => 'Botble\Feedback\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'feedback', 'as' => 'feedback.'], function () {
            Route::resource('', 'FeedbackController')->parameters(['' => 'feedback']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'FeedbackController@deletes',
                'permission' => 'feedback.destroy',
            ]);
        });
    });

});
