@section('title', __('Departments'))
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Departamento (Listado)</h4>
            <div class="btn-group float-right">
				<div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createDataModal">
					<i class="fa fa-plus"></i>  Agregar
				</div>
            </div>
          </div>
        </div>
    </div>
</section>

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
						@include('livewire.departments.create')
						@include('livewire.departments.update')
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm" style="font-size:12px; color: black">
						<thead class="thead">
							<tr> 
								<td>#</td> 
								<th>Nombre</th>
								<th>Estado</th>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
							@foreach($departments as $row)
							<tr>
								<td>{{ $loop->iteration }}</td> 
								<td>{{ $row->namedt }}</td>
								<td>{{ $row->estado }}</td>
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
					{{ $departments->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
