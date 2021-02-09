<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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

Route::get('/', "PostController@index");
Route::get('/home', ["as" => "home", "uses" => "PostController@index"]);

//auth
Route::get("/logout", "UserController@logout");
Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});

//check logged user
Route::middleware(["auth"])->group(function () {
    //show new post form
    Route::get("new-post", "PostController@show_new_post");
    //save new post
    Route::post("save-post", "PostController@save_post");
    //edit post form
    Route::get("edit/{slug}", "PostController@edit");
    //update post
    Route::post("update", "PostController@update");
    //delete post
    Route::get("delete/{slug}","PostController@destroy");
    //display user posts
    Route::get("my_posts","UserController@show_user_posts");
    //display user drafts
    Route::get("my_drafts","UserController@show_user_drafts");
    //add comment
    Route::post("comment/add","CommentController@store");
    //delete comment
    Route::post("comment/delete/{id}","CommentController@destroy");
});
//user profile
Route::get("user/{id}","UserController@profile");
//display list of posts
Route::get("user/{id}/posts","UserController@user_posts");
//display single post
Route::get("/{slug}",["as" => "post","uses" => "PostController@show"]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
