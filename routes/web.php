<?php

use App\Http\Controllers\SSO\SSOController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuPageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\CategoryController;
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

Route::get("/sso/login", [SSOController::class, 'getLogin'])->name("sso.login");
Route::get("/callback", [SSOController::class, 'getCallback'])->name("sso.callback");
Route::get("/sso/connect", [SSOController::class, 'connectUser'])->name("sso.connect");
Auth::routes(['register' => false, 'reset' => false]);

// Route::group(['middleware' => ['auth']], function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

//add
Route::get('/category-create', [CategoryController::class, 'showFormAdd'])->name('category-create');
Route::get('/show-button', [CategoryController::class, 'showButton'])->name('show-button');

// edit
Route::get('/category-edit/{id}', [CategoryController::class, 'showFormEdit'])->name('category-edit');

Route::resource('/category', CategoryController::class);

// post
Route::post('/create-post', [PostController::class, 'create']);
Route::put('/edit-post', [PostController::class, 'edit']);
Route::delete('/delete-post', [PostController::class, 'delete']);

// get list post
Route::get('/get-list-post', [PostController::class, 'getListPost']);

Route::get('/get-list-post-by-category-id/{id}', [PostController::class, 'getListPostByCategoryId']);

//Route::get('/get-detail-post/{id}', [PostController::class, 'getDetailPost']);
Route::get('/get-detail-post/{id}/{type}', [PostController::class, 'getDetailPost']);

Route::get('/get-list-attachment/{id}', [PostController::class, 'getListFileAttachment']);

Route::get('/download-file', [PostController::class, 'downloadFile']);


Route::get('/increment-view-post', [PostController::class, 'incrementViewPost']);

Route::post('/create-comment', [CommentController::class, 'create'])->name('create-comment');

Route::get('/get-list-comment/{id}', [CommentController::class, 'getListComment']);

Route::get('/get-user-image/{id}', [CommentController::class, 'getUserImage']);

Route::put('/edit-comment', [CommentController::class, 'edit']);

Route::delete('/delete-comment', [CommentController::class, 'delete']);


Route::get('/zip-and-download/{id}', [PostController::class, 'zipAndDownloadFie']);

Route::post('/search-by-title', [PostController::class, 'searchPostByTitle']);

Route::post('/search-post', [PostController::class, 'searchPost']);

Route::post('/upload-image-ckeditor', [CkeditorController::class, 'uploadImageCkeditor']);

Route::get('/get-user-info', [HomeController::class, 'getUserInfo']);




// });

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Invalid url',
        'data' => [],
    ], 404);
});