<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'index']);
Route::get('/home', [PostController::class, 'index']);

//auth

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});
Route::get('/logout', [LoginController::class,'logout']);

//check logged user
Route::middleware(["auth"])->group(function () {
    //show new post form
    Route::get("new_post", [PostController::class, 'show_new_post']);
    //save new post
    Route::post("save_post", [PostController::class, 'save_post']);
    //edit post form
    Route::get("edit/{slug}", [PostController::class, 'edit']);
    //update post
    Route::post("update", [PostController::class, 'update']);
    //delete post
    Route::get("delete/{slug}", [PostController::class, 'destroy']);
    //display user posts
    Route::get("my_posts", [UserController::class, 'show_all_posts_from_user']);
    //display user drafts
    Route::get("my_unpublished_posts", [UserController::class, "show_all_posts_from_user_saved"]);
    //add comment
    Route::post("comment/add", [CommentController::class, "store"]);
    //delete comment
    Route::post("comment/delete/{id}", [CommentController::class, "destroy"]);
});
//user profile
Route::get("user/{id}", [UserController::class, "profile"]);
//display list of posts
Route::get("user/{id}/posts", [UserController::class, "show_all_posts_from_user"]);
//display single post
Route::get("/{slug}", [PostController::class, "show"]);
