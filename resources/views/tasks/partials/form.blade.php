<div class="form-group">


	{{ Form::label('name', 'Antena', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('antena', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'antena']) }}

	{{ Form::label('marca', 'Marca', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('marca', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'marca']) }}

	{{ Form::label('modelo', 'Modelo', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('modelo', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'modelo']) }}

	{{ Form::label('codigoserie', 'Codigo de serie', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('codigoserie', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'codigoserie']) }}    

	{{ Form::label('p_radiacion', 'P radiación', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('p_radiacion', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'p_radiacion']) }}

	{{ Form::label('directividad', 'Directividad', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('directividad', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'directividad']) }}

	{{ Form::label('ganancia', 'Ganancia', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('ganancia', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'ganancia']) }}

	{{ Form::label('eficiencia', 'Eficiencia', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('eficiencia', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'eficiencia']) }}    

	{{ Form::label('frecuencia', 'Frecuencia', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('frecuencia', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'frecuencia']) }}

	{{ Form::label('polarizacion', 'Polarización', ['class' => 'col-form-label text-md-right mt-3']) }}
    {{ Form::text('polarizacion', null, ['class' => 'form-control col-sm-12 mt-3', 'id' => 'polarizacion']) }}

	<br>

		{{ Form::label('foto_antena', 'Foto') }}

		<div class="row">
            <div class="input-group">
                <div class="custom-file mt-3">
                    <input type="file" class="form-control mt-3 custom-file-input" id="foto_antena" accept="image/x-png,image/gif,image/jpeg" enctype="multipart/form-data" name="foto_antena">
                    <label class="custom-file-label" for="foto_antena" data-browse="Examinar">Selecciona una imagen</label>
                </div>
            </div>


		 	<br><br>
		 	<div class="col-md-12 text-center">
			 	<a target="_blank" href="{{ asset('storage/'.$antenas->foto_antena) }}">  
			 		<img id="foto_antena_s" name="foto_antena_s" class="col-sm-12 group list-group-image" src="{{ asset('storage/'.$antenas->foto_antena) }}" style="width:20%;" />
			 	</a>
			</div>

                        <div class="form-group row ">
                            <div class="col-md-12">
                                <img id="imagenPrevisualizacion" class="responsiveimag_pr" width="600" height="400">
                            </div>
                        </div>

			
		</div>
<br>
<div class="form-group">
	{{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-outline-primary']) }}
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