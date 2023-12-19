<table class="table" border="0">
  <thead>
   
      {{--  <tr>
        <td style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Campus</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Nivel Escuela</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Cuota Mes</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>No.Als</b></td>
        <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Equival.</b></td>
        <td align="right" colspan="2" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
        <td align="right" colspan="2" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
      </tr>  --}}
      {{--  <tr>
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
                          <td align="right" style="border-bottom: 1px solid #000;">{{$nivelAlumnos}}</td>
                          <td align="right" style="border-bottom: 1px solid #000;">{{$nivelEquivalente}}</td>
                          <td align="right" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                          <td align="right" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
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
                      <td></td>
                      <td></td>
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
                              <td colspan="10">&nbsp;</td>
                          </tr>

                          <tr>
                              <td align="left" colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($tituloNivel)}}</td>
                              <td align="right">{{$nivelAlumnos}}</td>
                              <td align="right">{{$nivelEquivalente}}</td>
                              <td align="right">{{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                              <td align="right">{{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
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
                          <td align="left" colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;{{strtoupper($depCN)}}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      {{$tituloNivel = $depCN}}

                      <tr>
                          <td colspan="10">&nbsp;</td>
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
                    <td align="right" colspan="2" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
                    <td align="right" colspan="2" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
                </tr>
              @endif
            
              @foreach ($item as $campus)
                  @php
                      $escClave = $campus['escClave'];
                      $escNombre = $campus['escNombre'];

                      $equivalente = $campus["porBeca"];
                      $mensualidad = $campus['mensualidad'];
                      $numdeMeses = $campus["numMeses"];

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


                  @endphp

              @endforeach
              <tr>
                      <td></td>
                      <td align="left" colspan="2" style="width: 240px;"><b>{{$escClave}} {{$escNombre}}</b></td>
                      <td align="right">{{number_format($mensualidadBase, 2, '.', '')}}</td>
                      <td align="right">{{$cuenta}}</td>
                      <td align="right">{{$acumuladoEquivalente}}</td>
                      <td colspan="2" align="right">{{number_format($acumuladoMes, 2, '.', '')}}</td>
                      <td colspan="2" align="right">{{number_format($acumuladoAnio, 2, '.', '')}}</td>
              </tr>

              @php

                $conteo = 0;
                $ordenado = $item->sortBy('curTipoBeca');
                $tipoBeca = $ordenado->groupBy('curTipoBeca');

                $acumuladoEquivalente2 = 0;
                $mensualidadBase2 = 0;
                $acumuladoMes2 = 0;
                $acumuladoAnio2 = 0;
              @endphp
              @foreach ($tipoBeca as $tbeca => $valoresBeca)
                @foreach ($valoresBeca as $beca)
                  @if ($tbeca == $beca['curTipoBeca'])

                    @php
                      $equivalente2 = $beca["porBeca"];
                      $acumuladoEquivalente2 += $equivalente2;

                      $mensualidad2 = $beca['mensualidad'];
                      $numdeMeses2 = $beca["numMeses"];

                      $mensualidadBase2 = $beca["mensualidad"];
                      $numeromesesBase2 = $beca["numMeses"];
                      

                      //ESTIMAMOS POR TIPO DE MENSUALIDAD
                      if ( $mensualidadBase2 < 3000 )
                      {
                            $mensualidadBase2 = $mensualidad2;
                            $numeromesesBase2 = $numdeMeses2;
                      }
                      else
                      {
                          if ( $mensualidad2 != $mensualidadBase2 )
                          {
                            if ($numdeMeses2 == 10)
                            {
                                $mensualidadBase2 = $mensualidad2;
                                $numeromesesBase2 = $numdeMeses2;
                            }
                          }
                      }

                      $conteo++;
                      $acumuladoMes2 = $acumuladoMes2 + ($equivalente2 * $mensualidad2); //$campus["mensualidad"];
                      $acumuladoAnio2 = $acumuladoAnio2 + (($equivalente2 * $mensualidad2) * $numdeMeses2); //$campus["numMeses"]
                    @endphp
                  
                    
                  @endif
                @endforeach  
                <tr>
                    
                  {{--  <td></td>  --}}
                  <td align="left" colspan="2" style="width: 240px;"></td>

                  <td align="right">Beca {{ $tbeca }}</td>

                  <td align="right">{{number_format($mensualidadBase2, 2, '.', '')}}</td>

                  <td align="right">{{$conteo}}</td>   
                  
                  <td align="right">{{number_format($acumuladoEquivalente2, 2, '.', ',')}}</td>

                  <td colspan="2"align="right">{{number_format($acumuladoMes2, 2, '.', '')}}</td>

                  <td colspan="2" align="right">{{number_format($acumuladoAnio2, 2, '.', '')}}</td>

                  
                  {{$acumuladoEquivalente2 = 0}}
                  {{$mensualidadBase2 = 0}}
                  {{$conteo = 0}}
                  {{$acumuladoMes2 = 0}}
                  {{$acumuladoAnio2 = 0}}


                </tr>     

                
                   
              @endforeach

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
                  <td align="right" style="border-bottom: 1px solid #000;">{{$nivelAlumnos}}</td>
                  <td align="right" style="border-bottom: 1px solid #000;">{{$nivelEquivalente}}</td>
                  <td colspan="2" align="right" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoMes, 2, '.', '')}}</td>
                  <td colspan="2" align="right" style="border-bottom: 1px solid #000;">{{number_format($nivelacumuladoAnio, 2, '.', '')}}</td>
                    {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                    {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                    {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                    {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
            </tr>
            {{--  <tr>
              <td colspan="10">&nbsp;</td>
            </tr>  --}}
            
            <tr>
               {{--  <td><b>Totales:</b></td>
               <td></td>
               <td></td>
               <td></td>
                <td align="right"><b>{{$totalAlumnos}}</b></td>
                <td align="right"><b>{{$totalEquivalente}}</b></td>
                <td colspan="2" align="right"><b>{{number_format($totalacumuladoMes, 2, '.', '')}}</b></td>
                <td colspan="2" align="right"><b>{{number_format($totalacumuladoAnio, 2, '.', '')}}</b></td>  --}}


                <td align="left" colspan="4" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;<b>Totales:</b></td>
                <td align="right" style="border-bottom: 1px solid #000;">{{$totalAlumnos}}</td>
                <td align="right" style="border-bottom: 1px solid #000;">{{$totalEquivalente}}</td>
                <td colspan="2" align="right" style="border-bottom: 1px solid #000;">{{number_format($totalacumuladoMes, 2, '.', '')}}</td>
                <td colspan="2" align="right" style="border-bottom: 1px solid #000;">{{number_format($totalacumuladoAnio, 2, '.', '')}}</td>
            </tr>


  </tbody>
</table>
