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


<div>
    <label for="color">Seleccione un color:</label>
    <select id="color" name="color">
        <option value="">Seleccione un color</option>
        @foreach ($datos['colores'] as $color)
            <option value="{{ $color }}">{{ $color }}</option>
        @endforeach
    </select>
</div>

<div>
    <label for="opcion">Seleccione una opción:</label>
    <select id="opcion" name="opcion" disabled>
        <option value="">Seleccione una opción</option>
    </select>
</div>

                            <div class="col-md-6">
                            <label for="asunto" class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                                <input id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror" name="asunto" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('asunto') }}"  autocomplete="asunto" autofocus >
                                @error('asunto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-6">
                            <label for="fecha_entrega" class="col-form-label text-md-left">{{ __('Asignar a') }}</label>
                                <input id="fecha_entrega" type="date" class="form-control @error('fecha_entrega') is-invalid @enderror" name="fecha_entrega" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('fecha_entrega') }}"  autocomplete="fecha_entrega" autofocus >
                                @error('fecha_entrega')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                                <div class="container ">
                                        <div id="uploader"></div>
                                </div>

                            </div>

                        </div>


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
        $('#opcion').prop('disabled', true);

        // Cuando se seleccione un valor en el primer select, se activará el segundo select y se llenará con los valores correspondientes
        $('#color').change(function() {
            var color = $(this).val();
            if (color !== '') {
                $('#opcion').prop('disabled', false);
                $('#opcion').html('<option value="">Cargando...</option>');
                var opciones = @json($datos['opciones']);
                var opcionesColor = opciones[color];
                var options = '<option value="">Seleccione una opción</option>';
                for (var i = 0; i < opcionesColor.length; i++) {
                    options += '<option value="' + opcionesColor[i] + '">' + opcionesColor[i] + '</option>';
                }
                $('#opcion').html(options);
            } else {
                $('#opcion').prop('disabled', true);
                $('#opcion').html('<option value="">Seleccione una opción</option>');
            }
        });
    });
</script>

@endsection


