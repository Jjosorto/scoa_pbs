<x-app-layout>
    <div class="row justify-content-center">

        <div class="col-md-10 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">

            <div class=" row col-12 mb-5">
                <form action="" method="GET" class="col-8">
                    <div class=" col-12 row">
                        <div class="col-4">
                            <input class="form-control" id="fechaInicio" type="date">
                        </div>
                        <div class="col-4">
                            <input class="form-control" id="fechaFinal" type="date">
                        </div>
                        <button class="btn btn-dark col-4"><i class="fa-solid fa-magnifying-glass"></i>
                            Consultar
                        </button>
                    </div>
                </form>
                <div class="col-2">

                    <a href="{{ route('activos.create') }}">
                        <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                            Nuevo Activo
                        </button>
                    </a>
                </div>
                <div class="col-2">

                    <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                        Generar PDF
                    </button>
                </div>

            </div>

            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Fecha De Compra</th>
                        <th>idContabilidad</th>
                        <th>Estado Activo</th>
                        <th>estado</th>
                        <th>Cliente</th>
                        <th>Departamento</th>
                        <th>Producto</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Imagen</th>
                        <th style="text-align: end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activos as $activo)
                    <tr>
                        <td>{{ $activo->fechaDeCompra }}</td>
                        <td>{{ $activo->idContabilidad }}</td>
                        <td>{{ $activo->estadoActivo }}</td>
                        <td>@if($activo->estadoActivo == 0)
                            Inactivo
                            @else
                            Activo
                            @endif
                        </td>
                        <td>{{ $activo->cliente->nombre }}</td>
                        <td>{{ $activo->departamento->nombreDepartamento }}</td>
                        <td>{{ $activo->producto->nombre }}</td>
                        <td>{{ $activo->producto->modelos->nombreModelo }}</td>
                        <td>{{ $activo->producto->modelos->marca->nombreMarca }}</td>
                        <td>{{ $activo->producto->modelos->categoria->nombreCategoria }}</td>
                        <td><img src="{{ 'storage/images/productos/' . $activo->producto-> nombreImagen }}" alt="{{ $activo->producto-> nombreImagen}}" class="img-fluid rounded" style="max-width: 100%; height: auto;""></td>
                        <td style=" text-align: end">
                            <a href="{{ route('productos.edit', $activo->id) }}"><button class="btn btn-dark"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button></a>
                            <button class="btn btn-secondary btn-desactivar" data-id="{{ $activo->id }}"><i class="fas fa-ban" style="color: #ffffff;"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-----------Script/---------------->
    <script>
        function setTodayDate() {
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // January is 0!
            let dd = today.getDate();

            // String formatting for consistent output (YYYY-MM-DD)
            mm = mm.toString().padStart(2, '0');
            dd = dd.toString().padStart(2, '0');

            const formattedDate = yyyy + '-' + mm + '-' + dd;

            document.getElementById("fechaInicio").value = formattedDate;
            document.getElementById("fechaFinal").value = formattedDate;
        }

        
        
        $(document).ready(function() {
            setTodayDate();

            $('form').submit(function(event) {
            // Prevenir el comportamiento predeterminado del formulario (envío)
            event.preventDefault();

            // URL de la ruta definida en Laravel
            var url = "{{ route('activos.byfecha') }}";

            // Obtener los valores de los campos de entrada
            var fechaInicio = $("#fechaInicio").val();
            var fechaFinal = $("#fechaFinal").val();

            // Realizar la petición AJAX GET a la URL con los datos de los campos de entrada
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    fechaInicio: fechaInicio,
                    fechaFinal: fechaFinal
                },
                success: function(data) {
                    // Limpiar el contenido actual de la tabla
                    $('#table tbody').empty();

                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(data.activos, function(index, activo) {
                        var row = '<tr>' +
                            '<td>' + activo.fechaDeCompra + '</td>' +
                            '<td>' + activo.idContabilidad + '</td>' +
                            '<td>' + activo.estadoActivo + '</td>' +
                            '<td>' + (activo.estadoActivo == 0 ? 'Inactivo' : 'Activo') + '</td>' +
                            '<td>' + activo.cliente.nombre + '</td>' +
                            '<td>' + activo.departamento.nombreDepartamento + '</td>' +
                            '<td>' + activo.producto.nombre + '</td>' +
                            '<td>' + activo.producto.modelos.nombreModelo + '</td>' +
                            '<td>' + activo.producto.modelos.marca.nombreMarca + '</td>' +
                            '<td>' + activo.producto.modelos.categoria.nombreCategoria + '</td>' +
                            '<td><img src="storage/images/productos/' + activo.producto.nombreImagen + '" alt="' + activo.producto.nombreImagen + '" class="img-fluid rounded" style="max-width: 100%; height: auto;"></td>' +
                            '<td style="text-align: end">' +
                            '<a href="{{ route("productos.edit", ":id") }}"><button class="btn btn-dark"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button></a>' +
                            '<button class="btn btn-secondary btn-desactivar" data-id="' + activo.id + '"><i class="fas fa-ban" style="color: #ffffff;"></i></button>' +
                            '</td>' +
                            '</tr>';
                        $('#table tbody').append(row);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manejar errores
                    console.error('Error:', textStatus, errorThrown);
                }
            });
        });
            







            let table = $('#table').DataTable({
                scrollX: true
            });

            $('#table').on('click', '.btn-desactivar', function() {
                var id = $(this).data('id');
                console.log('entró')
                Swal.fire({
                    title: "Desactivar producto",
                    text: "¿Desea continuar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-dark mx-2',
                        cancelButton: 'btn btn-secondary mx-2'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('productos.desactive', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            type: 'get',
                            url: url,
                            success: function(response) {
                                Swal.fire(
                                    'Acción Exitosa',
                                    'La acción se realizó con éxito.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('productos.index') }}";
                                    }
                                });

                            },
                            error: function(xhr) {
                                // Maneja los errores de validación u otros errores
                                var errors = xhr.responseJSON;
                                Swal.fire(
                                    'Error',
                                    'No se pudo realizar la acción.',
                                    'error'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('modelos.index') }}";
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>