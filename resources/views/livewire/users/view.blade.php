@section('title', __('Users'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
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
				
						@include('livewire.users.create')
						@include('livewire.users.update')
				<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
						<thead class="thead">
							<tr>
								<td width="20px">#</td> 
								<th width="350px">Nombre</th>
								<th width="550px">Email</th>
								<th width="200px">Departamento</th>
								<td width="200px"></td>

							</tr>
						</thead>
						<tbody>
							@foreach($users as $row)
							<tr>
								<td>{{ $row->userid }}</td> 
								<td>{{ $row->name }} {{ $row->last_name }}</td>
								<td>{{ $row->email }}</td>
								<td>{{ $row->namedt }} </td>
									<td>
										<div class="text-center">
		                				<div class="btn-group">
												<a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-primary" wire:click="edit({{$row->userid}})" style="font-size:12px;">
													<i class="fa fa-edit"></i> 
													Editar 
												</a>
												@if($row->UserEstado == 'INACTIVO')
													<a class="btn btn-sm btn-success" onclick="confirm('¿Esta de acuerdo en habilitar este registro con id {{$row->userid}}?')||event.stopImmediatePropagation()" wire:click="habilitar({{$row->userid}})" style="font-size:12px;">
														<i class="fa fa-toggle-on"></i> 
														Habilitar 
													</a>
												@else
													<a class="btn btn-sm btn-danger" onclick="confirm('¿Esta de acuerdo en eliminar este registro con id {{$row->userid}}?')||event.stopImmediatePropagation()" wire:click="destroy({{$row->userid}})" style="font-size:12px;">
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
					{{ $users->links() }}

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
