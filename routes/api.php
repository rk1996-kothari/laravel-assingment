<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

      // API route to create an image
      Route::post('/images/create', [ImageController::class, 'create']);

      // API route to view images
      Route::get('/images', [ImageController::class, 'index']);

      // API route to delete an image
      Route::delete('/images/{image}', [ImageController::class, 'destroy']);

      Route::post('/logout', [AuthController::class, 'logout']);

    // Your other authenticated routes
});
