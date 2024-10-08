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

<body style="padding: 20px;">
    @includeIf('components.header')
    {{-- Contenedor principal --}}
    
    {{-- Alerta de error --}}
    @if (session('error'))
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
              <span class="font-medium">Error!</span> {{session('error')}}
            </div>
          </div>
    @endif

    {{-- Alerta de confirmación --}}
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Exito!</span> {{session('success')}}
            </div>
        </div>
    @endif



    <form id="medicosSeleccionados" action="{{route('medicos.envio-masivo')}}" method="POST">
        @csrf
        <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 mb-3 border border-blue-500 hover:border-transparent rounded">
            Envíar código QR
        </button>
        
        {{-- Tabla --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Seleccionar todos
                            <input type="checkbox" name="seleccionar-todos" id="seleccionar-todos" @checked(false)>
                        </th>
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
                                <input type="checkbox" name="seleccionados[]" id="seleccionado" value="{{ $medico->id }}">
                            </th>
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
        
    </form>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        window.addEventListener('DOMContentLoaded', (e) => {
            
            let seleccionarTodos = document.getElementById('seleccionar-todos');
            let seleccionado = document.querySelectorAll('#seleccionado');            

            seleccionarTodos.addEventListener('click', () =>{
                if (seleccionarTodos.checked == false){
                    
                    seleccionado.forEach(item => {
                        item.checked = false;
                    });

                }else{
                    
                    seleccionado.forEach(item => {
                        item.checked = true;
                    });
                }
            });
            
            
        });
    </script>
</body>
</html>