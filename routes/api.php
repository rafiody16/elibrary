<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;

// ✅ Public Routes (Tidak Perlu Login)
Route::post('/register', [RegisterController::class, 'registration']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/roles', fn () => response()->json(['roles' => Role::all()]));
Route::get('/sanctum/csrf-cookie', fn () => response()->json(['message' => 'OK'])); // optional

Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout']);
});

// ✅ Protected Routes (Perlu Login)
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {

    // Users
    Route::get('/users', fn () => response()->json(['users' => User::all()]));

    // Roles
    Route::post('/role/create', [RoleController::class, 'store']);
    Route::put('/role/update/{id}', [RoleController::class, 'update']);
    Route::delete('/role/delete/{id}', [RoleController::class, 'destroy']);

    // Categories
    Route::get('/categories', fn () => response()->json(['categories' => Category::all()]));
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);

    // Books
    Route::get('/books', fn () => response()->json(['books' => Book::all()]));
    Route::post('/book/create', [BookController::class, 'store']);
    Route::put('/book/update/{id}', [BookController::class, 'update']);
    Route::delete('/book/delete/{id}', [BookController::class, 'destroy']);

    // Members
    Route::get('/members', fn () => response()->json(['members' => Member::all()]));
    Route::get('/userAvail', [MemberController::class, 'getAvailableUsers']);
    Route::post('/member/create', [MemberController::class, 'store']);
    Route::put('/member/update/{id}', [MemberController::class, 'update']);
    Route::delete('/member/delete/{id}', [MemberController::class, 'destroy']);

    // Loans
    Route::get('/loans', function () {
        $loans = Loan::with(['member', 'book'])->get();
        $loans->each(function ($loan) {
            $loan->calculatedDelay();
            $loan->totalFine = $loan->fine;
        });
        return response()->json(['loans' => $loans]);
    });
    Route::post('/loan/create', [LoanController::class, 'store']);
    Route::put('/loan/update/{id}', [LoanController::class, 'update']);
    Route::delete('/loan/delete/{id}', [LoanController::class, 'destroy']);
    Route::get('/calculatedFine/{id}', [LoanController::class, 'calculatedFine']);
});
