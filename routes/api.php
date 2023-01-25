<?php

use App\Http\Controllers\JobsController;
use App\Http\Controllers\UserController;
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


Route::post('/user/authenticate', [UserController::class, 'register']);
Route::middleware('auth:sanctum')->get('/jobs', [JobsController::class, 'index']);
Route::middleware('auth:sanctum')->post('/jobs', [JobsController::class, 'create']);
