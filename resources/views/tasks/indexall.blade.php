@extends('admin.admin2')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 style="display:inline;">Gestión de Antenas Inactivas</h4>
            <div class="btn-group float-right">
              <a  href="{{ route('antenas.index') }}"
                  class="btn btn-sm btn-success">
                  <i class="fas fa-eye"></i> Antenas Activas
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
              @if (count($antenas)) 
                <table id="tableuser" class="table table-bordered table-striped table-sm" style="font-size:14px">
                    <thead>
                        <tr>
                            <th width="10px" style="text-align: center">ID</th>
                            <th width="500px" style="text-align: center">Antena</th>
                            <th width="500px" style="text-align: center">Marca</th>
                            <th width="40px" style="text-align: center">Modelo</th>
                            <th width="300px" style="text-align: center">Codigo Serie</th>
                            <th width="200px" style="text-align: center">Imagen</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
                        @foreach($antenas as $prodc)
                        <tr>
                            <td>{{ $prodc->id }}</td>
                            <td>{{ $prodc->antena }}</td>
                            <td>{{ $prodc->marca }}</td>
                            <td>{{ $prodc->modelo }}</td>
                            <td>{{ $prodc->codigoserie }}</td>                                
                            <td><center> 
                              <a target="_blank" href="{{ asset('storage/'.$prodc->foto_antena) }}">  <img id="foto" name="foto"  class="col-sm-12" src="{{ asset('storage/'.$prodc->foto_antena) }}"style="width:100px;" /></a></center></td>
                            <td>{{$prodc->estado }}</td> 
                            <td width="5px">
                              <div class="text-center">
                                <div class="btn-group">
                                  <a href="{{ route('antenas.edit', $prodc->id) }}"
                                  class="btn btn-sm btn-primary">
                                      Editar
                                  </a>
                                  <a href="{{ route('antenas.activ', $prodc->id) }}"
                                      class="btn btn-sm btn-success">
                                      Habilitar
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
    text: "Una vez eliminado, deberas volver a reactivar este producto para volver a usarlo!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal(
        "Eliminado! El producto ha sido eliminado correctamente!", {
        icon: "success",
      });
      window.location.href = urlToRedirect;
          } else {
      swal("Cancelado! El producto no ha sido eliminado!", {
        icon: "warning",
      });
    }
  });
  }
</script>



@endsection

