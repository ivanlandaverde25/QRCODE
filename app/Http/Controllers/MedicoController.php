<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeSendMail;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MedicoController extends Controller
{
    public function index(){
        $medicos = Medico::orderBy('id', 'ASC')
                        ->paginate();

        return view('medicos.index', compact('medicos'));
    }

    public function sendMailQR(Medico $medico){
        
        Mail::to($medico->correo)->send(new QrCodeSendMail($medico));
        
        if(Mail::to($medico->correo)->send(new QrCodeSendMail($medico))){
            $medico->estado = true;
            $medico->save();
        }else{
            
        }

        return redirect()->route('medicos.index');
    }
}
