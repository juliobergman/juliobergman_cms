<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\UploadController;

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


// Tests
Route::get('/tester', [TestsController::class, 'index']);

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// App
Route::prefix('/app')->group(function(){
    Route::get('/{any?}', function () {
        return view('auth.app');
    })->where('any', '.*')->middleware('auth');
});

// Main Site
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

// // Upload
// Route::post('/upload', [UploadController::class, 'upload']);
// Route::post('/upload/test', [UploadController::class, 'test']);

// // Media
// Route::prefix('app/media')->group(function(){
//     Route::post('/all', [MediaController::class, 'all']);
// });
