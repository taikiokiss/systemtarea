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
						@include('livewire.departments_descrips.create')
						@include('livewire.departments_descrips.update')
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
							<thead class="thead">
								<tr>
									<td width="20px">#</td> 
									<th width="120px">Departamento</th>
									<th width="200px">Descripcion de tarea</th>
									<th width="200px">Usuario Asignado</th>
									<th width="20px">Tiempo</th>
									<th width="20px">Estado</th>
									<td width="100px"></td>
								</tr>
							</thead>
							<tbody>
								@foreach($Departments_descrips as $row)
								<tr>
									<td>{{ $loop->iteration }}</td> 
									<td>{{ $row->nombredepartamento }}</td>
									<td>{{ $row->subtarea_descrip }}</td>
									<td>{{ $row->last_name }} {{ $row->name }}</td>
									<td>{{ $row->tiempo_demora }} DIAS</td>
									<td>{{ $row->estado }}</td>
									<td>

		                              <div class="text-center">
		                                <div class="btn-group">
											<a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-primary" wire:click="edit({{$row->id}})" style="font-size:12px;">
												<i class="fa fa-edit"></i> 
												Editar 
											</a>
											<a class="btn btn-sm btn-danger" onclick="confirm('¿Esta de acuerdo en eliminar este registro {{$row->id}}?')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})" style="font-size:12px;">
												<i class="fa fa-trash"></i> 
												Eliminar 
											</a>
		                                </div>
		                              </div>
									</td>
								@endforeach
							</tbody>
						</table>						
						{{ $Departments_descrips->links() }}
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
