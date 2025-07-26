<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

