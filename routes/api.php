<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UploadController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Media
Route::get('/media', [MediaController::class, 'index']);
Route::prefix('media')->group(function () {
    Route::post('/', [MediaController::class, 'all']);
    Route::post('/categories', [MediaCategoryController::class, 'categories']);
    Route::middleware('auth:sanctum')->post('/store', [MediaController::class, 'store']);
    Route::post('/update/bulk', [MediaController::class, 'bulkUpsert']);
});

// Upload
Route::middleware('auth:sanctum')->post('/upload', [UploadController::class, 'upload']);
