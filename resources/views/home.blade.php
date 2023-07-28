@extends('layouts.app')
@section('title', __('INICIO'))
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5><span class="text-center fa fa-home"></span> @yield('title')</h5></div>
			<div class="card-body">
				<hr>


                
					<div class="row w-100">


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <a href="{{route('tasks.principales.vencidas')}}" class="stretched-link"></a>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Tareas (Vencidas)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($estados_vencidos)}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <a href="{{route('tasks.principales.pendientes')}}" class="stretched-link"></a>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Tareas (Pendientes por aprobar)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($APROBADA)}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <a href="{{route('tasks.principales.resueltas')}}" class="stretched-link"></a>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tareas (Resueltas)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($REALIZADA)}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
										<a href="{{route('tasks.principales.asignadas')}}" class="stretched-link"></a>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tareas (En Proceso)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($EN_PROCESO)}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Content Column -->
                        <div class="col-lg-12 col-md-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">CALIFICACIÓN DE EFICIENCIA </h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold"><span class="float-right">{{$valor_dos_deci}}%</span></h4>
										@php
										    $textClass = '';
										    $barClass = '';

										    if ($valor_dos_deci > 70) {
										        $textClass = 'text-success';
										        $barClass = 'bg-success';
												$mensaje = "Felicidades, sigue asi!! "; 

										    } elseif ($valor_dos_deci < 50) {
										        $textClass = 'text-danger';
										        $barClass = 'bg-danger';
												$mensaje = "Debes mejorar!!"; 

										    } else {
										        $textClass = 'text-warning';
										        $barClass = 'bg-warning';
												$mensaje = "Se puede mejorar!!"; 
										    }
										@endphp


										<div class="text-xs font-weight-bold {{ $textClass }} text-uppercase mb-1">{{$mensaje}}</div>
										<div class="progress mb-4">
										    <div class="progress-bar {{ $barClass }}" role="progressbar" style="width: {{ $valor_dos_deci }}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										</div>

                                </div>
                            </div>
                        </div>



                    </div>			
			</div>
		</div>
	</div>
</div>


</div>
@endsection
