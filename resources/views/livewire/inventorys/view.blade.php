@section('title', __('Departments Descrips'))
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar">
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.inventorys.create')
						@include('livewire.inventorys.update')
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
							<thead class="thead">
								<tr>
									<td width="20px">#</td> 
									<th width="120px">Nombre</th>
									<th width="200px">Ubicacion</th>
									<th width="200px">Tipo</th>
									<th width="20px">Estado</th>
									<td width="100px"></td>
								</tr>
							</thead>
							<tbody>
								@foreach($inventorys as $row)
								<tr>
									<td>{{ $loop->iteration }}</td> 
									<td>{{ $row->nombre }}</td>
									<td>{{ $row->loca_name }}</td>
									<td>{{ $row->type_name }}</td>
									<td>{{ $row->estado }}</td>
									<td>

		                              <div class="text-center">
		                                <div class="btn-group">
											<a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-primary" wire:click="edit({{$row->idg}})" style="font-size:12px;">
												<i class="fa fa-edit"></i> 
												Editar 
											</a>
												@if($row->estado == 'INACTIVO')
													<a class="btn btn-sm btn-success" onclick="confirm('¿Esta de acuerdo en habilitar este registro con id {{$row->idg}}?')||event.stopImmediatePropagation()" wire:click="habilitar({{$row->idg}})" style="font-size:12px;">
														<i class="fa fa-toggle-on"></i> 
														Habilitar 
													</a>
												@else
													<a class="btn btn-sm btn-danger" onclick="confirm('¿Esta de acuerdo en eliminar este registro con id {{$row->idg}}?')||event.stopImmediatePropagation()" wire:click="destroy({{$row->idg}})" style="font-size:12px;">
														<i class="fa fa-toggle-off"></i> 
														Deshabilitar 
													</a>
												@endif
		                                </div>
		                              </div>
									</td>
								@endforeach
							</tbody>
						</table>						
						{{ $inventorys->links() }}
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
