<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <label class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                            <select  wire:model.defer="departments_id" id="departments_id" class="form-control" name="departments_id">
                                
                                @foreach ($datos['departma'] as $departm)
                                    <option value="{{ $departm->id }}">{{ $departm->namedt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                        <label class="col-form-label text-md-left">{{ __('Usuario encargado') }}</label>
                            <select  wire:model.defer="usuario_asignado" id="usuario_asignado" class="form-control" name="usuario_asignado" >
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input wire:model.defer="subtarea_descrip" type="text" class="form-control" id="subtarea_descrip" placeholder="Descripción de tarea">@error('subtarea_descrip') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input wire:model.defer="tiempo_demora" type="number" class="form-control" id="tiempo_demora" placeholder="Dias">@error('tiempo_demora') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Al cargar la página, el segundo select estará desactivado
        $('#usuario_asignado').prop('disabled', true);

        // Cuando se seleccione un valor en el primer select, se activará el segundo select y se llenará con los valores correspondientes
        $('#departments_id').change(function() {
            var departamento = $(this).val();
            if (departamento !== '') {
                $('#usuario_asignado').prop('disabled', false);
                $('#usuario_asignado').html('<option value="">Cargando...</option>');
                var opciones = @json($datos['opciones']);
                var options = '<option value="">Seleccione una opción</option>';
                opciones.forEach(function(opcion) {
                    if (opcion.idpersondepar == departamento) { // <--- aquí se hace la comparación por id de departamento
                        options += '<option value="' + opcion.idperson + '">' + opcion.last_name +' '+ opcion.name +  '</option>'; // <--- se utiliza id y nombre del usuario
                    }
                });
                $('#usuario_asignado').html(options);
            } else {
                $('#usuario_asignado').prop('disabled', true);
                $('#usuario_asignado').html('<option value="">Seleccione una opción</option>');
            }
        });

    });
</script>