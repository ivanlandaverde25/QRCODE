<?php

use App\Http\Controllers\MedicoController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qr', [QrCodeController::class, 'show']);

Route::get('/medicos', [MedicoController::class, 'index'])
    ->name('medicos.index');
Route::post('/medicos{medico}', [MedicoController::class, 'sendMailQR'])
    ->name('medicos.enviar');