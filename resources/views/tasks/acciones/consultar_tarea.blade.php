@extends('layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Consultar Tarea</h4>
            <div class="btn-group float-right">
              <a  href="{{ URL::previous() }}"
                  class="btn btn-sm btn-danger">
                  <i class="fas fa-arrow-left"></i> Atras
              </a>
            </div>
          </div>
        </div>
    </div>
</section>


<div class="container-fluid" style="font-size: 12px;">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body ">
                <!-- inicio -->
                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="departamento" class="col-form-label text-md-left">{{ __('Departamento') }}</label>
                                <select disabled="disabled" id="departamento" class="form-control" name="departamento">
                                    <option selected disabled value="{{$tasks1[0]->depaid}}">{{$tasks1[0]->namedt}}</option>
                                </select>
                            </div>


                            <div class="col-md-12">
                                <label for="asign_a" class="col-form-label text-md-left">{{ __('Asignar a') }}</label>
                                <select disabled="disabled" id="asign_a" class="form-control" name="asign_a" disabled>
                                    <option selected disabled value="{{$tasks1[0]->IdAsig}}">{{$tasks1[0]->ApellidoAsig}} {{$tasks1[0]->NombreAsig}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                            <label for="asunto" class="col-form-label text-md-left">{{ __('Asunto') }}</label>
                                <input disabled="disabled" id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror" name="asunto" onkeyup="this.value = this.value.toUpperCase();" value="{{ $tasks1[0]->asunto }}"  autocomplete="asunto" autofocus >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                            <label for="descripcion" class="col-form-label text-md-left">{{ __('Detalle') }}</label>
                                <textarea disabled="disabled" id="descripcion" class="form-control" name="descripcion" onkeyup="this.value = this.value.toUpperCase();" rows="5">{{ $tasks1[0]->descripcion }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                            <label for="observacion" class="col-form-label text-md-left">{{ __('Observación') }}</label>
                                <textarea id="observacion" disabled="disabled" class="form-control" name="observacion" onkeyup="this.value = this.value.toUpperCase();" rows="5"></textarea>
                            </div>
                        </div>

              </div>
            </div>
        </div>
    </div>

    @if($tasks1[0]->estado == 'REALIZADA' && $tasks1[0]->accion == 'CONSULTAR'  )
        @if($tasks1[0]->calificacion != 0)
        <div class="mx-0 mx-sm-auto">
          <div class="card">
            <div class="card-body text-center">
                <p class="text-center"><strong>VALORACIÓN DEL SERVICIO</strong></p>
                    <div class="form-group" id="rating-ability-wrapper">
                        <label class="control-label" for="rating">
                        <input type="hidden" id="calificacion" name="calificacion" value="0" required="required">
                        </label>
                        <h2 class="bold rating-header" style="font-size: 20px">
                        <span class="selected-rating">{{$tasks1[0]->calificacion}}</span><small> / 5</small>
                        </h2>
                            @for ($i = 1; $i <= $tasks1[0]->calificacion; $i++)
                                <button type="button" class="btnrating btn btn-sm btn-warning" data-attr="{{$tasks1[0]->calificacion}}" id="rating-star-{{$tasks1[0]->calificacion}}">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </button>
                            @endfor
                            <?php $nuevo = 5 - $tasks1[0]->calificacion; ?>
                            @for ($i = 1; $i <= $nuevo; $i++)
                                <button type="button" class="btnrating btn btn-default btn-sm" data-attr="{{$nuevo}}" id="rating-star-{{$nuevo}}">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </button>
                            @endfor
                    </div>
            </div>
          </div>
        </div>
        @endif
    @endif

    <br>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link" id="nav-adjuntos-tab" data-toggle="tab" href="#nav-adjuntos" role="tab" aria-controls="nav-adjuntos" aria-selected="true">Archivos adjuntos</a>
        <a class="nav-item nav-link active" id="nav-historico-tab" data-toggle="tab" href="#nav-historico" role="tab" aria-controls="nav-adjuntos" aria-selected="true">Historico</a>

      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade" id="nav-adjuntos" role="tabpanel" aria-labelledby="nav-adjuntos-tab">


                <table class="table table-bordered table-striped table-sm table-responsive" style="font-size:12px;color: black;">
                    <thead>
                        <tr>
                            <th width="80px" style="text-align: center"># Tarea</th>
                            <th width="700px" style="text-align: center">Nombre de Archivo</th>
                            <th width="160px" style="text-align: center">Archivo</th>
                            <th width="220px" style="text-align: center">Fecha</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($tasks_users_rl as $fil_dt)
                        <tr>
                            <td>{{ $fil_dt->id_tasks }}</td>
                            <td>{{ $fil_dt->file }}</td>
                            <td>
                                <a href="{{ route('tasks.download', $fil_dt->file) }}">
                                    <i class="fa fa-download"></i> Descargar
                                </a>                            
                            </td>
                            <td> <?php echo date('d/m/Y', strtotime($fil_dt->created_at)); ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        <div class="tab-pane fade show active" id="nav-historico" role="tabpanel" aria-labelledby="nav-historico-tab">
            <br>
                <table class="table table-bordered table-striped table-sm table-responsive" style="font-size:12px;color: black;">
                    <thead>
                        <tr>
                            <th width="80px" style="text-align: center">#</th>
                            <th width="80px" style="text-align: center"># Tarea</th>
                            <th width="300px" style="text-align: center">Usuario</th>
                            <th width="420px" style="text-align: center">Observación</th>
                            <th width="120px" style="text-align: center">Fecha</th>
                            <th width="250px" style="text-align: center">Estado</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @php $i=1; @endphp
                        @foreach($historico_mov_tarea as $hsmovtar)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $hsmovtar->id_tarea }}</td>
                            <td>{{ $hsmovtar->cedula }}; {{ $hsmovtar->name }} {{ $hsmovtar->last_name }}</td>   
                            <td>{{ $hsmovtar->observacion }}</td>
                            <td> <?php echo date('d/m/Y h:i:s A', strtotime($hsmovtar->created_at)); ?></td>
                            <td>{{ $hsmovtar->estado_id_tarea }}</td>  
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

    </div>


</div>                        
@endsection