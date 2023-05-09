@extends('layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Gestión de Tareas</h4>
            <div class="btn-group float-right">
              <a  href="{{ route('tasks.indexall') }}"
                  class="btn btn-sm btn-success">
                  <i class="fas fa-eye"></i> Tareas Inactivas
              </a> 
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
                <table id="tableuser" class="table table-bordered table-striped table-sm" style="font-size:14px">
                    <thead>
                        <tr>
                            <th width="10px" style="text-align: center">ID</th>
                            <th width="500px" style="text-align: center">Asunto</th>
                            <th width="300px" style="text-align: center">Usuario Solicitante</th>
                            <th width="40px" style="text-align: center">Departamento</th>
                            <th width="500px" style="text-align: center">Fecha de Solucitud</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($tasks as $prodc)
                        <tr>
                            <td>{{ $prodc->id }}</td>
                            <td>{{ $prodc->antena }}</td>
                            <td>{{ $prodc->marca }}</td>
                            <td>{{ $prodc->modelo }}</td>
                            <td>{{ $prodc->codigoserie }}</td>   
                            <td>{{$prodc->estado }}</td> 
                            <td width="5px">
                              <div class="text-center">
                                <div class="btn-group">
                                  <a href="{{ route('tasks.edit', $prodc->id) }}"
                                  class="btn btn-sm btn-primary">
                                      Editar
                                  </a>
                                  <a onclick="confirmation(event)" href="{{ route('tasks.desactiv', $prodc->id) }}"
                                        class="btn btn-sm btn-danger">
                                      Deshabilitar
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

