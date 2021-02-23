<?php

Route::group([
    'middleware' => 'api',
    'prefix'     => 'api/v1',
    'namespace'  => 'Botble\AppManager\Http\Controllers\API',
], function () {
    Route::get('get_app' . '/{slug}', [
        'as'         => 'get_app',
        'uses'       => 'AppManagerController@getApp'
    ]);

    Route::get('get_all_app', [
        'as'         => 'get_all_app',
        'uses'       => 'AppManagerController@getAllApp'
    ]);
});
