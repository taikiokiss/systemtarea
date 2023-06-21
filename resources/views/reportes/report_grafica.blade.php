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
                <div class="container-fluid">


                  <div class="card-body">
                    @if (count($tasks))
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
    // This example adds Plotly chart renderers.

    $(document).ready(function() {
        var derivers = $.pivotUtilities.derivers;
        var renderers = $.extend($.pivotUtilities.renderers,
            $.pivotUtilities.plotly_renderers);

        $.getJSON("/mps-data", function(mps) {
            $("#output").pivotUI(mps, {
                renderers: renderers,
                cols: ["Departamento"],
                rows: ["Descripcion"],
                rendererName: "Bar Chart",
                rowOrder: "value_a_to_z",
                colOrder: "value_z_to_a"
            });
        });
    });

</script>
@endsection

