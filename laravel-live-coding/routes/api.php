<?php

use App\Http\Controllers\PrizeController;
use App\Http\Controllers\RankGroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


///Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Protected routes
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/admin/prizes', [PrizeController::class, 'store']);
    Route::post('/admin/group-ranks', [RankGroupController::class, 'groupRanksByCategory']);
});
