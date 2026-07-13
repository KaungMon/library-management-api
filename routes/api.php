<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BooksTableController;
use App\Http\Controllers\BorrowingsController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::group(["prefix" => 'user'], function () {
        Route::post('logout', [UserController::class, 'logout']);
        Route::group(["prefix" => "profile"], function () {
            Route::get("/", [UserController::class, 'index']);
            Route::put("/", [UserController::class, 'edit']);
            Route::delete("/delete-account", [UserController::class, 'delete_account']);
            Route::post("/update-image", [UserController::class, 'update_image']);
            Route::delete("/delete-image", [UserController::class, 'delete_image']);
            Route::post("/change_password", [UserController::class, 'change_password']);
        });
    });
});

// SECTION - user
Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
});
// !SECTION

// SECTION - category
Route::group(['prefix' => 'category'], function () {
    Route::post('create', [CategoryController::class, 'create']);
    Route::get('lists', [CategoryController::class, 'lists']);
    Route::post('update', [CategoryController::class, 'update']);
    Route::get('delete/{id}', [CategoryController::class, 'delete']);
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
    Route::get('delete', [NotificationController::class, 'delete']);
});
// !SECTION

Broadcast::routes(['middleware' => ['auth:sanctum']]);
