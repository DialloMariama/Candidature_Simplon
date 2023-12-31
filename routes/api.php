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
    Route::post('informationUser', 'informationUser');
});

Route::middleware('auth:api', 'admin')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('listeCandidat', [FormationController::class, 'listeCandidat']);
    Route::post('formations', [FormationController::class, 'store']);
    Route::put('formations/{id}', [FormationController::class, 'update']);
    Route::delete('formations/{id}', [FormationController::class, 'destroy']);
    Route::put('AccepterCandidatures/{candidature}', [FormationUserController::class, 'accepterCandidature']);
    Route::put('Refusercandidatures/{candidature}', [FormationUserController::class, 'refuserCandidature']);
    Route::get('candidatures', [FormationUserController::class, 'index']);
    Route::get('candidaturesAcceptees', [FormationUserController::class, 'acceptedCandidatures']);
    Route::get('candidaturesRejetees', [FormationUserController::class, 'rejectedCandidatures']);
});
Route::middleware('auth:api', 'candidat')->group(function () {
    Route::post('storeCandidat', [FormationUserController::class, 'store']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('formations', [FormationController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
