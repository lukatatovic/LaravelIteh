<?php

use App\Http\Controllers\Authorization\APIController;
use App\Http\Controllers\FriendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/friends', [FriendController::class, 'index']);
Route::get('/friends/{id}', [FriendController::class, 'show']);

Route::post('/register', [APIController::class, 'register']);
Route::post('/login', [APIController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::resource('/friends', FriendController::class)
        ->only(['store', 'update', 'destroy']);


    Route::post('/logout', [APIController::class, 'logout']);
});