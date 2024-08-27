<x-mail::message>
{{QrCode::generate(
    'La amo mucho Rex :)',
)}}
<x-mail::panel>
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
