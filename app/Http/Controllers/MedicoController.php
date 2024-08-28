<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeSendMail;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class MedicoController extends Controller
{
    public function index(){
        $medicos = Medico::orderBy('id', 'ASC')
                        ->paginate();

        return view('medicos.index', compact('medicos'));
    }
    
    public function sendMailQR(Medico $medico){
        
        $data = QrCode::size(100)
        ->format('png')
        ->merge(public_path('images/Logo-ENAR.png'), 0.3, true)
        ->errorCorrection('M')
        ->generate(
            "{$medico->documento}",
            '../public/qrcodes/qrcode'.$medico->documento.'.png'
        );
        
        response($data)
        ->header('Content-type', 'image/png');
        
        // Mail::to($medico->correo)->send(new QrCodeSendMail($medico));
        
        if(Mail::to($medico->correo)->send(new QrCodeSendMail($medico))){
            $medico->estado = true;
            $medico->save();
        }else{
            
        }

        return redirect()->route('medicos.index');
    }
    
    public function envioMasivo(){
        $medicos = Medico::orderBy('id', 'ASC')
                        ->paginate();
    
        return view('medicos.envio-masivo', compact('medicos'));
    }

    public function medicosEnvioMasivo(Medico $medico){
        // Obtiene los IDs seleccionados
        $idsSeleccionados = $medico->input('seleccionados', []);

        if (empty($idsSeleccionados)) {
            return redirect()->back()->with('error', 'No se seleccionó ningún usuario.');
        }

        // Aquí puedes realizar la lógica que necesites, por ejemplo, eliminar usuarios, enviar correos, etc.
        // Por ejemplo, eliminar los usuarios seleccionados:
        // Usuario::whereIn('id', $idsSeleccionados)->delete();

        return redirect()->back()->with('success', 'Los usuarios seleccionados han sido procesados.');
   
    }
}
