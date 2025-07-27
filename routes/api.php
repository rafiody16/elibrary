<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Models\Role;

Route::post('register', [RegisterController::class, 'registration']);
Route::delete('/role/{id}', [RoleController::class, 'destroy']);
Route::post('/role/create', [RoleController::class, 'store']);
Route::put('/role/update/{id}', [RoleController::class, 'update']);
Route::get('/roles', function () {
    return response()->json([
        'roles' => Role::all(),
    ]);
});



