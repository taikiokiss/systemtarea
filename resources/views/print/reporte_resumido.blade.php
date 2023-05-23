<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>DETALLE DE CUMPLIMIENTO RESUMIDO</title>
        <link href="{!! asset('css/report.css') !!}" rel="stylesheet">
    </head>
    <body>

        @include('print.src.header')

        <div id="content">
            <table id="tabla" class="borde responsive" style="font-size:10px;">
                    <thead style="background-color: #dddddd;">
                        <tr>
                            <th width="50%" style="text-align: center">Usuario Solicitante</th>
                            <th width="15%" style="text-align: center">Tarea</th>
                            <th width="100%" style="text-align: left;">Asunto</th>
                            <th width="40%" style="text-align: center">Fecha de Entrega</th>
                            <th width="40%" style="text-align: center">Entrega Real</th>
                            <th width="30%" style="text-align: center">Estado</th>
                            <th width="15%" style="text-align: center">Vencida</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $previousName = ''; // Variable de control para almacenar el nombre anterior
                        @endphp

                        @foreach($tasks as $prodc)
                            @if($prodc->ApellidoAsig.' '.$prodc->NombreAsig !== $previousName)
                                <tr>
                                    <td colspan="7" style="text-align: left;font-size:12px;">
                                        <b>{{ $prodc->ApellidoAsig }} {{ $prodc->NombreAsig }}</b>
                                    </td>                          
                                </tr>
                            @endif
                            
                            <tr>
                                <td style="text-align: left;">{{ $prodc->ApellidoSoli }} {{ $prodc->NombreSoli }}</td>   
                                <td style="text-align: center;">{{ $prodc->id }}</td>
                                <td style="text-align: left;">{{ $prodc->asunto }}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($prodc->fecha_entrega)) }}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($prodc->created_at)) }}</td>
                                <td style="text-align: center;">{{ $prodc->estado }}</td>  
                                <td style="text-align: center;">{{ $prodc->id }}</td>                         
                            </tr>

                            @php
                                $previousName = $prodc->ApellidoAsig.' '.$prodc->NombreAsig; // Actualizamos el valor del nombre anterior
                            @endphp
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
