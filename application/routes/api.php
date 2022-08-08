<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuestionApiController;
use App\Http\Controllers\Api\UserApiController;
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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/list_question',[QuestionApiController::class,'index'])->name('api.list.question');
    Route::get('/list_user',[UserApiController::class,'index'])->name('api.list.user');
});
