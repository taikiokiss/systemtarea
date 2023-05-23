<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>REPORTE DE MANTENIMIENTO GENERAL</title>
        <link href="{!! asset('css/report.css') !!}" rel="stylesheet">
    </head>
    <body>


        @include('print.src.header')
        <br><br>
        <br><br>
        <br><br><br>

                    <div class="container"  style="text-align: center;">
                      <span style="font-size:18px; font-family: arial, sans-serif;"> 
                      <b> REPORTE DE LISTADO DE MANTENIMIENTO </b> </span>
                    </div>



        <div id="content">
            <!--CABECERA-->
            <br>
            <!--INSTRUMENTOS-->
            <br>
            <!--NOVEDADES-->
                <table id="tabla" class="borde responsive" style="font-size:12px;">
                  <thead style="background-color: #dddddd;">
                    <tr>
                      <th  colspan="6">INFORMACIÓN</th>
                    </tr>                
                    <tr>
                      <th class="borde" width="15%" >N°</th>
                      <th class="borde" width="40%">FECHA</th>
                      <th class="borde" width="100%">CLIENTE</th>
                      <th class="borde" width="20%">KM</th>
                      <th class="borde" width="40%">SUCURSAL</th>
                      <th class="borde" width="100%">RESPONSABLE</th>
                    </tr>
                  </thead>
                  <tbody style="font-size:11px;">
                    @foreach ($factura as $dat)
                      <tr>
                          <td class="borde">{{ $dat->MantCab_Id }}</td>
                          <td class="borde">{{ $dat->Fecha_Mant }}</td>
                          <td class="borde">{{ $dat->nombre_cliente }} {{ $dat->apellido_cliente }}</td>
                          <td class="borde">{{ $dat->Kilometraje }}</td>
                          <td class="borde">{{ $dat->Sucurs_Descrip }}</td>                 
                          <td class="borde">{{ $dat->nombre_empleado }} {{ $dat->apellido_empleado }}</td>
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
