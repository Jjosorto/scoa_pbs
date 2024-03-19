<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="crearModelos" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nombreModelo">Nombre de Modelo:</label>
                        <input type="text" class="form-control" id="nombreModelo" value="{{$modelo->nombreModelo}}" name="nombreModelo" required>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_marca">Marcas:</label>
                        <select class="form-control" name="id_marca" id="id_marca"> 
                            @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}" {{ $modelo->marca_id == $marca->id ? 'selected' : '' }}>
                            {{$marca->nombreMarca}}
                        </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_categoria">Categorias:</label>
                        <select class="form-control" name="id_categoria" id="id_categoria">
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $modelo->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{$categoria->nombreCategoria}}
                        </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estadoModelo" value="0">
                            <input class="form-check-input" type="checkbox" id="estadoModelo" name="estadoModelo" value="1" {{$modelo->estadoModelo ? 'checked' : ''}}>
                            <label class="form-check-label" for="estadoModelo">
                                Estado
                            </label>
                        </div>
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
            $('#crearModelos').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = $(this).serialize();


                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('modelos.update',$modelo->id) }}", // validar de que la ruta sea correcta
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