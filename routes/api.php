<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Models\Member;
use App\Models\Role;
use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;

// Auth Routes
Route::post('register', [RegisterController::class, 'registration']);
Route::get('/users', function () {
    return response()->json([
        'users' => User::all(),
    ]);
});
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
// Member Routes
Route::get('/members', function () {
    return response()->json([
        'members' => Member::all(),
    ]);
});
Route::get('/userAvail', [MemberController::class, 'getAvailableUsers']);
Route::post('/member/create', [MemberController::class, 'store']);
Route::put('/member/update/{id}', [MemberController::class, 'update']);
Route::delete('/member/delete/{id}', [MemberController::class, 'destroy']);
// Loan Routes
Route::get('/loans', function () {
    $loans = Loan::with(['member', 'book'])->get();

    $loans->each(function($loans) {
        $loans->calculatedDelay();
        $loans->totalFine = $loans->fine;
    });

    return response()->json([
        'loans' => $loans,
    ]);
});
Route::post('/loan/create', [LoanController::class, 'store']);
Route::put('/loan/update/{id}', [LoanController::class, 'update']);
Route::delete('/loan/delete/{id}', [LoanController::class, 'destroy']);
Route::get('/calculatedFine/{id}', [LoanController::class, 'calculatedFine']);