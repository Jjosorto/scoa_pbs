<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 shadow p-3 mb-5 bg-body-tertiary rounded my-4">
            <div class="container mt-5">
                <form id="editCliente" method="post">
                    @csrf
                    <div class="form-group">
                    <label for="nombre">Nombre de Cliente:</label>
                        <input type="text" value="{{$cliente->nombre}}" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" value="{{$cliente->direccion}}"class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" value="{{$cliente->correo}}" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono:</label>
                        <input type="tel" value="{{$cliente->telefono}}"class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0">
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{$cliente->estado ? 'checked' : ''}}>
                            <label class="form-check-label" for="estado">Estado</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-dark">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editCliente').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

            
                $.ajax({
                    type: 'POST',
                    url: "{{ route('clientes.update', $cliente->id) }}", 
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('clientes.index') }}";
                            }
                        });

                    },
                    error: function(xhr) {
                        // Maneja los errores de validación u otros errores
                        var errors = xhr.responseJSON;
                        console.log(xhr);
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