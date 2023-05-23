@extends('layouts.app')
@section('title', __('Inicio'))
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5><span class="text-center fa fa-home"></span> @yield('title')</h5></div>
			<div class="card-body">
				<hr>


	
				<div class="row w-100">
					<div class="col-md-3">
						<div class="card border-danger mx-sm-1 p-3 ">
							<div class="card border-danger text-danger p-3 my-card" ><span class="text-center fa fa-hourglass" aria-hidden="true"></span></div>
							<a href="#" class="stretched-link"></a>
							<div class="text-danger text-center mt-3"><h4>Vencidas</h4></div>
							<div class="text-danger text-center mt-2"><h1>{{count($VENCIDA)}}</h1></div>

						</div>
					</div>

					<div class="col-md-3">
						<div class="card border-warning mx-sm-1 p-3">
							<div class="card border-warning text-warning p-3 my-card" ><span class="text-center fa fa-hourglass-half" aria-hidden="true"></span></div>
							<a href="#" class="stretched-link"></a>
							<div class="text-warning text-center mt-3"><h4>Pendientes</h4></div>
							<div class="text-warning text-center mt-2"><h1>{{count($APROBADA)}}</h1></div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card border-success mx-sm-1 p-3">
							<div class="card border-success text-success p-3 my-card"><span class="text-center fa fa-check-square" aria-hidden="true"></span></div>
							<a href="{{route('tasks.asignadas')}}" class="stretched-link"></a>
							<div class="text-success text-center mt-3"><h4>Resueltas</h4></div>
							<div class="text-success text-center mt-2"><h1>{{count($REALIZADA)}}</h1></div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card border-info mx-sm-1 p-3 ">
							<div class="card border-info text-info p-3" ><span class="text-center fa fa-cogs" aria-hidden="true"></span></div>
							<a href="{{route('tasks.index')}}" class="stretched-link"></a>
							<div class="text-info text-center mt-3"><h4>En proceso</h4></div>
							<div class="text-info text-center mt-2"><h1>{{count($EN_PROCESO)}}</h1></div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
</div>
@endsection