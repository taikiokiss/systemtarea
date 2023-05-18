@extends('layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Modificar Tarea</h4>
            <div class="btn-group float-right">
              <a  href="{{ route('tasks.index') }}"
                  class="btn btn-sm btn-danger">
                  <i class="fas fa-arrow-left"></i> Atras
              </a>
            </div>
          </div>
        </div>
    </div>
</section>



{!! Form::model($tasks, ['route' => ['tasks.update', $tasks->id],'method' => 'PUT','enctype' =>'multipart/form-data', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body ">
                <!-- inicio -->
                        <div class="form-group row">

                            <div class="col-md-6">
                            <label for="departamento" class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                                <select id="departamento" class="form-control" name="departamento">
                                    <option selected disabled value="{{$tasks1[0]->depaid}}">{{$tasks1[0]->namedt}}</option>
                                    @foreach ($datos['departma'] as $departm)
                                        <option value="{{ $departm->id }}">{{ $departm->namedt }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                            <label for="asign_a" class="col-form-label text-md-left">{{ __('Asignar a') }}</label>
                                <select id="asign_a" class="form-control" name="asign_a" disabled>
                                    <option selected disabled value="{{$tasks1[0]->IdAsig}}">{{$tasks1[0]->ApellidoAsig}} {{$tasks1[0]->NombreAsig}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-8">
                            <label for="asunto" class="col-form-label text-md-left">{{ __('Asunto') }}</label>
                                <input id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror" name="asunto" onkeyup="this.value = this.value.toUpperCase();" value="{{ $tasks1[0]->asunto }}"  autocomplete="asunto" autofocus >
                                @error('asunto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-2">
                            <label for="fecha_entrega" class="col-form-label text-md-left">{{ __('Fecha de entrega') }}</label>
                                <input id="fecha_entrega" type="date" class="form-control" value="<?php echo date('Y-m-d',strtotime($tasks1[0]->fecha_entrega));?>" name="fecha_entrega" >
                                @error('fecha_entrega')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-2">
                            <label for="rcada" class="col-form-label text-md-left">{{ __('Repetir cada') }}</label>
                                <select  class="custom-select target form-control @error('rcada') is-invalid @enderror" id="rcada" name="rcada">
                                    <option selected disabled value="{{$ciclo[0]->id}}">{{$ciclo[0]->opcion}}</option>
                                    @foreach($opcion_rrp as $opc_v)
                                        <option value="{{$opc_v->id}}">{{$opc_v->opcion}}</option>
                                    @endforeach 
                                </select>

                            </div>

                        </div>



                        <div class="form-group row">

                            <div class="col-md-12">
                            <label for="descripcion" class="col-form-label text-md-left">{{ __('Detalle') }}</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" onkeyup="this.value = this.value.toUpperCase();" rows="5">{{ $tasks1[0]->descripcion }}</textarea>
                            </div>

                        </div>
              </div>
            </div>
        </div>
    </div>
</div>                        
{!! Form::close() !!}

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
                        options += '<option value="' + opcion.id + '">' + opcion.last_name +' '+ opcion.name +  '</option>'; // <--- se utiliza id y nombre del usuario
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