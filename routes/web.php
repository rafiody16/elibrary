<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


