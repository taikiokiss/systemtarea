<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
            <div class="form-group">
                <label for="name"></label>
                <input wire:model="name" type="text" class="form-control" id="name" placeholder="Nombre">@error('name') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="last_name"></label>
                <input wire:model="last_name" type="text" class="form-control" id="last_name" placeholder="Apellido">@error('last_name') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>            

            <div class="form-group">
                <label for="cedula"></label>
                <input wire:model="cedula" type="number" maxlength="10" wire:keydown="limitarCedula" class="form-control" id="cedula" placeholder="Cedula">@error('cedula') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>  

            <div class="form-group">
                <label for="email"></label>
                <input wire:model="email" type="text" class="form-control" id="email" placeholder="Email">@error('email') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="select-option">Seleccione el departamento:</label>
                <select class="form-control" id="department" wire:model="department">
                    <option value="">-- Seleccione --</option>
                    @foreach($departments as $option)
                        <option value="{{ $option->id }}">{{ $option->namedt }}</option>
                    @endforeach
                </select>
                @error('department') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="select-option">Seleccione el grupo:</label>
                <select class="form-control" id="grupo" wire:model="grupo">
                    <option value="">-- Seleccione --</option>
                    @foreach($groups as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                @error('grupo') <span style="font-size: 1rem; position: relative;" class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="select-option">Escoge el rol:</label>
                @foreach($roles as $optiona)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="rol_option" name="rol_option" id="rol_option{{$loop->iteration}}" value="{{$optiona->name}}">
                        <label class="form-check-label" for="rol_option{{$loop->iteration}}">
                            {{$optiona->name}}
                        </label>
                    </div>
                @endforeach
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
