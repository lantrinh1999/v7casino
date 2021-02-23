<?php

Route::group(['namespace' => 'Botble\AppManager\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'app-managers', 'as' => 'app-manager.'], function () {
            Route::resource('', 'AppManagerController')->parameters(['' => 'app-manager']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'AppManagerController@deletes',
                'permission' => 'app-manager.destroy',
            ]);
        });
    });

});
