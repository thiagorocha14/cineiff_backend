<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SolicitacaoReservaController;
use Illuminate\Http\Request;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::put('/solicitacao-reserva/{id}/recuperar', [SolicitacaoReservaController::class, 'recuperar']);
Route::resource('solicitacao-reserva', SolicitacaoReservaController::class);
Route::resource('reserva', ReservaController::class);
Route::resource('filmes', FilmeController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});