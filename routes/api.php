<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormationController;
use App\Http\Controllers\API\FormationUserController;

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
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
});

Route::middleware('auth:api', 'admin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('indexFormation', [FormationController::class, 'index']);
    Route::post('storeFormation', [FormationController::class, 'store']);
    Route::put('updateFormation/{id}', [FormationController::class, 'update']);
    Route::delete('destroyFormation/{id}', [FormationController::class, 'destroy']);
    // Route::post('acceptCandidature/{id}', [FormationUserController::class, 'acceptCandidature']);
    // Route::post('rejectCandidature/{id}', [FormationUserController::class, 'rejectCandidature']);
    Route::get('candidatures', [FormationUserController::class, 'index']);
    Route::get('candidaturesAcceptees', [FormationUserController::class, 'acceptedCandidatures']);
    Route::get('candidaturesRejetees', [FormationUserController::class, 'rejectedCandidatures']);
});

Route::middleware('auth:api', 'candidat')->group(function () {
    Route::post('storeCandidat', [FormationUserController::class, 'store']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
