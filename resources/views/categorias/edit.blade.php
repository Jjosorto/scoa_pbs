<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 shadow p-3 mb-5 bg-body-tertiary rounded my-4">
            <div class="container mt-5">
                <form id="editCategoria" method="post">
                    @csrf
                    <div class="form-group">
                    <label for="nombreCategoria">Nombre de Categoria:</label>
                        <input type="text" value="{{$categoria->nombreCategoria}}" class="form-control" id="nombreCategoria" name="nombreCategoria" required>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estadoCategoria" value="0">
                            <input class="form-check-input" type="checkbox" id="estadoCategoria" name="estadoCategoria" value="1" {{$categoria->estadoCategoria ? 'checked' : ''}}>
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
 <!-----------Script/---------------->
    <script>
        $(document).ready(function() {
            $('#editCategoria').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

            
                $.ajax({
                    type: 'POST',
                    url: "{{ route('categorias.update', $categoria->id) }}", 
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('categorias.index') }}";
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