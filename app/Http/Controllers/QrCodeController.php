<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\QrCode as lector;
use Endroid\QrCode\Reader\QrReader;

class QrCodeController extends Controller
{
    public function show(){
        // return QrCode::size(512)
        // ->format('png')
        // ->generate(
        //     '06208269-4',
            // Como segundo parametro se coloca donde se guarda el QR
            // 'La amo mucho Rex :)', '../public/qrcodes/qrcode.png'
        // ); 

        // return phpinfo();
        $data = QrCode::size(100)
            ->merge(public_path('images/Logo-ENAR.png'), 0.3, true)
            ->format('png')
            ->errorCorrection('M')
            ->generate(
                'holaaaa',
                // '../public/qrcodes/qrcode2.png'
            );


        return response($data)
            ->header('Content-type', 'image/png');
    }

    public function readQrCode(){
        return view('medicos.create');
    }
}
