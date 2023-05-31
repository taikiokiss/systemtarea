<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Create New Departments Descrip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>

                    <div class="form-group">
                        <label for="select-option">Seleccione el departamento:</label>
                        <select class="form-control" id="departments_id" wire:model="departments_id">
                            <option value="">-- Seleccione --</option>
                            @foreach($departamento as $option)
                                <option value="{{ $option->id }}">{{ $option->namedt }}</option>
                            @endforeach
                        </select>
                        @error('departments_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label for="subtarea_descrip"></label>
                        <input wire:model="subtarea_descrip" type="text" class="form-control" id="subtarea_descrip" placeholder="Descripción de tarea">@error('subtarea_descrip') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label for="select-option">Usuario encargado:</label>
                        <select class="form-control" id="usuario_asignado" wire:model="usuario_asignado">
                            <option value="">-- Seleccione --</option>
                            @foreach($users as $option)
                                <option value="{{ $option->id }}">{{ $option->cedula }} | {{ $option->last_name }} {{ $option->name }}</option>
                            @endforeach
                        </select>
                        @error('usuario_asignado') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label for="tiempo_demora"></label>
                        <input wire:model="tiempo_demora" type="text" class="form-control" id="tiempo_demora" placeholder="Tiempo Demora">@error('tiempo_demora') <span class="error text-danger">{{ $message }}</span> @enderror
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
