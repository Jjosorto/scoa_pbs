<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="crearProducto" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nombreProducto">Nombre de producto:</label>
                        <input value="{{$producto->nombre}}" type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                    </div>
                    <div class="row col-12 py-2">

                        <div class="form-group col-4">
                            <label for="serie">Serie:</label>
                            <input value="{{$producto->serie}}" type="text" class="form-control" id="serie" name="serie" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="ram">Ram:</label>
                            <input value="{{$producto->ram}}" type="text" class="form-control" id="ram" name="ram" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="procesador">Procesador:</label>
                            <input value="{{$producto->procesador}}" type="text" class="form-control" id="procesador" name="procesador" required>
                        </div>
                    </div>
                    <div class="col-12 row">

                        <div class="form-group col-6">
                            <label for="id_marca">Tipo de disco:</label>
                            <select class="form-control disco" name="tipoDisco" id="tipoDisco">
                                <option {{$producto->tipoDisco == 'HDD' ? 'selected' : ''}} value="HDD">HDD</option>
                                <option {{$producto->tipoDisco == 'SSD' ? 'selected' : ''}} value="SSD">SSD</option>
                                <option {{$producto->tipoDisco == 'NVMe' ? 'selected' : ''}} value="NVMe">NVMe</option>
                                <option {{$producto->tipoDisco == 'M.2' ? 'selected' : ''}} value="M.2">M.2</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="capacidadDisco">Capacidad Disco:</label>
                            <input value="{{$producto->capacidadDisco}}" type="text" class="form-control" id="capacidadDisco" name="capacidadDisco" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion:</label>
                        <input value="{{$producto->descripcion}}" type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_modelo">Modelos:</label>
                        <select class="form-control marcas" name="id_modelo" id="id_modelo">
                            @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->id }}" {{ $producto->modelo_id == $modelo->id ? 'selected' : '' }}>{{ $modelo->nombreModelo }} - {{ $modelo->marca->nombreMarca }} - {{ $modelo->categoria->nombreCategoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estadoProductos" value="0">
                            <input class="form-check-input" type="checkbox" id="estadoProductos" name="estadoProductos" value="1" {{$producto->estadoProductos ? 'checked' : ''}}>
                            <label class="form-check-label" for="estadoProductos">
                                Estado
                            </label>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group py-3">
                            <label for="imagen_historia">Seleccionar imagen de producto:</label>
                            <img src="{{ asset('storage/images/productos/' . $producto->nombreImagen) }}" id="imagenActual" style="max-width: 40%; max-height: 40%; border: 1px solid #ddd; display: block;" alt="Imagen de producto">
                            <input type="file" accept="image/productos/*" onchange="mostrarNuevaImagen(this)" id="nueva_imagen" name="nueva_imagen">
                            <label for="nueva_imagen" style="cursor: pointer;">
                                <img src="#" id="imagenNuevaHistoria" style="max-width: 40%; max-height: 40%; border: 1px solid #ddd; display: none;" alt="Nueva Imagen de producto">
                            </label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-dark">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-----------Script/---------------->
    <script>
        function mostrarImagenHistoria(input) {
            if (input.files && input.files[0]) {
                var lector = new FileReader();
                lector.onload = function(e) {
                    $('#imagenSeleccionadaHistoria').attr('src', e.target.result);
                }
                lector.readAsDataURL(input.files[0]);
            }
        }


        function mostrarNuevaImagen(input) {
            if (input.files && input.files[0]) {
                var lector = new FileReader();
                lector.onload = function(e) {
                    // Muestra la nueva imagen seleccionada
                    $('#imagenNuevaHistoria').attr('src', e.target.result).show();
                    // Oculta la imagen actual
                    $('#imagenActual').hide();
                }
                lector.readAsDataURL(input.files[0]);
            }
        }


        $(document).ready(function() {


            $('#crearProducto').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = new FormData(this);

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('productos.update',$producto->id) }}", // validar de que la ruta sea correcta
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('productos.index') }}";
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