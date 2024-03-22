<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="crearProducto" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="fechaCompra">fecha de compra:</label>
                        <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" required>
                    </div>
                    <div class="row col-12 py-2">

                        <div class="form-group col-4">
                            <label for="idContabiliad">Id Contambilidad:</label>
                            <input type="text" class="form-control" id="idContabiliad" name="idContabiliad" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="estadoActivo">Estado Activo:</label>
                            <select class="form-control" name="estadoActivo" id="estadoActivo">
                                <option value="Disponible">Disponible</option>
                                <option value="Asignado">Asignado</option>
                                <option value="Reparacion">Reparacion</option>
                                <option value="Descartado">Descartado</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="ciudad">Ciudad:</label>
                            <select class="form-control" name="ciudad" id="ciudad">
                                <option value="Tegucigalpa">Tegucigalpa</option>
                                <option value="La Ceiba">La Ceiba</option>
                                <option value="San Pedro Sula">San Pedro Sula</option>
                                <option value="Choluteca">Choluteca</option>
                                <option value="Comayagua">Comayagua</option>
                                <option value="Copan">Copan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 row">

                        <div class="form-group my-4 col-4">
                            <label for="cliente_id">Cliente:</label>
                            <select class="form-control cliente" name="cliente_id" id="cliente_id">
                                @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group my-4 col-4">
                            <label for="departarmento_id">Departamento:</label>
                            <select class="form-control departarmento" name="departarmento_id" id="departarmento_id">
                                @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombreDepartamento }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group my-4 col-4">
                            <label for="producto_id">Producto:</label>
                            <select class="form-control producto" name="producto_id" id="producto_id">
                                @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }} - {{$producto->serie}}</option>
                                @endforeach
                            </select>
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

            $('.producto').select2();
            $('.cliente').select2();
            $('.departarmento').select2();

            $('#crearProducto').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = new FormData(this);

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('activos.store') }}", // validar de que la ruta sea correcta
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
                                window.location.href = "{{ route('activos.index') }}";
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