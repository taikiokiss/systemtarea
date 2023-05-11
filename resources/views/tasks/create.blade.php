@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Nueva Tarea</h4>
                    <a href="{{ route('tasks.index') }}"
                    class="btn btn-sm btn-danger float-right">
                        <i class="fas fa-chevron-left"></i> Regresar
                    </a> 

          </div>
        </div>
    </div>
</section>
<!-- CREACION  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body ">
                <!-- inicio -->
                {{ Form::open(['route' => 'tasks.store','enctype' =>'multipart/form-data', 'files'=>true]) }}
                    <form method="POST" action="{{ route('tasks.index') }}">
                    @csrf


                        <div class="form-group row">

                            <div class="col-md-6">
                            <label for="departamento" class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                                <select id="departamento" class="form-control" name="departamento">
                                    <option value="">Seleccione un departamento</option>
                                    @foreach ($datos['departma'] as $departm)
                                        <option value="{{ $departm->id }}">{{ $departm->namedt }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                            <label for="asign_a" class="col-form-label text-md-left">{{ __('Asignar a') }}</label>
                                <select id="asign_a" class="form-control" name="asign_a" disabled>
                                    <option value="">Seleccione a quien va asignada la tarea</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-8">
                            <label for="asunto" class="col-form-label text-md-left">{{ __('Asunto') }}</label>
                                <input id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror" name="asunto" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('asunto') }}"  autocomplete="asunto" autofocus >
                                @error('asunto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-2">
                            <label for="fecha_entrega" class="col-form-label text-md-left">{{ __('Fecha de entrega') }}</label>
                                <input id="fecha_entrega" type="date" class="form-control @error('fecha_entrega') is-invalid @enderror" name="fecha_entrega" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('fecha_entrega') }}"  autocomplete="fecha_entrega" autofocus >
                                @error('fecha_entrega')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-2">
                            <label for="rcada" class="col-form-label text-md-left">{{ __('Repetir cada') }}</label>
                                <input id="rcada" type="text" class="form-control @error('rcada') is-invalid @enderror" name="rcada" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('rcada') }}"  autocomplete="rcada" autofocus >
                                @error('rcada')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>


                        <div class="form-group row">

                            <div class="col-md-12">
                            <label for="descripcion" class="col-form-label text-md-left">{{ __('Detalle') }}</label>
                                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" onkeyup="this.value = this.value.toUpperCase();" rows="5" cols="50"  autocomplete="descripcion" autofocus >
                                </textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="descripcion" class="col-form-label text-md-left">{{ __('Archivos Adjuntos') }}</label>
                                <div class="container col-md-12">

                                        <input   class="form-control" id="file-input" type="file" name="files[]" multiple>

                                            <div  id="file-list"></div>

                                </div>
                            </div>
                        </div>




                        <hr>
  
                        <div class="form-group row was-validated mt-3">
                            <div class="col-md-12 col-md-offset-4 text-md-left">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Crear
                                </button>
                            </div>
                        </div>


                       

                </form>

                {{ Form::close() }}


              </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function soloNumeros(e){
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;
        return /\d/.test(String.fromCharCode(keynum));
    }
</script>  

<script>
    $(document).ready(function() {
        // Al cargar la página, el segundo select estará desactivado
        $('#asign_a').prop('disabled', true);

        // Cuando se seleccione un valor en el primer select, se activará el segundo select y se llenará con los valores correspondientes
        $('#departamento').change(function() {
            var departamento = $(this).val();
            if (departamento !== '') {
                $('#asign_a').prop('disabled', false);
                $('#asign_a').html('<option value="">Cargando...</option>');
                var opciones = @json($datos['opciones']);
                var options = '<option value="">Seleccione una opción</option>';
                opciones.forEach(function(opcion) {
                    if (opcion.id == departamento) { // <--- aquí se hace la comparación por id de departamento
                        options += '<option value="' + opcion.id + '">' + opcion.name + '</option>'; // <--- se utiliza id y nombre del usuario
                    }
                });
                $('#asign_a').html(options);
            } else {
                $('#asign_a').prop('disabled', true);
                $('#asign_a').html('<option value="">Seleccione una opción</option>');
            }
        });

    });
</script>
    <script>

const fileInput = document.getElementById("file-input");
const fileList = document.getElementById("file-list");
let files = [];

// Función para agregar un archivo a la lista
function addFileToList(file) {
    // Crea un objeto con información del archivo
    const fileInfo = {
        name: file.name,
        data: file
    };
    
    // Agrega el archivo a la lista de archivos
    files.push(fileInfo);

    // Crea un elemento de tabla
    const fileItem = document.createElement("div");
    fileItem.classList.add("file-item");
    
    // Agrega el nombre del archivo y el botón de eliminar
    const fileName = document.createElement("span");
    fileName.textContent = fileInfo.name;
    fileItem.appendChild(fileName);

    const deleteButton = document.createElement("button");
    deleteButton.classList.add("delete-button");
    deleteButton.textContent = "Eliminar";
    deleteButton.addEventListener("click", () => {
        // Elimina el archivo de la lista de archivos
        files = files.filter((f) => f !== fileInfo);
        // Actualiza la lista de archivos
        updateFileList();
    });
    fileItem.appendChild(deleteButton);

    // Agrega el elemento de archivo a la lista
    fileList.appendChild(fileItem);
}

// Función para actualizar la lista de archivos
function updateFileList() {
    fileList.innerHTML = "";
    files.forEach((fileInfo) => {
        const fileItem = document.createElement("div");
        fileItem.classList.add("file-item");
        
        const fileName = document.createElement("span");
        fileName.textContent = fileInfo.name;
        fileItem.appendChild(fileName);

        const deleteButton = document.createElement("button");
        deleteButton.classList.add("delete-button");
        deleteButton.textContent = "Eliminar";
        deleteButton.addEventListener("click", () => {
            files = files.filter((f) => f !== fileInfo);
            updateFileList();
        });
        fileItem.appendChild(deleteButton);

        fileList.appendChild(fileItem);
    });
}
    </script>
@endsection


