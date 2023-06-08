<div id="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12"  style="margin-left: 50px;margin-right: 50px;">
          <table class="responsive" style="font-size:11px; ">
            <tr>
              <th colspan="4" style="font-size:16px; font-family: serif;"><em>DETALLE DE MOVIMIENTO DE TAREA</em></th>
            </tr>
            <tr>
              <td style="width:30%;text-align: left";><b>Usuario:</b></td>
              <td colspan="3" style="width:70%"> {{ strtoupper($tasks[0]->NombreAsig) }} {{ strtoupper($tasks[0]->ApellidoAsig) }}</td>
            </tr>
            <tr>
              <td style="width:30%;text-align: left";><b># Tarea:</b></td>
              <td colspan="3" style="width:70%">{{$id}}</td>
            </tr>
          </table>
      </div>
    </div>
  </div>
</div>


