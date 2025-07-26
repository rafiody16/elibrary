<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Role;

Route::get('/roles', function () {
    return response()->json([
        'roles' => Role::all(),
    ]);
});

Route::post('register', [RegisterController::class, 'registration']);



