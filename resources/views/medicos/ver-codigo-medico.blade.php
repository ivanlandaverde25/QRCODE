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

.container-loader{
    display: flex;
    justify-content: center;
    align-items: center; 
    min-width: 100%;
    min-height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    position: absolute;
    z-index: 10;
}

.loader {
    color: #333333;
    font-size: 45px;
    text-indent: -9999em;
    overflow: hidden;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    position: absolute;
    transform: translateZ(0);
    animation: mltShdSpin 1.7s infinite ease, round 1.7s infinite ease;
    z-index: 10;
}

@keyframes mltShdSpin {
  0% {
    box-shadow: 0 -0.83em 0 -0.4em,
    0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em,
    0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  5%,
  95% {
    box-shadow: 0 -0.83em 0 -0.4em, 
    0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 
    0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  10%,
  59% {
    box-shadow: 0 -0.83em 0 -0.4em, 
    -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, 
    -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
  }
  20% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em,
     -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, 
     -0.749em -0.34em 0 -0.477em;
  }
  38% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em,
     -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, 
     -0.82em -0.09em 0 -0.477em;
  }
  100% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 
    0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
}

@keyframes round {
  0% { transform: rotate(0deg) }
  100% { transform: rotate(360deg) }
}
 
</style>
<body style="padding: 20px;">

    {{-- Header --}}
    @includeIf('components.header')
    <p>
        @isset($info)
            {{ $info }}
        @endisset
    </p>

    {{-- Contenedor principal --}}
    <h1>Aqui van las card de los usuarios</h1>
    <!-- Input de búsqueda -->
    <input type="text" id="buscar" class="form-control" placeholder="Buscar...">

    <!-- Tabla donde se mostrarán los resultados -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Correo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody id="tabla-medicos">
                @foreach ($medicos as $medico)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$medico->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$medico->nombre}}
                        </td>
                        <td class="px-6 py-4">
                            {{$medico->correo}}
                        </td>
                        <td class="px-6 py-4">
                            @if ($medico->estado == false)
                                QR no generado
                            @else
                                QR generado
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($medico->estado == false)
                                {{-- <button type="button" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">Envíar QR</button> --}}
                                <form method="POST" action="{{route('medicos.enviar', $medico->id)}}">
                                    @csrf
                                    <button type="submit" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">
                                        Enviar QR
                                    </button>
                                </form>
                            @else
                                <button onclick="" data-id="{{ $medico->id }}" id="btnMostrarQR" class="btnMostrarQR w-32 bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Ver QR
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        {{$medicos->links()}}
    </div>

    <!-- Modal -->
    <div id="modal" class="hidden relative">
        <!-- Fondo Oscuro -->
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" id="fondoModal">
            <div class="bg-white rounded shadow-lg max-w-md w-full">
                <!-- Encabezado del Modal -->
                <div class="flex justify-between items-center border-b p-4 mb-4">
                    <h2 class="text-xl font-semibold">Código QR generado</h2>
                </div>
                <!-- Cuerpo del Modal -->
                <div class="mb-6 flex flex-col justify-center items-center px-4 relative">
                    <!-- Loader -->
                    <div class="container-loader hidden" id="loader">
                        <span class="loader"></span>
                    </div>
                    <p class="mb-5" id="medico-nombre">
                    </p>
                    {{-- <img style="width: 250px;" src="{{asset('/qrcodes/qrcode06208269-4.png')}}" alt=""> --}}
                    <img style="width: 250px;" id="medico-qr" src="" alt="">
                </div>
                <!-- Pie del Modal -->
                <div class="flex justify-end p-4">
                    <button onclick="closeModal()" class="bg-gray-500 text-white font-bold py-2 px-4 rounded mr-2">
                        Cerrar
                    </button>
                    <form method="POST" action="{{route('medicos.regenerar', $medico)}}">
                        @csrf
                        <button type="submit" id="btnGenerarQR" data-id="" class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                            Generar QR
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        let loader = document.getElementById('loader');

        // Obtener el qr del medico para mostrarlo en el modal
        document.querySelectorAll('.btnMostrarQR').forEach(button => {
            button.addEventListener('click', () => {
                let id = button.getAttribute('data-id');

                loader.classList.remove('hidden');
                let URI = fetch('/medicos-qr/'+ id)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.qr != null){
                        document.getElementById('medico-qr').src = data.qr;
                        document.getElementById('medico-nombre').innerHTML = data.nombre;
                        setTimeout(() => {
                            loader.classList.add('hidden');
                        }, 1000);
                    }
                    else {
                        alert('No se ha generado el QR para este médico.');
                        document.getElementById('medico-nombre').innerHTML = 'Por favor vuelva a generar el QR';
                        document.getElementById('medico-qr').src = '';
                        document.getElementById('btnGenerarQR').setAttribute('data-id', data.id);
                        console.log(data.id);
                        loader.classList.add('hidden');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            document.getElementById('modal').style.display = 'block';
            });
        });

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // JQUERY PARA LA TABLA
        // $(document).ready(function() {
        //     $('#buscar').on('keyup', function() {
        //         let query = $(this).val();

        //         $.ajax({
        //             url: "{{ route('busqueda-qr.mostrar') }}",
        //             type: "GET",
        //             data: { query: query },
        //             success: function(data) {
        //                 $('#tabla-medicos').html('');

        //                 data.forEach(function(medico) {
        //                     $('#tabla-medicos').append(`
        //                         <tr>
        //                             <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        //                                 ${medico.id}
        //                             </th>
        //                             <td class="px-6 py-4">
        //                                 ${medico.nombre}
        //                             </td>
        //                             <td class="px-6 py-4">
        //                                 ${medico.correo}
        //                             </td>
        //                             <td class="px-6 py-4">
        //                                 @if ($medico->estado == true)
        //                                     QR no generado
        //                                 @else
        //                                     QR generado
        //                                 @endif
        //                             </td>
        //                             <td class="px-6 py-4">
        //                                 @if ($medico->estado == true)
        //                                     <button type="button" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">Envíar QR</button>
        //                                 @else
        //                                     <button onclick="openModal()" class="w-32 bg-blue-500 text-white font-bold py-2 px-4 rounded">
        //                                         Ver QR
        //                                     </button>
        //                                 @endif
        //                             </td>
        //                         </tr>
        //                     `);
        //                 });
        //             }
        //         });

                
        //     });
        // });
    </script>
</body>
</html>