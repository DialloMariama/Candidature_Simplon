<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormationController;

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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
Route::get('indexFormation',[FormationController::class, 'index']);
Route::post('storeFormation',[FormationController::class, 'store']);
Route::put('updateFormation/{id}',[FormationController::class, 'update']);
Route::delete('destroyFormation/{id}',[FormationController::class, 'destroy']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
