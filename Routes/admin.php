<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'seven' prefix applied to all routes (including names)
 * @see \App\Providers\Route::register
 */

Route::admin('seven', function () {
    Route::get('/', 'Main@index')->name('index');
    Route::post('/', 'Main@submit')->name('submit');
});
