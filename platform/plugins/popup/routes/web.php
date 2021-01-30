<?php

Route::group(['namespace' => 'Botble\Popup\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'popups', 'as' => 'popup.'], function () {
            Route::resource('', 'PopupController')->parameters(['' => 'popup']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PopupController@deletes',
                'permission' => 'popup.destroy',
            ]);
        });
    });

});
