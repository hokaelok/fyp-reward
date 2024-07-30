<?php

use App\Http\Controllers\BusinessRewardController;
use App\Http\Controllers\ConsumerRewardController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

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

// Points
Route::get('points/{userId}', [PointController::class, 'show']);
Route::get('points/history/{userId}', [PointController::class, 'history']);
Route::post('points/create', [PointController::class, 'store']);
Route::post('points/update/{userId}', [PointController::class, 'update']);

// Consumer Reward
Route::get('rewards', [ConsumerRewardController::class, 'get']);
Route::get('reward/{rewardId}', [ConsumerRewardController::class, 'show']);
Route::get('rewards/redeemed/{userId}', [ConsumerRewardController::class, 'getRedeems']);
Route::get('reward/redeemed/{redeemId}', [ConsumerRewardController::class, 'getRedeem']);
Route::post('reward/redeem/{rewardId}', [ConsumerRewardController::class, 'redeem']);
Route::post('reward/use/{redeemId}', [ConsumerRewardController::class, 'use']);

// Business Reward
Route::get('business/rewards', [BusinessRewardController::class, 'get']);
Route::get('business/reward/{rewardId}', [BusinessRewardController::class, 'show']);
Route::post('business/reward/create', [BusinessRewardController::class, 'store']);
Route::post('business/reward/update/{rewardId}', [BusinessRewardController::class, 'update']);
