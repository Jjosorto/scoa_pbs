<x-app-layout>
    <div class="container my-5 bg-dark shadow p-3 mb-5 bg-body-tertiary rounded" style="border-radius: 15px; height: 100%">

        <div class="container py-5 px-5 ">
            <div class="row">
                <div class="col-12 mb-5" style="text-align: end">
                    <a href="{{ route('categorias.create') }}">
                        <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                            Nueva Categoria
                        </button>
                    </a>
                </div>
            </div>
            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th style="text-align: end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombreCategoria }}</td>
                        <td>
                            @if($categoria->estadoCategoria == 0)
                            Inactiva
                            @else
                            Activa
                            @endif
                        </td>
                        <td style="text-align: end">
                            <a href="{{ route('categorias.edit', $categoria->id) }}"><button class="btn btn-dark"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button></a>
                            <button class="btn btn-secondary btn-desactivar" data-id="{{ $categoria->id }}"><i class="fas fa-ban" style="color: #ffffff;"></i></button>
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

            let table = $('#table').DataTable();

            $('#table').on('click', '.btn-desactivar', function() {
                var id = $(this).data('id');
                console.log('entró')
                Swal.fire({
                    title: "Desactivar categoria",
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
                        var url = "{{ route('categorias.desactive', ':id') }}";
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
                                            "{{ route('categorias.index') }}";
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
                                            "{{ route('categorias.index') }}";
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