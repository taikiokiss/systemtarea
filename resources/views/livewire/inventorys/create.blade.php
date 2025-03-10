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
                        <label class="col-form-label text-md-left">{{ __('Nombre de equipo') }}</label>
                            <select  wire:model.defer="name" id="name" class="form-control" name="name" >
                            </select>
                        </div>
                        <div class="col-md-12">
                        <label class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                            <select  wire:model.defer="type" id="type" class="form-control" name="type">
                                <option hidden value="">Tipo de equipo:</option>
                                @foreach ($types as $tipos_obj)
                                    <option value="{{ $tipos_obj->id }}">{{ $tipos_obj->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input wire:model.defer="serial" type="text" class="form-control" id="serial" placeholder="Serial del equipo">@error('serial') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input wire:model.defer="modelo" type="number" class="form-control" id="modelo" placeholder="Dias">@error('modelo') <span class="error text-danger" style="font-size: 1rem; position: relative;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                        <label class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                            <select  wire:model.defer="type" id="type" class="form-control" name="type">
                                <option hidden value="">Ubicacion de equipo:</option>
                                @foreach ($location as $ubicacion)
                                    <option value="{{ $ubicacion->id }}">{{ $ubicacion->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                        <label class="col-form-label text-md-left">{{ __('Descripcion del equipo') }}</label>
                            <select  wire:model.defer="description" id="description" class="form-control" name="description" >
                            </select>
                        </div>
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

