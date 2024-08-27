<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function show(){
        return QrCode::format('png')->generate(
            'La amo mucho Rex :)', '../public/qrcodes/qrcode.png'
        );

        // return phpinfo();
        // $data = QrCode::size(512)
        //     ->format('png')
        //     ->errorCorrection('M')
        //     ->generate(
        //         'holaaaa',
        //     );

        // return response($data)
        //     ->header('Content-type', 'image/png');
    }
}
