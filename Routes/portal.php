<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/sms77' prefix applied to all routes (including names)
 * @see \App\Providers\Route::register
 */

Route::portal('sms77', function () {});
