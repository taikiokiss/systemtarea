<!-- Modal -->
<div id="main">
    <div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDataModalLabel">Crear Nuevo Departamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
               <div class="modal-body">
    				<form>
                        <div class="form-group">
                            <input wire:model="namedt" type="text" class="form-control" id="namedt" placeholder="Nombre">@error('namedt') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Crear</button>
                </div>
            </div>
        </div>
    </div>

</div>
