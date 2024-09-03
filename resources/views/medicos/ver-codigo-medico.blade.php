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
    .estado{
        width: 50%;
        text-align: center;
        padding: 5px 0px;
        border-radius: 8px;
        color: #FAFAFA;
    }

    .container-loader{
        display: flex;
        justify-content: center;
        align-items: center; 
        min-width: 100%;
        min-height: 100%;
        background-color: rgba(255, 255, 255, 1);
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
    {{-- Contenedor principal --}}
    {{-- Header --}}
    @includeIf('components.header')
    
    {{-- Creacion Exitosa --}}
    @if (session('info'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Creación exitosa</span> {{session('info')}}
            </div>
    @endif

    {{-- Actualizacion de datos exitosa --}}
    @if (session('successUpdate'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Actualizacion exitosa</span> {{session('successUpdate')}}
            </div>
    @endif


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
                        <td class="px-6 py-4 w-auto" style="font-size: 13px;">
                            @if ($medico->estado == false)
                                <div class="estado bg-red-600 w-32">
                                    QR no generado
                                </div>    
                            @else
                                <div class="estado bg-green-600 w-32">
                                    QR generado
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex w-auto">
                            @if ($medico->estado == false)
                                {{-- <button type="button" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">Envíar QR</button> --}}
                                <form method="POST" action="{{route('medicos.enviar', $medico->id)}}">
                                    @csrf
                                    <button type="submit" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded mr-2">
                                        Enviar QR
                                    </button>
                                </form>
                                <button data-id="{{ $medico->id }}" id="btnMostrarDatos" class="btnMostrarDatos w-32 bg-orange-500 text-white font-bold py-2 px-4 rounded">
                                    Ver datos
                                </button>
                                @else
                                <button data-id="{{ $medico->id }}" id="btnMostrarQR" class="btnMostrarQR w-32 bg-blue-500 text-white font-bold py-2 px-4 rounded mr-2">
                                    Ver QR
                                </button>
                                <button data-id="{{ $medico->id }}" id="btnMostrarDatos" class="btnMostrarDatos w-32 bg-orange-500 text-white font-bold py-2 px-4 rounded">
                                    Ver datos
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

    <!-- Modal ver QR -->
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
                    <p class="mb-5 text-bold" id="medico-nombre"></p>
                    {{-- <img style="width: 250px;" src="{{asset('/qrcodes/qrcode06208269-4.png')}}" alt=""> --}}
                    <img style="width: 250px;" id="medico-qr" src="" alt="">
                </div>
                <!-- Pie del Modal -->
                <div class="flex justify-end p-4">
                    <button onclick="closeQRModal()" class="bg-gray-500 text-white font-bold py-2 px-4 rounded mr-2">
                        Cerrar
                    </button>
                    <form method="POST" action="" id="formGenerarQR">
                        @csrf
                        <button type="button" onclick="generarQR()" id="btnGenerarQR" data-id="" class="bg-green-500 text-white font-bold py-2 px-4 rounded hidden">
                            Generar QR
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal ver datos y editar --}}
    <!-- Main modal -->
    <div id="medico-modal" class="hidden relative">
        {{-- Fondo oscuro --}}
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
            <div class="overflow-y-auto overflow-x-hidden z-50 inline-flex justify-center items-center" style="width:100%;">
                <div class="relative p-4" style="width: 50%;">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-96" style="width: 100%;">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Datos del médico
                            </h3>
                            <button type="button" onclick="closeInfoMedicos()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        {{-- Modal errores de validacion --}}
                        <div class="flex items-center justify-start px-4 rounded-t dark:border-gray-600">
                            @if ($errors->any())
                            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Danger</span>
                                <div>
                                    <span class="font-medium">Complete los siguientes campos</span>
                                    <ul class="mt-1.5 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>[{{ $error }}]]</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Modal body -->
                        <form class="p-4 md:p-5" action="" method="POST" id="formEditarDatosMedico">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                {{-- Nombre --}}
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                    <input type="text" name="nombre" id="nombreMedico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                                </div>

                                {{-- Tipo de documento --}}
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de documento</label>
                                    <input @readonly(true) type="text" name="tipo_documento" id="tipoDocumentoMedico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                                </div>

                                {{-- Numero de documento --}}
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero de documento</label>
                                    <input type="text" name="documento" id="numeroDocumentoMedico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                                </div>
                                
                                {{-- Correo --}}
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                                    <input type="text" name="correo" id="correoMedico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                                </div>

                                {{-- Estado --}}
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                    <div class="estado w-32" id="estadoMedicoContainer">
                                        <label for="" id="estadoMedico"></label>
                                    </div> 
                                </div>
                            </div>
                            <button type="button" id="btnEditarDatosMedico" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Actualizar datos
                            </button>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    // console.log(data);
                    if (data.qr != null){
                        document.getElementById('medico-qr').src = data.qr;
                        document.getElementById('medico-nombre').innerHTML = data.nombre;
                        document.getElementById('btnGenerarQR').classList.add('hidden');
                        setTimeout(() => {
                            loader.classList.add('hidden');
                        }, 1000);
                    }
                    else {
                        Swal.fire({
                            icon: "error",
                            title: "QR no encontrado",
                            text: "Parece que el código QR de " + data.nombre + " no fue encontrado",
                        });
                        document.getElementById('medico-nombre').innerHTML = 'Por favor vuelva a generar el QR';
                        document.getElementById('medico-qr').src = '';
                        document.getElementById('btnGenerarQR').setAttribute('data-id', data.id);
                        document.getElementById('btnGenerarQR').classList.remove('hidden');
                        // console.log(data.id);
                        loader.classList.add('hidden');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            // Mostrar el modal
            document.getElementById('modal').style.display = 'block';
            });
        });

        // Funcion para cerrar el modal
        function closeQRModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Funciones para los datos del medico
        document.querySelectorAll('.btnMostrarDatos').forEach((button) => {
            button.addEventListener('click', () => {
                // console.log('Boton accionado');

                let id = button.getAttribute('data-id');

                // Traer los datos del medicoc
                let URI = fetch('/medicos-qr/'+ id)
                    .then((response) => response.json())
                    .then((data) => {

                        // Cargar los datos en el modal
                        document.getElementById('nombreMedico').value = data.nombre;
                        document.getElementById('tipoDocumentoMedico').value = data.tipo_documento;
                        document.getElementById('numeroDocumentoMedico').value = data.documento;
                        document.getElementById('correoMedico').value = data.correo;

                        if (data.estado == true){
                            document.getElementById('estadoMedico').innerHTML = 'QR Enviado';
                            document.getElementById('estadoMedicoContainer').classList.remove('bg-red-600');
                            document.getElementById('estadoMedicoContainer').classList.add('bg-green-600');
                        } else {
                            document.getElementById('estadoMedico').innerHTML = 'QR no enviado';
                            document.getElementById('estadoMedicoContainer').classList.remove('bg-green-600');
                            document.getElementById('estadoMedicoContainer').classList.add('bg-red-600');
                        }

                        // Mostrar el modal
                        document.getElementById('medico-modal').style.display = 'block';

                        // Detonar el evento de envio del formulario para actualizar los datos
                        document.getElementById('btnEditarDatosMedico').addEventListener('click', () => {
                            let form = document.getElementById('formEditarDatosMedico');
                            form.action = '/medicos/'+id;
                            form.submit();
                        });
                    })
                    .catch((error) => {
                        console.error(error);
                    });
                });
            });
            
            // funcion para cerrar el modal de los datos del medico
            function closeInfoMedicos() {
                document.getElementById('medico-modal').style.display = 'none';
        };        

        // Funcion para regenerar el codigo QR
        function generarQR(){
            let id = document.getElementById('btnGenerarQR').getAttribute('data-id');
            let form = document.getElementById('formGenerarQR');

            form.action = '/medicos-regenerar/'+id;

            form.submit();
        }
    </script>
</body>
</html>