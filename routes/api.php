<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\MediaCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// User
Route::get('/user', [UserController::class, 'user']);
// Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'user']);
Route::prefix('user')->group(function () {
    Route::put('/update', [UserController::class, 'update']);

});

// Media
// Route::get('/media', [MediaController::class, 'index']);
Route::prefix('media')->group(function () {
    Route::post('/', [MediaController::class, 'all']);
    Route::post('/show', [MediaController::class, 'show']);
    Route::post('/categories', [MediaCategoryController::class, 'categories']);
    Route::middleware('auth:sanctum')->post('/store', [MediaController::class, 'store']);
    Route::post('/update/bulk', [MediaController::class, 'bulkUpsert']);
});

// Upload
Route::middleware('auth:sanctum')->post('/upload', [UploadController::class, 'upload']);
Route::post('/upload/avatar', [UploadController::class, 'avatar']);
Route::post('/upload/replace', [UploadController::class, 'replace']);
Route::delete('/upload/destroy', [UploadController::class, 'destroy']);

// Content
Route::post('/content', [ContentController::class, 'content']);
Route::post('/content/store', [ContentController::class, 'store']);
Route::post('/content/update', [ContentController::class, 'update']);

Route::post('/connections', [ConnectionController::class, 'connections']);
Route::post('/connection/update/bulk', [ConnectionController::class, 'bulkUpsert']);

// Section
Route::get('/sections', [SectionController::class, 'sections']);
Route::post('/section/store', [SectionController::class, 'store']);




// Resources
Route::get('/countries', [CountryController::class, 'countries']);
