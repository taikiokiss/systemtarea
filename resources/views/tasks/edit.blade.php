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
<div class="container-fluid" style="font-size: 12px;">
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
    <br>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-adjuntos-tab" data-toggle="tab" href="#nav-adjuntos" role="tab" aria-controls="nav-adjuntos" aria-selected="true">Archivos adjuntos</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-adjuntos" role="tabpanel" aria-labelledby="nav-adjuntos-tab">

            <div class="form-group row">
                <div class="col-md-12 text-md-right">
                    <label for="attachment" class="col-form-label">
                            <a class="btn btn-outline-primary btn-sm " role="button" aria-disabled="false">+ Agregar</a>
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


                <table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
                    <thead>
                        <tr>
                            <th width="80px" style="text-align: center"># Tarea</th>
                            <th width="300px" style="text-align: center">Nombre de Archivo</th>
                            <th width="30px" style="text-align: center">Archivo</th>
                            <th width="120px" style="text-align: center">Fecha</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($tasks_users_rl as $fil_dt)
                        <tr>
                            <td>{{ $fil_dt->id_tasks }}</td>
                            <td>{{ $fil_dt->file }}</td>
                            <td>
                                <a href="{{ route('tasks.download', $fil_dt->file) }}">
                                    <i class="fa fa-download"></i> Descargar
                                </a>                            
                            </td>
                            <td> <?php echo date('d/m/Y', strtotime($fil_dt->created_at)); ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    <div class="form-group row was-validated mt-3">
        <div class="col-md-12 col-md-offset-4 text-md-left">
            <button type="submit" class="btn btn-primary btn-block" value="Crear">
                Actualizar
            </button>
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