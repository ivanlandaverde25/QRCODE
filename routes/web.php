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

Route::get('/medicos-masivo', [MedicoController::class, 'envioMasivo'])
->name('medicos.masivo');

Route::post('/medicos{medico}', [MedicoController::class, 'sendMailQR'])
    ->name('medicos.enviar');

Route::post('/medicos/envio-masivo', [MedicoController::class, 'medicosEnvioMasivo'])
    ->name('medicos.envio-masivo');

// Busqueda de medicos con QR
Route::get('/medicos-qr', [MedicoController::class, 'busquedaQR'])
    ->name('medicos.qr');

Route::get('/medicos-qr/{medico}', [MedicoController::class, 'showMedicoQR'])
->name('medicosqr.show');

// URI para filtrar la tabla por medio de ajax
Route::get('/busqueda-qr/search', [MedicoController::class, 'showQR'])
    ->name('busqueda-qr.mostrar');

// Route::get('/leerqr', [QrCodeController::class, 'readQrCode'])
//     ->name('medico.leer');

