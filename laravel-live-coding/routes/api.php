<?php

use App\Http\Controllers\PrizeAssignmentController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\PrizeWinningController;
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
Route::post('/register/player', [AuthController::class, 'PlayerRegister']);
Route::post('/register/admin', [AuthController::class, 'AdminRegister']);
Route::post('/login', [AuthController::class, 'login']);

//Protected routes
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/admin/prizes', [PrizeController::class, 'storePrize']);
    Route::post('/admin/group-ranks', [RankGroupController::class, 'groupRanksByCategory']);
    Route::post('/admin/prizes/assign', [PrizeAssignmentController::class, 'assignPrizes']);
    Route::post('/player/spin', [PrizeWinningController::class, 'checkPrize']);
});
