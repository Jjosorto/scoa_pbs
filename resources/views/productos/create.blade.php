<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="crearProducto" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nombreProducto">Nombre de producto:</label>
                        <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                    </div>
                    <div class="row col-12 py-2">

                        <div class="form-group col-4">
                            <label for="serie">Serie:</label>
                            <input type="text" class="form-control" id="serie" name="serie" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="ram">Ram:</label>
                            <input type="text" class="form-control" id="ram" name="ram" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="procesador">Procesador:</label>
                            <input type="text" class="form-control" id="procesador" name="procesador" required>
                        </div>
                    </div>
                    <div class="col-12 row">

                        <div class="form-group col-6">
                            <label for="id_marca">Tipo de disco:</label>
                            <select class="form-control disco" name="tipoDisco" id="tipoDisco">
                                <option value="HDD">HDD</option>
                                <option value="SSD">SSD</option>
                                <option value="NVMe">NVMe</option>
                                <option value="M.2">M.2</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="capacidadDisco">Capacidad Disco:</label>
                            <input type="text" class="form-control" id="capacidadDisco" name="capacidadDisco" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group my-4">
                        <label for="id_modelo">Modelos:</label>
                        <select class="form-control marcas" name="id_modelo" id="id_modelo">
                            @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->id }}">{{ $modelo->nombreModelo }} - {{ $modelo->marca->nombreMarca }} - {{ $modelo->categoria->nombreCategoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py-3 col-md-6">
                        <label for="imagen_producto">Seleccionar imagen Producto:</label>
                        <input type="file" accept="image/*" onchange="mostrarImagenProducto(this)" style="display: none;" id="imagen_producto" name="imagen_producto">
                        <label for="imagen_producto" style="cursor: pointer;">
                            <img src="#" id="imagenProducto" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; display: block;" alt="Imagen Producto">
                        </label>
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
        function mostrarImagenProducto(input) {
            if (input.files && input.files[0]) {
                var lector = new FileReader();
                lector.onload = function(e) {
                    $('#imagenProducto').attr('src', e.target.result);
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
                    url: "{{ route('productos.store') }}", // validar de que la ruta sea correcta
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