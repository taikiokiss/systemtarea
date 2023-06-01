@section('title', __('Groups'))
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
				
				<div class="card-body">
						@include('livewire.groups.create')
						@include('livewire.groups.update')
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
						<thead class="thead">
							<tr> 
								<td width="20px">#</td> 
								<th width="550px">Nombre</th>
								<th width="550px">Jefe de Grupo</th>
								<td width="200px"></td>
							</tr>
						</thead>
						<tbody>
							@foreach($groups as $row)
							<tr>
								<td>{{ $loop->iteration }}</td> 
								<td>{{ $row->nombregrupo }}</td>
								<td>{{ $row->last_name }} {{ $row->name }}</td>
									<td>
		                              <div class="text-center">
		                                <div class="btn-group">
											<a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-primary" wire:click="edit({{$row->id}})" style="font-size:12px;">
												<i class="fa fa-edit"></i> 
												Editar 
											</a>
											<a class="btn btn-sm btn-danger" onclick="confirm('¿Esta de acuerdo en eliminar este registro con id {{$row->id}}?')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})" style="font-size:12px;">
												<i class="fa fa-trash"></i> 
												Eliminar 
											</a>
		                                </div>
		                              </div>
									</td>
							@endforeach
						</tbody>
					</table>						
					{{ $groups->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
