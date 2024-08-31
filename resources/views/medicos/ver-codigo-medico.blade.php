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

    {{-- Header --}}
    @includeIf('components.header')

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
                                <button type="button" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">Envíar QR</button>
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
    <div id="modal" class="hidden">
        <!-- Fondo Oscuro -->
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" id="fondoModal">
            <div class="bg-white rounded shadow-lg max-w-md w-full" style="z-index: 10;">
                <!-- Encabezado del Modal -->
                <div class="flex justify-between items-center border-b p-4 mb-4">
                    <h2 class="text-xl font-semibold">Código QR generado</h2>
                </div>
                <!-- Cuerpo del Modal -->
                <div class="mb-6 flex flex-col justify-center items-center px-4">
                    <p class="mb-3">
                        Contenido del modal aquí...
                    </p>
                    {{-- <img src="https://static.shuffle.dev/components/preview/7c53484e-283d-478f-ad4c-cb38f472fed4/contact/03_awz.jpg" alt=""> --}}
                    {{-- <img style="width: 250px;" src="{{asset('/qrcodes/qrcode06208269-4.png')}}" alt=""> --}}
                    <img style="width: 250px;" id="medico-qr" src="" alt="">
                </div>
                <!-- Pie del Modal -->
                <div class="flex justify-end p-4">
                    <button onclick="closeModal()" class="bg-gray-500 text-white font-bold py-2 px-4 rounded mr-2">
                        Cerrar
                    </button>
                    <button class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                        Reenviar QR
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        // let fondo = document.getElementById('fondoModal');
        // fondo.addEventListener('click', function(e){
        //     e.preventDefault();
        //     document.getElementById('modal').style.display = 'none';
        // });

        // Obtener el qr del medico para mostrarlo en el modal
        document.querySelectorAll('.btnMostrarQR').forEach(button => {
            button.addEventListener('click', () => {
                let id = button.getAttribute('data-id');

                let URI = fetch('/medicos-qr/'+ id)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    document.getElementById('medico-qr').src = data.qr;
                });

            document.getElementById('modal').style.display = 'block';
            });
        });

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // JQUERY PARA LA TABLA
        $(document).ready(function() {
            $('#buscar').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('busqueda-qr.mostrar') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        $('#tabla-medicos').html('');

                        data.forEach(function(medico) {
                            $('#tabla-medicos').append(`
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        ${medico.id}
                                    </th>
                                    <td class="px-6 py-4">
                                        ${medico.nombre}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${medico.correo}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($medico->estado == true)
                                            QR no generado
                                        @else
                                            QR generado
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($medico->estado == true)
                                            <button type="button" class="w-32 bg-green-500 text-white font-bold py-2 px-4 rounded">Envíar QR</button>
                                        @else
                                            <button onclick="openModal()" class="w-32 bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                Ver QR
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });

                
            });
        });
    </script>
</body>
</html>