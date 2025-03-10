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
                                <option hidden value="">Selecciona el departamento</option>
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
                        <input wire:model.defer="subtarea_descrip" type="text" class="form-control" id="subtarea_descrip" placeholder="Descripción de tarea">@error('subtarea_descrip') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input wire:model.defer="tiempo_demora" type="number" class="form-control" id="tiempo_demora" placeholder="Dias">@error('tiempo_demora') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
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

