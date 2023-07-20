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
                      {{ Form::open(['url' => url('tareas/reporte/grafica'),'method' => 'GET'])}}

                        <div class="row  mt-3">
                          <!--INICIO-->    
                          <div class="col-sm">


                            <label class="col-form-label text-md-right text-muted" style="font-size: 14px;">Inicio</label>
                              @if(request('created_at') == false)
                                <input style="font-size: 14px" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" value="<?php echo date('Y-m-d', strtotime('-2 months')) ?>" type="date" required/>
                              @else
                                <input style="font-size: 14px" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" value="{{ request('created_at') }}" type="date" required/>
                              @endif
                          </div>
                          <div class="col-sm">
                            <label class="col-form-label text-md-right text-muted" style="font-size: 14px;">Fin</label>
                              @if(request('updated_at') == false)
                                <input style="font-size: 14px" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at" value="<?php echo date('Y-m-d') ?>" type="date" required/>
                              @else
                                <input style="font-size: 14px" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at"  value="{{ request('updated_at') }}" type="date" required/>
                              @endif
                          </div>


                          <div class="row mt-3 col-sm-12"> 
                            <div class="col-sm">
                              <div class="text-right">
                                <div class="btn-group">

                                  <button  type="submit" class="btn btn-outline-success">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                     Buscar
                                   </button>
                                  <a  href="{{url('/tareas/reporte/grafica')}}"
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


                  <div class="card-body">
                        <div class="col-lg-12 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">GRAFICA</h6>
                                </div>
                                <div class="card-body table-responsive">
                                        <div id="output"  style="margin: 30px;"></div>
                                </div>
                            </div>
                        </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>



<script type="text/javascript">

    $(document).ready(function() {
        var derivers = $.pivotUtilities.derivers;
        var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers);

        // Obtener la fecha de inicio y fecha de fin seleccionadas por el usuario
        var fechaInicio = obtenerFechaInicio(); 
        var fechaFin = obtenerFechaFin();

        $.getJSON("/mps-data", function(mps) {
            // Filtrar los registros según la fecha de inicio y fecha de fin
            var mpsFiltered = mps.filter(function(record) {
                var fecha =record.Fecha; 
            console.log(fecha);
                return fecha >= fechaInicio && fecha <= fechaFin;
            });
            $("#output").pivotUI(mpsFiltered, {
                renderers: renderers,
                cols: ["Departamento"],
                rows: ["Estado"],
                rendererName: "Bar Chart",
                rowOrder: "value_a_to_z",
                colOrder: "value_z_to_a"
            });
        });
    });

    function obtenerFechaInicio() {
        return $("#created_at").val();
    }

    function obtenerFechaFin() {
        return $("#updated_at").val();
    }
</script>

@endsection

