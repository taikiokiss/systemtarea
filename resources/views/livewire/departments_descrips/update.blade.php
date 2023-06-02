<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="departments_id"></label>
                        <input wire:model="departments_id" type="text" class="form-control" id="departments_id" readonly>@error('departments_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="subtarea_descrip"></label>
                        <input wire:model="subtarea_descrip" onkeyup="this.value = this.value.toUpperCase();" type="text" class="form-control" id="subtarea_descrip" placeholder="Descripcion">@error('subtarea_descrip') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="usuario_asignado"></label>
                        <input wire:model="usuario_asignado" type="text" class="form-control" id="usuario_asignado" readonly>@error('usuario_asignado') <span class="error text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class="form-group">
                        <label for="tiempo_demora">Tiempo en dias</label>
                        <input wire:model="tiempo_demora" type="number" class="form-control" id="tiempo_demora" placeholder="Tiempo Demora">@error('tiempo_demora') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
       </div>
    </div>
</div>
