<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Models\Image;


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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/getPhoto', [App\Http\Controllers\SettingsController::class, 'getImage'])->name('postAvatar')->middleware('auth');

Route::get('/detail/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail')->middleware('auth');

Route::get('/like/{id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like')->middleware('auth');
Route::get('/dislike/{id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('dislike')->middleware('auth');

Route::post('/comment/{id}', [App\Http\Controllers\CommentController::class, 'index'])->name('comment')->middleware('auth');

Route::get('/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('delete')->middleware('auth');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile')->middleware('auth');

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings')->middleware('auth');
Route::post('/updateSettings', [App\Http\Controllers\SettingsController::class, 'update'])->name('update')->middleware('auth');
Route::post('/updatePassword', [App\Http\Controllers\SettingsController::class, 'updatePass'])->name('updatePass')->middleware('auth');
Route::get('/getImage', [App\Http\Controllers\SettingsController::class, 'getImage'])->name('avatar')->middleware('auth');

Route::get('/uploadPhoto', [App\Http\Controllers\UploadController::class, 'index'])->name('uploadPhoto')->middleware('auth');
Route::post('/postPhoto', [App\Http\Controllers\UploadController::class, 'create'])->name('postPhoto')->middleware('auth');

Route::get('/artisan/storage', function() {$command = 'storage:link';$result = Artisan::call($command);return Artisan::output();})->middleware('auth');

Auth::routes();
