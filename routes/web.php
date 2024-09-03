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

// Ruta para editar los datos de un medico
Route::put('/medicos/{medico}', [MedicoController::class, 'update'])
    ->name('medicos.update');

// Busqueda de medicos con QR
Route::get('/medicos-qr', [MedicoController::class, 'busquedaQR'])
    ->name('medicos.qr');

    // Mostrar el QR del medico en modal
Route::get('/medicos-qr/{medico}', [MedicoController::class, 'showMedicoQR'])
    ->name('medicosqr.show');

// Regenerar QR
Route::post('/medicos-regenerar/{medico}', [MedicoController::class, 'regenerarQR'])
    ->name('medicos.regenerar');

// URI para filtrar la tabla por medio de ajax
Route::get('/busqueda-qr/search', [MedicoController::class, 'showQR'])
    ->name('busqueda-qr.mostrar');
