<?php

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BooksTableController;
use App\Http\Controllers\BorrowingsController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// SECTION - category
Route::group(['prefix' => 'category'], function () {
    Route::post('create', [CategoryController::class, 'create']);
    Route::get('lists', [CategoryController::class, 'lists']);
    Route::post('update', [CategoryController::class, 'update']);
    ROute::get('delete/{id}', [CategoryController::class, 'delete']);
});
// !SECTION

// SECTION - author
Route::group(['prefix' => 'author'], function () {
    Route::post('create', [AuthorsController::class, 'create']);
    Route::get('lists', [AuthorsController::class, 'lists']);
    Route::post('update', [AuthorsController::class, 'update']);
    Route::get('delete/{id}', [AuthorsController::class, 'delete']);
});
// !SECTION

// SECTION - books
Route::group(['prefix' => 'books'], function () {
    Route::post('create', [BooksTableController::class, 'create']);
    Route::get('lists', [BooksTableController::class, 'lists']);
    Route::get('detail/{id}', [BooksTableController::class, 'detail']);
    Route::post('update', [BooksTableController::class, 'update']);
    Route::get('delete/{id}', [BooksTableController::class, 'delete']);
});
// !SECTION

// SECTION - book categories
Route::group(['prefix' => 'book_categories'], function () {
    Route::post('create', [BookCategoryController::class, 'create']);
    Route::get('lists', [BookCategoryController::class, 'lists']);
    Route::post('update', [BookCategoryController::class, 'update']);
});
// !SECTION

// SECTION - borrow book
Route::group(['prefix' => 'borrow_book'], function () {
    Route::get('book_lists', [BorrowingsController::class, 'book_lists']);
    Route::post('create', [BorrowingsController::class, 'create']);
    Route::get('lists', [BorrowingsController::class, 'lists']);
    Route::post('update', [BorrowingsController::class, 'update']);
    Route::group(['prefix' => 'users'], function () {
        Route::get('librarians', [BorrowingsController::class, 'librarians']);
        Route::get('members', [BorrowingsController::class, 'members']);
    });
});
// !SECTION

// SECTION - statuses
Route::group(['prefix' => 'status'], function () {
    Route::get('lists', [StatusController::class, 'lists']);
});
// !SECTION

// SECTION - notification
Route::group(['prefix' => 'notification'], function () {
    Route::get('index', [NotificationController::class, 'index']);
});
// !SECTION

Broadcast::routes(['middleware' => ['auth:sanctum']]);
