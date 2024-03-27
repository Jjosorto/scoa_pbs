<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <h2>Crear Activo</h2>
            <div class="container mt-5">
                <form id="createActivo" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="fechaCompra">fecha de compra:</label>
                        <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" required>
                    </div>
                    <div class="row col-12 py-2">

                        <div class="form-group col-4">
                            <label for="idContabilidad">Id Contambilidad:</label>
                            <input type="text" class="form-control" id="idContabilidad" name="idContabilidad" required>
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
                            <label for="departamento_id">Departamento:</label>
                            <select class="form-control departarmento" name="departamento_id" id="departamento_id">
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
                    <div class="col-12 row">

                        <div class="form-check form-switch col-4">
                            <input type="hidden" name="garantia" value="0">
                            <input class="form-check-input" type="checkbox" id="garantia" name="garantia" value="1" onchange="toggleFechaInputs()">
                            <label class="form-check-label" for="estadoProductos">
                                Garantía
                            </label>
                        </div>

                        <div class="form-group col-4" id="fechaInicioContainer" style="display:none;">
                            <label for="fecha_inicio_garantia">fecha de inicio:</label>
                            <input type="date" class="form-control" id="fecha_inicio_garantia" name="fecha_inicio_garantia" required disabled>
                        </div>

                        <div class="form-group col-4" id="fechaFinalContainer" style="display:none;">
                            <label for="fecha_final_garantia">fecha de finalización:</label>
                            <input type="date" class="form-control" id="fecha_final_garantia" name="fecha_final_garantia" required disabled>
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
        function toggleFechaInputs() {
            var estadoCheckbox = document.getElementById("garantia");
            var fechaInicioContainer = document.getElementById("fechaInicioContainer");
            var fechaFinalContainer = document.getElementById("fechaFinalContainer");

            if (estadoCheckbox.checked) {
                fechaInicioContainer.style.display = "block";
                fechaFinalContainer.style.display = "block";
                document.getElementById("fecha_inicio_garantia").disabled = false;
                document.getElementById("fecha_final_garantia").disabled = false;
            } else {
                fechaInicioContainer.style.display = "none";
                fechaFinalContainer.style.display = "none";
                document.getElementById("fecha_inicio_garantia").disabled = true;
                document.getElementById("fecha_final_garantia").disabled = true;
            }
        }


        $(document).ready(function() {


            function setTodayDate() {
                const today = new Date();
                const yyyy = today.getFullYear();
                let mm = today.getMonth() + 1; // January is 0!
                let dd = today.getDate();

                // String formatting for consistent output (YYYY-MM-DD)
                mm = mm.toString().padStart(2, '0');
                dd = dd.toString().padStart(2, '0');

                const formattedDate = yyyy + '-' + mm + '-' + dd;

                document.getElementById("fechaCompra").value = formattedDate;
                document.getElementById("fecha_inicio_garantia").value = formattedDate;
                document.getElementById("fecha_final_garantia").value = formattedDate;
            }

            setTodayDate();


            $('.producto').select2();
            $('.cliente').select2();
            $('.departarmento').select2();

            $('#createActivo').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('activos.store') }}",
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