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
                <label for="departments_id"></label>
                <input wire:model="departments_id" type="text" class="form-control" id="departments_id" placeholder="Departments Id">@error('departments_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="subtarea_descrip"></label>
                <input wire:model="subtarea_descrip" type="text" class="form-control" id="subtarea_descrip" placeholder="Subtarea Descrip">@error('subtarea_descrip') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="usuario_asignado"></label>
                <input wire:model="usuario_asignado" type="text" class="form-control" id="usuario_asignado" placeholder="Usuario Asignado">@error('usuario_asignado') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tiempo_demora"></label>
                <input wire:model="tiempo_demora" type="text" class="form-control" id="tiempo_demora" placeholder="Tiempo Demora">@error('tiempo_demora') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="estado"></label>
                <input wire:model="estado" type="text" class="form-control" id="estado" placeholder="Estado">@error('estado') <span class="error text-danger">{{ $message }}</span> @enderror
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
