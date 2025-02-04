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
            <div class="form-group">
                <label for="name"></label>
                <input wire:model="name" type="text" class="form-control" id="name" placeholder="Nombre">@error('name') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="select-option">Jefe de Grupo:</label>
                <select class="form-control" id="jefe_grupo" wire:model="jefe_grupo">
                    <option value="">-- Seleccione --</option>
                    @foreach($users as $option)
                        <option value="{{ $option->id }}">{{ $option->cedula }} | {{ $option->last_name }} {{ $option->name }}</option>
                    @endforeach
                </select>
                @error('jefe_grupo') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="miembro_grupo"></label>
                <input wire:model="miembro_grupo" type="text" class="form-control" id="miembro_grupo" placeholder="Miembro Grupo">@error('miembro_grupo') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
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
