<?php

/**
 * Uppish Routes
 *
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Uppish
 */

Route::group(['namespace' => 'Technovistalimited\Uppish\Controllers'], function () {
    Route::group(['middleware' => ['web']], function () {
        Route::prefix('/uppish')->group(function () {
            Route::post('/upload/', 'UppishController@store')->name('uppish.upload');
            Route::post('/delete/', 'UppishController@delete')->name('uppish.delete');
        });
    });
});
