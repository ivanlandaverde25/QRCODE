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

    Route::get('/medicosMasivo', [MedicoController::class, 'envioMasivo'])
    ->name('medicos.masivo');

Route::post('/medicos{medico}', [MedicoController::class, 'sendMailQR'])
    ->name('medicos.enviar');

Route::post('/medicos/envio-masivo', [MedicoController::class, 'medicosEnvioMasivo'])
    ->name('medicos.envio-masivo');


// Route::get('/leerqr', [QrCodeController::class, 'readQrCode'])
//     ->name('medico.leer');