@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Nueva Tarea</h4>
              <a  href="{{ URL::previous() }}"
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
                    <form method="POST" action="{{ route('tasks.principales.index') }}">
                    @csrf


                        <div class="form-group row">

                            <div class="col-md-6">
                            <label for="departamento" class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                                <select id="departamento" class="form-control" name="departamento">
                                    <option value="" selected disabled >Seleccione un departamento</option>
                                    @foreach ($datos['departma'] as $departm)
                                        <option value="{{ $departm->id }}">{{ $departm->namedt }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                            <label for="asign_a" class="col-form-label text-md-left">{{ __('Asignar a') }}</label>
                                <select id="asign_a" class="form-control" name="asign_a" disabled>
                                    <option value="" selected disabled>Seleccione a quien va asignada la tarea</option>
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
                                <input id="fecha_entrega" type="date" class="form-control" max="<?php echo date('d/m/Y')?>" placeholder="DD/MM/AAAA" value="<?php echo date('d/m/Y')?>" name="fecha_entrega" value="{{ old('fecha_entrega') }}"  autocomplete="fecha_entrega" autofocus >
                                @error('fecha_entrega')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-2">
                            <label for="rcada" class="col-form-label text-md-left">{{ __('Repetir cada') }}</label>
                                <select  class="custom-select target form-control @error('rcada') is-invalid @enderror" id="rcada" name="rcada">
                                    @foreach($opcion_rrp as $opc_v)
                                        <option value="{{$opc_v->id}}">{{$opc_v->opcion}}</option>
                                    @endforeach 
                                </select>

                            </div>

                        </div>


                        <div class="form-group row">

                            <div class="col-md-12">
                            <label for="descripcion" class="col-form-label text-md-left">{{ __('Detalle') }}</label>
                                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" onkeyup="this.value = this.value.toUpperCase();" rows="5" cols="50"  autocomplete="descripcion" autofocus ></textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="attachment" class="col-form-label text-md-left">{{ __('Archivos Adjuntos') }} 
                                        <a class="btn btn-outline-primary btn-sm" role="button" aria-disabled="false">+ Agregar</a>
                                </label>
                                <div class="container col-md-12">
                                    <input type="file" name="file[]"  id="attachment" style="visibility: hidden; position: absolute;" multiple/>
                                    <p id="files-area">
                                        <span id="filesList">
                                            <span id="files-names"></span>
                                        </span>
                                    </p>


                                </div>
                            </div>
                        </div>


                        <div class="form-group row was-validated mt-3">
                            <div class="col-md-12 col-md-offset-4 text-md-left">
                                <button type="submit" class="btn btn-primary btn-block" value="Crear">
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
                        options += '<option value="' + opcion.idperson + '">' + opcion.last_name +' '+ opcion.name +  '</option>'; // <--- se utiliza id y nombre del usuario
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

<script type="text/javascript">
const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

$("#attachment").on('change', function(e){
    for(var i = 0; i < this.files.length; i++){
        let fileBloc = $('<span/>', {class: 'file-block'}),
             fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
        fileBloc.append('<span class="file-delete"><span>+</span></span>')
            .append(fileName);
        $("#filesList > #files-names").append(fileBloc);
    };
    // Ajout des fichiers dans l'objet DataTransfer
    for (let file of this.files) {
        dt.items.add(file);
    }
    // Mise à jour des fichiers de l'input file après ajout
    this.files = dt.files;

    // EventListener pour le bouton de suppression créé
    $('span.file-delete').click(function(){
        let name = $(this).next('span.name').text();
        // Supprimer l'affichage du nom de fichier
        $(this).parent().remove();
        for(let i = 0; i < dt.items.length; i++){
            // Correspondance du fichier et du nom
            if(name === dt.items[i].getAsFile().name){
                // Suppression du fichier dans l'objet DataTransfer
                dt.items.remove(i);
                continue;
            }
        }
        // Mise à jour des fichiers de l'input file après suppression
        document.getElementById('attachment').files = dt.files;
    });
});    

</script>

@endsection


