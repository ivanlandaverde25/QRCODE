<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraEnvioQR extends Model
{
    use HasFactory;

    protected $table = 'bitacora_envio_qr';

    protected $fillable = [
        'registros_enviados',
    ];

    protected function casts():array
    {
        return [
            'registros_enviados' => 'array',
        ];
    }
}
