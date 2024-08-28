<x-mail::message style="display: flex; jusitfy-content: center; align-items:center;">
<img src="{{ $message->embed(public_path() . '/qrcodes/qrcode'.$medico->documento.'.png') }}" alt="" style="display:block; padding-bottom: 20px; text-align:center;" />
<x-mail::panel style="border-radius: 10px;">
Nombre: {{$medico->nombre}}
<br>
Tipo de documento: {{$medico->tipo_documento}}
<br>
Documento: {{$medico->documento}}
</x-mail::panel>

<x-mail::button url="#">
Ir al sitio
</x-mail::button>

</x-mail::message>
