<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <h2>Actualizar Activo</h2>
            <div class="container mt-5">
                <form id="createActivo" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="fechaCompra">fecha de compra:</label>
                        <input value="{{$activo->fechaDeCompra}}" type="date" class="form-control" id="fechaCompra" name="fechaCompra" required>
                    </div>
                    <div class="row col-12 py-2">

                        <div class="form-group col-4">
                            <label for="idContabilidad">Id Contambilidad:</label>
                            <input type="text" value="{{$activo->idContabilidad}}" class="form-control" id="idContabilidad" name="idContabilidad" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="estadoActivo">Estado Activo:</label>
                            <select class="form-control" name="estadoActivo" id="estadoActivo">
                                <option {{$activo->estadoActivo == 'Disponible' ? 'selected' : ''}} value="Disponible">Disponible</option>
                                <option {{$activo->estadoActivo == 'Asignado' ? 'selected' : ''}} value="Asignado">Asignado</option>
                                <option {{$activo->estadoActivo == 'Reparacion' ? 'selected' : ''}} value="Reparacion">Reparacion</option>
                                <option {{$activo->estadoActivo == 'Descartado' ? 'selected' : ''}} value="Descartado">Descartado</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="ciudad">Ciudad:</label>
                            <select class="form-control" name="ciudad" id="ciudad">
                                <option {{$activo->ciudad == 'Tegucigalpa'  ? 'selected' : ''}} value="Tegucigalpa">Tegucigalpa</option>
                                <option {{$activo->ciudad == 'La Ceiba'  ? 'selected' : ''}} value="La Ceiba">La Ceiba</option>
                                <option {{$activo->ciudad == 'San Pedro Sula'  ? 'selected' : ''}} value="San Pedro Sula">San Pedro Sula</option>
                                <option {{$activo->ciudad == 'Choluteca'  ? 'selected' : ''}} value="Choluteca">Choluteca</option>
                                <option {{$activo->ciudad == 'Comayagua'  ? 'selected' : ''}} value="Comayagua">Comayagua</option>
                                <option {{$activo->ciudad == 'Copan'  ? 'selected' : ''}} value="Copan">Copan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 row">

                        <div class="form-group my-4 col-4">
                            <label for="cliente_id">Cliente:</label>
                            <select class="form-control cliente" name="cliente_id" id="cliente_id">
                                @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $activo->cliente_id == $cliente->id ? 'selected' : '' }} >{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group my-4 col-4">
                            <label for="departamento_id">Departamento:</label>
                            <select class="form-control departarmento" name="departamento_id" id="departamento_id">
                                @foreach ($departamentos as $departamento)
                                <option {{ $activo->departamento_id == $departamento->id ? 'selected' : '' }} value="{{ $departamento->id }}">{{ $departamento->nombreDepartamento }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group my-4 col-4">
                            <label for="producto_id">Producto:</label>
                            <select class="form-control producto" name="producto_id" id="producto_id">
                                @foreach ($productos as $producto)
                                <option {{ $activo->producto_id == $producto->id ? 'selected' : '' }} value="{{ $producto->id }}">{{ $producto->nombre }} - {{$producto->serie}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0">
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{$activo->estado ? 'checked' : ''}}>
                            <label class="form-check-label" for="estadoProductos">
                                Estado
                            </label>
                        </div>
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
        $(document).ready(function() {


  


            $('.producto').select2();
            $('.cliente').select2();
            $('.departarmento').select2();

            $('#createActivo').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('activos.update', $activo->id) }}",
                    data: formData,
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