@extends('layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Gestión de Tareas</h4>
            <div class="btn-group float-right">
              <a  href="{{ route('tasks.create') }}"
                  class="btn btn-sm btn-primary">
                  <i class="fas fa-plus"></i> Agregar
              </a>
            </div>
          </div>
        </div>
    </div>
</section>


<!-- TABLA DE CONTENIDO -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">        
              @if (count($tasks)) 
                <table id="tableuser" class="table table-bordered table-striped table-sm" style="font-size:12px">
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
                            <td>{{ $prodc->namedt }} - {{ $prodc->ApellidoAsig }} {{ $prodc->NombreAsig }}</td>
                            <td>{{ $prodc->ApellidoSoli }} {{ $prodc->NombreSoli }}</td>   
                            <td>{{ $prodc->estado }}</td>  
                            <td>
                              @if($prodc->usuario_solicitante == Auth::user()->id)
                              <div class="text-center">
                                <div class="btn-group">
                                  <a  href="#" 
                                      class="btn btn-sm btn-secondary">
                                      Cerrar
                                  </a>
                                  <a  href="#" 
                                      class="btn btn-sm btn-primary">
                                      Modificar
                                  </a>
                                  <a  href="#" 
                                      class="btn btn-sm btn-danger">
                                      Anular
                                  </a>
                                </div>
                              </div>
                              @else
                                @if ($prodc->estado == 'EN PROCESO' && $prodc->accion == 'APROBAR')
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                      class="btn-sm btn btn-outline-primary">
                                        {{ $prodc->accion }}
                                    </a>
                                @elseif($prodc->estado == 'VENCIDA' && $prodc->accion == 'APROBAR')
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                      class="btn-sm btn btn-outline-primary">
                                        {{ $prodc->accion }}
                                    </a>
                                @elseif($prodc->estado == 'VENCIDA')
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                      class="btn-sm btn btn-outline-primary">
                                        {{ $prodc->accion }}
                                    </a>
                                @elseif($prodc->estado == 'REALIZADA')
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                      class="btn-sm btn btn-outline-primary">
                                        {{ $prodc->accion }}
                                    </a>
                                @elseif($prodc->estado == 'ENTREGADA')
                                    <a href="{{ route('tasks.edit', $prodc->id) }}"
                                      class="btn-sm btn btn-outline-primary">
                                        {{ $prodc->accion }}
                                    </a>
                                @endif
                              @endif
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
<script type="text/javascript">
function confirmation(ev) {
  ev.preventDefault();
  var urlToRedirect = ev.currentTarget.getAttribute('href'); 
  console.log(urlToRedirect); 
  swal({
    title: "¿Estás seguro?",
    text: "Desactivar este registro.",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal(
        "Registro Desactivado Correctamente!", {
        icon: "success",
      });
      window.location.href = urlToRedirect;
          } else {
      swal("Cancelando Acción", {
        icon: "warning",
      });
    }
  });
  }
</script>


@endsection

