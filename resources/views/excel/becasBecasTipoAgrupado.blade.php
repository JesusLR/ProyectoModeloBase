<table class="table" border="0">
  <thead>
      {{--  <tr>
        <td style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Campus</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Nivel Escuela</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Cuota Mes</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>No.Als</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Equival.</b></td>
        <td colspan="2" align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
        <td colspan="2" align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
      </tr>
      <tr>
          <td colspan="10">&nbsp;</td>
      </tr>  --}}
  </thead>
  <tbody>

  {{$equival = 0}}
  {{$escClave = ''}}
  {{$escNombre = ''}}
  {{$mensualidad = 0}}
  {{$tituloCampus = ''}}
  {{$tituloNivel = ''}}
  {{$nivelAlumnos = 0}}
  {{$nivelEquivalente = 0}}
  {{$nivelacumuladoMes = 0}}
  {{$nivelacumuladoAnio = 0}}
  {{$totalAlumnos = 0}}
  {{$totalEquivalente  = 0}}
  {{$totalacumuladoMes = 0}}
  {{$totalacumuladoAnio = 0}}

  {{ $aumenta = 1 }}

  @foreach($pagos as $item)
              @php
                $cuenta = $item->count();
                $escClave = '';
                $escNombre = '';
                $mensualidad = 0;

                $primerRegistroCampus = $item->first();
                $campCVE = $primerRegistroCampus['ubicacionClave'];
                $campNombre = $primerRegistroCampus['ubicacionNombre'];
                $depCN = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['depNombre'];
                $mensualidadBase = $primerRegistroCampus["mensualidad"];
                $numeromesesBase = $primerRegistroCampus["numMeses"];
                $acumuladoMes = 0;
                $acumuladoAnio = 0;
                $acumuladoEquivalente = 0;
              @endphp


              @if ($tituloCampus != $campCVE)
                  @if ($nivelAlumnos > 0)
                      <tr>
                          <td colspan="10">&nbsp;</td>
                      </tr>
                      <tr>
                          <td align="left" colspan="4" style=" border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($tituloNivel)}}</td>
                          <td align="center" style="border-bottom: 1px solid #000;">{{$nivelAlumnos}}</td>
                          <td align="center" style="border-bottom: 1px solid #000;">{{$nivelEquivalente}}</td>
                          <td colspan="2" align="center" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                          <td colspan="2" align="center" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
                          {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                          {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                          {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                          {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
                          {{$nivelAlumnos = 0}}
                          {{$nivelEquivalente = 0}}
                          {{$nivelacumuladoMes = 0}}
                          {{$nivelacumuladoAnio = 0}}
                      </tr>
                      <tr>
                          <td colspan="10">&nbsp;</td>
                      </tr>

                  @endif
                  <tr>
                      <td colspan="3">
                          <b>{{$campCVE}} {{$campNombre}}</b>
                      </td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td colspan="10">&nbsp;</td>
                  </tr>
                  <tr>
                      <td align="left" colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($depCN)}}</td>
                      <td></td>
                      <td></td>
                      <td colspan="2"></td>
                      <td colspan="2"></td>
                  </tr>
                  {{--  <tr>
                      <td colspan="10">&nbsp;</td>
                  </tr>  --}}
                  {{$tituloCampus = $campCVE}}
                  {{$tituloNivel = $depCN}}
              @else
                  @if ($tituloNivel != $depCN)
                      @if ($nivelAlumnos > 0)

                          <tr>
                              <td colspan="8">&nbsp;</td>
                          </tr>

                          <tr>
                              <td align="left" colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($tituloNivel)}}</td>
                              <td align="center">{{$nivelAlumnos}}</td>
                              <td align="center">{{$nivelEquivalente}}</td>
                              <td align="center">${{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                              <td align="center">${{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
                              {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                              {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                              {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                              {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
                              {{$nivelAlumnos = 0}}
                              {{$nivelEquivalente = 0}}
                              {{$nivelacumuladoMes = 0}}
                              {{$nivelacumuladoAnio = 0}}
                          </tr>

                          <tr>
                              <td colspan="8">&nbsp;</td>
                          </tr>

                      @endif
                      <tr>
                          <td align="left" colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($depCN)}}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      {{$tituloNivel = $depCN}}

                      <tr>
                          <td colspan="8">&nbsp;</td>
                      </tr>

                  @endif
              @endif

            
              @if ($aumenta++ == 1)
              <tr>
                <td style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Campus</b></td>
                <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Nivel Escuela</b></td>
                <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Cuota Mes</b></td>
                <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>No.Als</b></td>
                <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Equival.</b></td>
                <td colspan="2" align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
                <td colspan="2" align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
              </tr>
              @endif
              

              @php  
                      
                $ordenado = $item->sortBy('curTipoBeca');
                $tipoBeca = $ordenado->groupBy('curTipoBeca');
                $contador = 0;
                $contador2 = 1;
                $mensualidadBase = 0;

                
                $acumuladoMes = 0;
                $acumuladoAnio = 0;
                $acumuladoEquivalente = 0;
              @endphp

              @foreach ($tipoBeca as $curTipoBeca => $valoresBeca)
                <tr>
                  <td></td>
                  <td align="left" colspan="2" style="width: 240px;"><b>Beca {{ $curTipoBeca }}</b></td>                          
                

                  @foreach ($valoresBeca as $llave => $beca)    
                                
                    @if ($curTipoBeca == $beca['curTipoBeca'])  

                      
                    @php
                    $escClave = $beca['escClave'];
                    $escNombre = $beca['escNombre'];

                    $equivalente = $beca["porBeca"];
                    $mensualidad = $beca['mensualidad'];
                    $numdeMeses = $beca["numMeses"];

                    $acumuladoMes = $acumuladoMes + ($equivalente * $mensualidad); //$campus["mensualidad"];
                    $acumuladoAnio = $acumuladoAnio + (($equivalente * $mensualidad) * $numdeMeses); //$campus["numMeses"]
                    $acumuladoEquivalente += $equivalente;

                    //ESTIMAMOS POR TIPO DE MENSUALIDAD
                    if ( $mensualidadBase < 3000 )
                    {
                          $mensualidadBase = $mensualidad;
                          $numeromesesBase = $numdeMeses;
                    }
                    else
                    {
                        if ( $mensualidad != $mensualidadBase )
                        {
                          if ($numdeMeses == 10)
                          {
                              $mensualidadBase = $mensualidad;
                              $numeromesesBase = $numdeMeses;
                          }
                        }
                    }

                    $contador++;

                @endphp
                      
                    @endif                     
                  @endforeach  
                  
                  <td align="center">${{number_format($mensualidadBase, 2, '.', '')}}</td>
                  <td align="right">{{$cuenta}}</td>
                  <td align="right">{{number_format($acumuladoEquivalente, 2, '.', '')}}</td>
                  <td colspan="2" align="right">{{number_format($acumuladoMes, 2, '.', '')}}</td>
                  <td colspan="2" align="right">{{number_format($acumuladoAnio, 2, '.', '')}}</td>
                </tr> 
              @endforeach
              
              {{--  <tr>
                      <td></td>
                      <td align="left" colspan="2" style="width: 240px;"><b>{{$escClave}} {{$escNombre}}</b></td>
                      <td align="center">${{number_format($mensualidadBase, 2, '.', ',')}}</td>
                      <td align="center">{{$cuenta}}</td>
                      <td align="center">{{$acumuladoEquivalente}}</td>
                      <td align="center">${{number_format($acumuladoMes, 2, '.', ',')}}</td>
                      <td align="center">${{number_format($acumuladoAnio, 2, '.', ',')}}</td>
              </tr>  --}}
              {{$nivelAlumnos = $nivelAlumnos + $cuenta}}
              {{$nivelacumuladoMes = $nivelacumuladoMes + $acumuladoMes}}
              {{$nivelacumuladoAnio = $nivelacumuladoAnio + $acumuladoAnio}}
              {{$nivelEquivalente = $nivelEquivalente + $acumuladoEquivalente}}
              {{$acumuladoEquivalente = 0}}
              {{$acumuladoMes = 0}}
              {{$acumuladoAnio = 0}}

            @endforeach
            {{--  <tr>
                  <td colspan="10">&nbsp;</td>
            </tr>  --}}
            <tr>
                  <td align="left" colspan="4" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;{{$depCN}}</td>
                  <td align="center" style="border-bottom: 1px solid #000;">{{$nivelAlumnos}}</td>
                  <td align="center" style="border-bottom: 1px solid #000;">{{$nivelEquivalente}}</td>
                  <td colspan="2" align="center" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                  <td colspan="2" align="center" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
                    {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                    {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                    {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                    {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
            </tr>
            {{--  <tr>
              <td colspan="10">&nbsp;</td>
            </tr>  --}}
            <tr>
                <td align="left" colspan="4" style="border-bottom: 1px solid #000;"><b>Totales:</b></td>              
                <td align="center">{{$totalAlumnos}}</td>
                <td align="center">{{$totalEquivalente}}</td>
                <td colspan="2" align="center">{{number_format($totalacumuladoMes, 2, '.', '')}}</td>
                <td colspan="2" align="center">{{number_format($totalacumuladoAnio, 2, '.', '')}}</td>
            </tr>


  </tbody>
</table>
