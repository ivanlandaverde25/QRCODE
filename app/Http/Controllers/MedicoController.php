<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeSendMail;
use App\Models\BitacoraEnvioQR;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
        
        $valorEncriptado = Crypt::encryptString($medico->documento);
        $data = QrCode::size(512)
        ->format('png')
        ->merge(public_path('images/Logo-ENAR.png'), 0.3, true)
        ->errorCorrection('M')
        ->generate(
            "{$valorEncriptado}",
            '../public/qrcodes/qrcode'.$medico->documento.'.png'
        );
        
        response($data)
        ->header('Content-type', 'image/png');
        
        // Mail::to($medico->correo)->send(new QrCodeSendMail($medico));
        
        if(Mail::to($medico->correo)->send(new QrCodeSendMail($medico))){
            $medico->estado = true;
            $medico->qr = '/qrcodes/qrcode'.$medico->documento.'.png';
            $medico->save();
        }else{
            
        }

        return redirect()->route('medicos.index')->with([
            'success' => 'Envio de QR realizado',
        ]);
    }
    
    // PRUEBAS PARA EL ENVIO MASIVO DE CORREOS
    public function envioMasivo(){
        $medicos = Medico::orderBy('id', 'ASC')
                        ->paginate(50);
    
        return view('medicos.envio-masivo', compact('medicos'));
    }

    public function medicosEnvioMasivo(Request $request ,Medico $medico){
        // Obtiene los IDs seleccionados
        $idsSeleccionados = $request->input('seleccionados', []);
        $resultado = [];

        if (empty($idsSeleccionados)) {
            return redirect()->back()->with('error', 'No se seleccionó ningún usuario.');
        }

        // Aquí puedes realizar la lógica que necesites, por ejemplo, eliminar usuarios, enviar correos, etc.
        // Por ejemplo, eliminar los usuarios seleccionados:
        // Usuario::whereIn('id', $idsSeleccionados)->delete();

        foreach($idsSeleccionados as $item){

            $medico = Medico::find($item);

            // Validación que el médico no haya enviado el QR previamente
            if ($medico->estado == false){
                // Aqui se agrega la logica de creacion y envio del correo con el QR al medico
                array_push($resultado, array('id' => $item,
                                            'medico' => $medico->nombre,
                                            'status' => '200',
                                            'mensaje' => 'QR ENVIADO'));
                
                $medico->estado = true;
                $medico->qr = '/qrcodes/qrcode'.$medico->documento.'.png';
                $medico->save();
            } else {
                array_push($resultado, array('id' => $item, 
                                            'medico' => $medico->nombre,
                                            'status' => '500', 
                                            'mensaje' => 'QR YA ENVIADO PREVIAMENTE'));
            }

        }

        $bitacora = new BitacoraEnvioQR();
        $bitacora->registros_enviados = $resultado;
        $bitacora->save();

        // return redirect()->back()->with('success', 'Los usuarios seleccionados han sido procesados.');
        return $resultado;
   
    }

    public function busquedaQR(){
        $medicos = Medico::orderBy('id', 'ASC')
                        ->paginate(50);
        return view('medicos.ver-codigo-medico', compact('medicos'));
    }

    public function showMedicoQR($id){
        $medico = Medico::find($id);
        if ($medico) {
            return response()->json($medico);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    // Metodo para filtrar la tabla de medicos en tiempo real
    public function showQR(Request $request){
        $query = $request->input('query');
        
        if (empty($query)){
            $medicos = Medico::orderBy('id', 'DESC')
                            ->paginate(50);
            return response()->json($medicos);
        } else {
            $medicos = Medico::where('nombre', 'like', "%$query%")
                            ->orWhere('correo', 'like', "%$query%")
                            ->get();
    
            return response()->json($medicos);
        }

    }
}
