<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">

            <div class="form-group">
                <label for="name"></label>
                <input wire:model="name" type="text" class="form-control" id="name" placeholder="Nombre">@error('name') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="last_name"></label>
                <input wire:model="last_name" type="text" class="form-control" id="last_name" placeholder="Apellido">@error('last_name') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="cedula"></label>
                <input wire:model="cedula" type="text" class="form-control" id="cedula" placeholder="Cedula">@error('cedula') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email"></label>
                <input wire:model="email" type="text" class="form-control" id="email" placeholder="Email">@error('email') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="select-option">Escoge el rol:</label>
                @foreach($roles as $optiona)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="rol_option" name="rol_option" id="rol_option{{$loop->iteration}}" value="{{$optiona->name}}" {{ $optiona->name == $rol_option ? 'checked' : '' }}>
                        <label class="form-check-label" for="rol_option{{$loop->iteration}}">
                            {{$optiona->name}}
                        </label>
                    </div>
                @endforeach
            </div>



                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
