<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{$title ?? 'Listado de medicos'}}</title>
</head>
<style>
    .total{
        min-height: 100vh;
        display: flex;
        flex-flow: column nowrap;
        justify-content: space-between;
    }
</style>
<body>
    {{-- Contenedor principal --}}
        {{-- Tabla --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tipo de documento
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Numero de documento
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$medico->nombre}}
                            </th>
                            <td class="px-6 py-4">
                                {{$medico->tipo_documento}}
                            </td>
                            <td class="px-6 py-4">
                                {{$medico->documento}}
                            </td>
                            <td class="px-6 py-4">
                                @if ($medico->estado == 0)
                                    QR no enviado
                                @else
                                    QR Enviado
                                @endif
                            </td>
                            <td class="px-6 py-4">
    
                                {{-- Enviar QR --}}
                                @if ($medico->estado == 0)
                                    {{-- <a href="{{route('')}}" data-tooltip-target="tooltip-default" class="text-xl">
                                        Enviar QR
                                    </a> --}}
                                    <form method="POST" action="{{route('medicos.enviar', $medico)}}">
                                        @csrf
                                        <button type="submit">
                                            Enviar QR
                                        </button>
                                    </form>
                                @endif
    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{$medicos->links()}}
        </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>