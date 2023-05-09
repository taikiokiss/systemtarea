@extends('admin.admin2')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Registro de antenas</h4>
                    <a href="{{ route('antenas.index') }}"
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
                {{ Form::open(['route' => 'antenas.store','enctype' =>'multipart/form-data', 'files'=>true]) }}
                    <form method="POST" action="{{ route('antenas.index') }}">
                    @csrf

                        <div class="form-group row">
                            <label for="antena" class="col-md-2 col-form-label text-md-left">{{ __('Antena') }}</label>

                            <div class="col-md-12">
                                <input id="antena" type="text" class="form-control @error('antena') is-invalid @enderror" name="antena" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('antena') }}"  autocomplete="antena" autofocus placeholder="Ingrese el nombre de la antena">
                                @error('antena')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" class="col-md-2 col-form-label text-md-left">{{ __('Marca') }}</label>

                            <div class="col-md-12">
                                <input id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('marca') }}"  autocomplete="marca" autofocus placeholder="Ingrese la marca">
                                @error('marca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-md-2 col-form-label text-md-left">{{ __('Modelo') }}</label>

                            <div class="col-md-12">
                                <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('modelo') }}"  autocomplete="modelo" autofocus placeholder="Ingrese el modelo">
                                @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-md-2 col-form-label text-md-left">{{ __('Codigo de serie') }}</label>

                            <div class="col-md-12">
                                <input id="codigoserie" type="text" class="form-control @error('codigoserie') is-invalid @enderror" name="codigoserie" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('codigoserie') }}"  autocomplete="codigoserie" autofocus placeholder="Ingrese el codigo de serie">
                                @error('codigoserie')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="p_radiacion" class="col-md-2 col-form-label text-md-left">{{ __('P radiación') }}</label>

                            <div class="col-md-12">
                                <input id="p_radiacion" type="text" class="form-control @error('p_radiacion') is-invalid @enderror" name="p_radiacion" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('p_radiacion') }}"  autocomplete="p_radiacion" autofocus placeholder="Ingrese el p_radiacion">
                                @error('p_radiacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="directividad" class="col-md-2 col-form-label text-md-left">{{ __('Directividad') }}</label>

                            <div class="col-md-12">
                                <input id="directividad" type="text" class="form-control @error('directividad') is-invalid @enderror" name="directividad" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('directividad') }}"  autocomplete="directividad" autofocus placeholder="Ingrese la directividad">
                                @error('directividad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ganancia" class="col-md-2 col-form-label text-md-left">{{ __('Ganancia') }}</label>

                            <div class="col-md-12">
                                <input id="ganancia" type="text" class="form-control @error('ganancia') is-invalid @enderror" name="ganancia" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('ganancia') }}"  autocomplete="ganancia" autofocus placeholder="Ingrese la ganancia">
                                @error('ganancia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="eficiencia" class="col-md-2 col-form-label text-md-left">{{ __('Eficiencia') }}</label>

                            <div class="col-md-12">
                                <input id="eficiencia" type="text" class="form-control @error('eficiencia') is-invalid @enderror" name="eficiencia" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('eficiencia') }}"  autocomplete="eficiencia" autofocus placeholder="Ingrese la eficiencia">
                                @error('eficiencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="frecuencia" class="col-md-2 col-form-label text-md-left">{{ __('Frecuencia') }}</label>

                            <div class="col-md-12">
                                <input id="frecuencia" type="text" class="form-control @error('frecuencia') is-invalid @enderror" name="frecuencia" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('frecuencia') }}"  autocomplete="frecuencia" autofocus placeholder="Ingrese la frecuencia">
                                @error('frecuencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="polarizacion" class="col-md-2 col-form-label text-md-left">{{ __('Polarizacion') }}</label>

                            <div class="col-md-12">
                                <input id="polarizacion" type="text" class="form-control @error('polarizacion') is-invalid @enderror" name="polarizacion" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('polarizacion') }}"  autocomplete="polarizacion" autofocus placeholder="Ingrese la polarizacion">
                                @error('polarizacion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="foto_antena" class="col-md-2  col-form-label text-md-left mt-2">{{ __('Imagen') }}</label>

                            <div class="col-md-12">
                                
                                <div class="input-group">
                                    <div class="custom-file mt-3">
                                        <input type="file" class="form-control mt-3 custom-file-input" id="foto_antena" accept="image/x-png,image/gif,image/jpeg" enctype="multipart/form-data" name="foto_antena">
                                        <label class="custom-file-label" for="foto_antena" data-browse="Examinar">Selecciona una imagen</label>
                                    </div>
                                </div>

                                @error('aerodromo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row ">
                            <div class="col-md-12">
                                <img id="imagenPrevisualizacion" class="responsiveimag_pr" width="600" height="400">
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

<script type="text/javascript">
    const $seleccionArchivos = document.querySelector("#foto_antena"),
      $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

    // Escuchar cuando cambie
    $seleccionArchivos.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivos.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacion.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacion.src = objectURL;
    });
</script>

@endsection


