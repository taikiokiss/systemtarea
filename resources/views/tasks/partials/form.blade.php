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
              </div>
            </div>
        </div>
    </div>
</div>



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