<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>DETALLADO DE TAREA ESPECIFICA</title>
        <link href="{!! asset('css/report.css') !!}" rel="stylesheet">
    </head>
    <body>

        @include('print.src.header_detallado')


        <div id="content">
            <table class="responsive" style="font-size:9px;">
                    <thead class="borde">
                        <tr>
                            <th width="10%" style="text-align: center">#</th>
                            <th width="20%" style="text-align: center"># Tarea</th>
                            <th width="70%" style="text-align: center">Usuario</th>
                            <th width="140%" style="text-align: center">Observación</th>
                            <th width="50%" style="text-align: center">Fecha</th>
                            <th width="30%" style="text-align: center">Estado</th>
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
