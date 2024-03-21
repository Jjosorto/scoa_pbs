<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="crearModelos" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nombreModelo">Nombre de Modelo:</label>
                        <input type="text" class="form-control" id="nombreModelo" name="nombreModelo" required>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_marca">Marcas:</label>
                        <select class="form-control marcas" name="id_marca" id="id_marca">
                            @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombreMarca }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_categoria">Categorias:</label>
                        <select class="form-control categorias" name="id_categoria" id="id_categoria">
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombreCategoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-dark">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <!-----------Script/---------------->
    <script>
        $(document).ready(function() {
            $('.marcas').select2();
            $('.categorias').select2();
            $('#crearModelos').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = $(this).serialize();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('modelos.store') }}", // validar de que la ruta sea correcta
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('modelos.index') }}";
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
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>


</x-app-layout>