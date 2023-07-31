<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/seven' prefix applied to all routes (including names)
 * @see \App\Providers\Route::register
 */

Route::portal('seven', function () {
});
