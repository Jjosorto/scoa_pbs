<x-app-layout>
    <div class="row justify-content-center">

        <div class="col-md-10 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="row">
                <div class="col-12 mb-5" style="text-align: end">
                    <a href="{{ route('mantenimiento.create', $activo->id) }}">
                        <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                            Nuevo Mantenimiento
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-12 rounded bg-white p-2 m-1 shadow-sm row">
                <h3>{{$activo->producto->nombre}}</h3>
                <div class="col-5">
                    <p>Fecha de compra: {{$activo->fechaDeCompra}}</p>
                    <p>Id Contabilidad: {{$activo->idContabilidad}}</p>
                    <p>Estado Actual: {{$activo->estadoActivo}}</p>
                    <p>Departamento: {{$activo->Departamento->nombreDepartamento}}
                </div>
                <div class="col-5">
                    <p>Cliente: {{$activo->cliente->nombre}}</p>
                    <p>Modelo: {{$activo->producto->modelos->nombreModelo}}</p>
                    <p>Marca: {{$activo->producto->modelos->marca->nombreMarca}}</p>
                    <p>Categoria: {{$activo->producto->modelos->categoria->nombreCategoria}}</p>
                </div>
            </div>
            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Fecha de mantenimiento</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activo->mantenimientos as $mantenimiento)
                    <tr>
                        <td>{{ $mantenimiento->fecha_registro }}</td>
                        <td>{{ $mantenimiento->estadoActivo }}</td>
                        <td>{{ $mantenimiento->descripcion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-----------Script/---------------->
    <script>
        $(document).ready(function() {

            new DataTable('#table', {
                language: {
                    searchBuilder: {
                        condition: 'comparar',
                    }
                },
                layout: {
                    topStart: {
                        buttons: ['excel', 'pdf', 'print', {
                            extend: 'searchBuilder',
                            config: {
                                depthLimit: 2
                            }
                        }]
                    }
                }
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