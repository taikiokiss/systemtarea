@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <div class="card card-body">
              <h4>Reporte de Tareas</h4>
              <div class="tab-content">
                <div class="container-fluid">
                  <div class="card-header border-0">
                    <div class="container">
                      {{ Form::open(['url' => url('tareas/reporte/resumido'),'method' => 'GET'])}}
                        <div class="row  mt-3">
                          <!--INICIO-->    
                          <div class="col-sm">


                            <label for="created_at" class="col-form-label text-md-right text-muted" style="font-size: 14px;">Inicio</label>
                              @if(request('created_at') == false)
                                <input style="font-size: 14px" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" value="<?php echo date('Y-m-d', strtotime('-2 months')) ?>" type="date" required/>
                              @else
                                <input style="font-size: 14px" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" value="{{ request('created_at') }}" type="date" required/>
                              @endif
                          </div>
                          <div class="col-sm">
                            <label for="updated_at" class="col-form-label text-md-right text-muted" style="font-size: 14px;">Fin</label>
                              @if(request('updated_at') == false)
                                <input style="font-size: 14px" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at" value="<?php echo date('Y-m-d') ?>" type="date" required/>
                              @else
                                <input style="font-size: 14px" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at"  value="{{ request('updated_at') }}" type="date" required/>
                              @endif
                          </div>

                          <div class="col-sm">
                            <label for="usuario" class="col-form-label text-md-right text-muted" style="font-size: 14px;">Usuario</label>
                                <select  class="form-control" id="usuario" name="usuario" 
                                    style="font-size: 14px;">
                                    <option value="" hidden>Todos</option>
                                        @foreach($user_act as $usuario)
                                          @if(request('usuario')==$usuario->userid)
                                            <option selected value="{{$usuario->userid}}">{{$usuario->name}} {{$usuario->last_name}}</option>
                                          @else
                                            <option value="{{$usuario->userid}}">{{$usuario->name}} {{$usuario->last_name}}</option>
                                          @endif
                                        @endforeach 
                                </select>
                          </div>

                          <div class="col-sm">
                            <label for="grupo" class="col-form-label text-md-right text-muted" style="font-size: 14px;">Grupo</label>
                                <select  class="form-control" id="grupo" name="grupo" 
                                    style="font-size: 14px;">
                                    <option value="" hidden>Todos</option>
                                        @foreach($grupos as $grupo)
                                          @if(request('grupo')==$grupo->id)
                                            <option selected value="{{$grupo->id}}">{{$grupo->name}}</option>
                                          @else
                                            <option value="{{$grupo->id}}">{{$grupo->name}}</option>
                                          @endif
                                        @endforeach 
                                </select>
                          </div>


                          <div class="row mt-3 col-sm-12"> 
                            <div class="col-sm" >
                              <div class="text-left">
                                <div class="btn-group">
                                      <a id="buscar" target="_blank" href="{{ route('print.reporte_resumido') }}" 
                                          class="btn btn-sm btn-outline-danger">
                                          <i class="far fa-file-pdf"></i>&nbsp;PDF
                                      </a>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm">
                              <div class="text-right">
                                <div class="btn-group">

                                  <button  type="submit" class="btn btn-outline-success">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                     Buscar
                                   </button>
                                  <a  href="{{url('/tareas/reporte/resumido')}}"
                                      class="btn btn-outline-secondary">
                                      Limpiar
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--FIN-->
                        </div>
                      {{ Form::close()}}
                    </div>
                  </div>
                  <div class="card-body">
                    @if (count($tasks)) 
                      <table id="tableuser" class="table table-bordered table-striped table-sm table-responsive" 
                              style="font-size:12px; color: black">
                          <thead>
                              <tr>
                                  <th width="10px" style="text-align: center">ID</th>
                                  <th width="500px" style="text-align: center">Asunto</th>
                                  <th width="120px" style="text-align: center">Fecha de Creación</th>
                                  <th width="120px" style="text-align: center">Fecha de Solicitud</th>
                                  <th width="500px" style="text-align: center">Departamento - Encargado</th>
                                  <th width="300px" style="text-align: center">Solicitante</th>
                                  <th width="250px" style="text-align: center">Estado</th>
                                  <th width="100px" style="text-align: center">Acciones</th>
                              </tr>
                          </thead>

                          <tbody style="text-align: center">
                              @foreach($tasks as $prodc)
                              <tr>
                                  <td>{{ $prodc->id }}</td>
                                  <td>{{ $prodc->asunto }}</td>
                                  <td> <?php echo date('d/m/Y', strtotime($prodc->created_at)); ?></td>
                                  <td> <?php echo date('d/m/Y', strtotime($prodc->fecha_entrega)); ?></td>
                                  <td>[{{ $prodc->namedt }}] - {{ $prodc->ApellidoAsig }} {{ $prodc->NombreAsig }}</td>
                                  <td>{{ $prodc->ApellidoSoli }} {{ $prodc->NombreSoli }}</td>   
                                  <td>{{ $prodc->estado }}</td>  
                                  <td width="200px">
                                    <div class="text-center">
                                      <div class="btn-group">
                                        <a  target="_blank" href="{{ route('print.reporte_detallado', $prodc->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-print"></i>  Detallado
                                        </a>
                                      </div>
                                    </div>
                                  </td>                        
                                </tr>
                              @endforeach
                          </tbody>
                      </table>

                    @else
                        <div class="text-center text-muted">No existen registros</div> 
                    @endif           
                  </div>
                </div>               
              </div>
            </div>
          </div>
        </div>
    </div>
</section>

<script type="text/javascript">
  $(document).ready(function () {

    var dats = '<?=count($tasks)?>';
    if (dats == 0) {
      $('#buscar').addClass('disabled');
    }else{}

  });

</script>
@endsection

