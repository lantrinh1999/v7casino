<?php

Route::group([
    'middleware' => 'api',
    'namespace'  => 'Botble\Popup\Http\Controllers',
], function () {
    Route::post('apiSendInfoBET', 'PopupController@apiSendInfo')->name('apiSendInfo');

});
