<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Models\Role;
use App\Models\Category;

Route::post('register', [RegisterController::class, 'registration']);

Route::delete('/role/delete/{id}', [RoleController::class, 'destroy']);
Route::post('/role/create', [RoleController::class, 'store']);
Route::put('/role/update/{id}', [RoleController::class, 'update']);
Route::get('/roles', function () {
    return response()->json([
        'roles' => Role::all(),
    ]);
});

Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
Route::post('/category/create', [CategoryController::class, 'store']); 
Route::put('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/categories', function () {
    return response()->json([
        'categories' => Category::all(),
    ]);
});



