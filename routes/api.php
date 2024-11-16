<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BooksTableController;
use App\Models\BookCategory;

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
