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
                <label for="name"></label>
                <input wire:model="name" type="text" class="form-control" id="name" placeholder="Name">@error('name') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="jefe_grupo"></label>
                <input wire:model="jefe_grupo" type="text" class="form-control" id="jefe_grupo" placeholder="Jefe Grupo">@error('jefe_grupo') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="miembro_grupo"></label>
                <input wire:model="miembro_grupo" type="text" class="form-control" id="miembro_grupo" placeholder="Miembro Grupo">@error('miembro_grupo') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
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
