<x-app-layout>
<div class="row justify-content-center">

<div class="col-md-10 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="row">
                <div class="col-12 mb-5" style="text-align: end">
                    <a href="{{ route('productos.create') }}">
                        <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                            Nuevo producto 
                        </button>
                    </a>
                </div>  
            </div>
            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Nombre de Producto</th>
                        <th>Serie</th>
                        <th>Ram</th>
                        <th>Procesador</th>
                        <th>Tipo Disco</th>
                        <th>Capacidad Disco</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Imagen Producto</th>
                        <th style="text-align: end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->serie }}</td>
                        <td>{{ $producto->ram ? $producto->tipoDisco : "N/A" }}</td>
                        <td>{{ $producto->procesador ? $producto->tipoDisco : "N/A"  }}</td>
                        <td>{{ $producto->tipoDisco ? $producto->tipoDisco : "N/A" }}</td>
                        <td>{{ $producto->capacidadDisco  ? $producto->tipoDisco : "N/A" }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>@if($producto->estadoProductos == 0)
                            Inactivo
                            @else
                            Activo
                            @endif
                        </td>
                        <td>{{ $producto->modelos->nombreModelo }}</td>
                        <td>{{ $producto->modelos->marca->nombreMarca }}</td>
                        <td>{{ $producto->modelos->categoria->nombreCategoria }}</td>
                        <td><img src="{{ 'storage/images/productos/' . $producto-> nombreImagen }}" alt="{{ $producto-> nombreImagen}}" class="img-fluid rounded" style="max-width: 100%; height: auto;""></td>
                        <td style="text-align: end">
                            <a href="{{ route('productos.edit', $producto->id) }}"><button class="btn btn-dark"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button></a>
                            <button class="btn btn-secondary btn-desactivar" data-id="{{ $producto->id }}"><i class="fas fa-ban" style="color: #ffffff;"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
 <!-----------Script/---------------->
    <script>
        $(document).ready(function() {

            let table = $('#table').DataTable({scrollX :true});

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