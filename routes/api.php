<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Models\Role;
use App\Models\Category;
use App\Models\Book;

// Auth Routes
Route::post('register', [RegisterController::class, 'registration']);
// Role Routes
Route::delete('/role/delete/{id}', [RoleController::class, 'destroy']);
Route::post('/role/create', [RoleController::class, 'store']);
Route::put('/role/update/{id}', [RoleController::class, 'update']);
Route::get('/roles', function () {
    return response()->json([
        'roles' => Role::all(),
    ]);
});
// Category Routes
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
Route::post('/category/create', [CategoryController::class, 'store']); 
Route::put('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/categories', function () {
    return response()->json([
        'categories' => Category::all(),
    ]);
});
// Book Routes
Route::get('/books', function () {
    return response()->json([
        'books' => Book::all(),
    ]);
});
Route::post('/book/create', [BookController::class, 'store']);
Route::put('/book/update/{id}', [BookController::class, 'update']);
Route::delete('/book/delete/{id}', [BookController::class, 'destroy']);
