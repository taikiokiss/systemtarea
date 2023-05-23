<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>REPORTE DE MANTENIMIENTO DETALLADO</title>
        <link href="{!! asset('css/report.css') !!}" rel="stylesheet">
    </head>
    <body>

        @include('print.src.header')
        <br><br>
        <br><br>
        <br><br><br>
                    <div class="container"  style="text-align: center;">
                      <span style="font-size:18px; font-family: arial, sans-serif;"> 
                      <b> REPORTE DETALLADO DE MANTENIMIENTO </b> </span>
                    </div>



        <span style="text-align:justify; text-justify: inter-word; font-family: arial, sans-serif;font-size:14px">Los datos del cliente se detallan a continuación y posteriormente su detalle del mantenimiento realizado.
        </span>

        <div id="content">
            <!--CABECERA-->
            <br>
            <!--INSTRUMENTOS-->
            <br>
            <!--NOVEDADES-->
                <table id="tabla" class="borde responsive" style="font-size:12px;">
                  <thead style="background-color: #dddddd;">
                    <tr>
                      <th  colspan="6">INFORMACIÓN CLIENTE MANTENIMIENTO</th>
                    </tr>                
                    <tr>
                      <th class="borde" width="25%" >N° </th>
                      <th class="borde" width="40%">FECHA</th>
                      <th class="borde" width="100%">CLIENTE</th>
                      <th class="borde" width="30%">KM</th>
                      <th class="borde" width="40%">SUCURSAL</th>
                      <th class="borde" width="100%">RESPONSABLE</th>

                    </tr>
                  </thead>
                  <tbody style="font-size:11px;">
                    @foreach ($mantenimiento_cabe as $dat)
                      <tr>
                        <td class="borde" >{{$dat->MantCab_Id}}</td>
                        <td class="borde" >{{$dat->Fecha_Mant}}</td>
                        <td class="borde" >{{$dat->nombre_cliente}} {{$dat->apellido_cliente}}</td>
                        <td class="borde" >{{$dat->Kilometraje}}</td>
                        <td class="borde" >{{$dat->Sucurs_Descrip}}</td>
                        <td class="borde" >{{$dat->nombre_empleado}} {{$dat->apellido_empleado}}</td>
                      </tr>

                    @endforeach
                  </tbody>
                </table>

            <br>
            <!--INSTRUMENTOS-->
            <br>
            <!--NOVEDADES-->
                <table id="tabla" class="borde responsive" style="font-size:12px;">
                  <thead style="background-color: #dddddd;">
                    <tr>
                      <th  colspan="5">DETALLE DEL MANTENIMIENTO</th>
                    </tr>                
                    <tr>
                      <th class="borde" width="25%" >N° </th>
                      <th class="borde" width="40%"># SERVICIO</th>
                      <th class="borde" width="100%">DESCRIPCIÓN</th>
                      <th class="borde" width="30%">TÉCNICO</th>
                      <th class="borde" width="40%">VALOR USD</th>

                    </tr>
                  </thead>
                  <tbody style="font-size:11px;">
                    @foreach ($mantenimiento_deta as $dat_deta)
                      <tr>
                        <td class="borde" >{{$dat_deta->MantDetId}}</td>
                        <td class="borde" >{{$dat_deta->Servicio_Id}}</td>
                        <td class="borde" >{{$dat_deta->Descripcion}}</td>
                        <td class="borde" >{{$dat_deta->nombre}} {{$dat_deta->apellido}}</td>
                        <td class="borde" >$ {{sprintf('%.2f', $dat_deta->Precio)}}</td>
                      </tr>

                    @endforeach
                  </tbody>
                </table>

        </div>
          <script type="text/php">
              if (isset($pdf)) {
                  $x = 480;
                  $y = 790;
                  $text = "PAGINA {PAGE_NUM} DE {PAGE_COUNT}";
                  $font = null;
                  $size = 10;
                  $color = array(0,0,0);
                  $word_space = 0.0;  //  default
                  $char_space = 0.0;  //  default
                  $angle = 0.0;   //  default
                  $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
              }
          </script>
        @include('print.src.footer')
    </body>
</html>
