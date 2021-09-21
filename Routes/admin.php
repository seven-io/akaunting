<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'sms77' prefix applied to all routes (including names)
 * @see \App\Providers\Route::register
 */

Route::admin('sms77', function () {
    Route::get('/', 'Main@index')->name('index');
    Route::post('/', 'Main@submit')->name('submit');
});
