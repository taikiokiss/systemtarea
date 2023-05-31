@section('title', __('Departments Descrips'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Departments Descrip Listado </h4>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Departments Descrips">
						</div>
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Agregar Departments Descrips
						</div>
					</div>
				</div>
				
				<div class="card-body">
						@include('livewire.departments_descrips.create')
						@include('livewire.departments_descrips.update')
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr> 
								<td>#</td> 
								<th>Departments Id</th>
								<th>Subtarea Descrip</th>
								<th>Usuario Asignado</th>
								<th>Tiempo Demora</th>
								<th>Estado</th>

								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
							@foreach($Departments_descrips as $row)
							<tr>
								<td>{{ $loop->iteration }}</td> 
								<td>{{ $row->departments_id }}</td>
								<td>{{ $row->subtarea_descrip }}</td>
								<td>{{ $row->usuario_asignado }}</td>
								<td>{{ $row->tiempo_demora }}</td>
								<td>{{ $row->estado }}</td>
								<td width="90">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acciones
									</button>
									<div class="dropdown-menu dropdown-menu-right">
									<a data-toggle="modal" data-target="#updateModal" class="dropdown-item" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> Editar </a>							 
									<a class="dropdown-item" onclick="confirm('Confirm Delete Departments Descrip id {{$row->id}}? \nDeleted Departments Descrips cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i> Eliminar </a>   
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
