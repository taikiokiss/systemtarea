<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>DETALLE DE CUMPLIMIENTO RESUMIDO</title>
        <link href="{!! asset('css/report.css') !!}" rel="stylesheet">
    </head>
    <body>

        @include('print.src.header')


        <div id="content">
            <table class="responsive" style="font-size:9px;">
                    <thead class="borde">
                        <tr>
                            <th width="100%" style="text-align: center">Usuario Solicitante</th>
                            <th width="10%" style="text-align: center">Tarea</th>
                            <th width="120%" style="text-align: center;">Asunto</th>
                            <th width="40%" style="text-align: center">Fecha Entrega</th>
                            <th width="40%" style="text-align: center">Entrega Real</th>
                            <th width="50%" style="text-align: center">Estado</th>
                            <th width="15%" style="text-align: center">Vencida</th>
                        </tr>
                    </thead>

                    <tbody >
                        @foreach($registrosAgrupados as $tasks)
                            <tr>
                                <td colspan="7" style="text-align: left;font-size:12px;"> 
                                  <b>{{ strtoupper($tasks['nombre_apellido']) }}</b>
                                </td>                          
                            </tr>
                            @foreach ($tasks['registros'] as $prodc)
                              <tr>
                                  <td style="text-align: left;">{{ strtoupper($prodc->ApellidoSoli) }} {{ strtoupper($prodc->NombreSoli) }}</td>   
                                  <td style="text-align: center;">{{ $prodc->id }}</td>
                                  <td style="text-align: left;">{{ $prodc->asunto }}</td>
                                  <td style="text-align: center;"> <?php echo date('d/m/Y', strtotime($prodc->fecha_entrega)); ?></td>
                                  <td style="text-align: center;"> <?php echo date('d/m/Y', strtotime($prodc->created_at)); ?></td>
                                  <td style="text-align: center;">{{ $prodc->estado }}</td>  
                                  <td style="text-align: center;">{{ $prodc->id }}</td>                         
                              </tr>
                            @endforeach
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
                  $size = 8;
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
