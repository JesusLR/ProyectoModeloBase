          <table class="table" border="0">
            <thead>
                <tr>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Campus</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Nivel Escuela Programa</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Periodo Año</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
            </thead>
           <tbody>
              {{--dd($pagos)--}}
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

              @foreach($pagos as $item)


                  @php
                    $cuenta = $item->count();
                    $escClave = '';
                    $escNombre = '';
                    $mensualidad = 0;

                    $primerRegistroCampus = $item->first();
                    $porcentajeBecas = $primerRegistroCampus['beca'];
                    $campCVE = $primerRegistroCampus['ubicacionClave'];
                    $campNombre = $primerRegistroCampus['ubicacionNombre'];
                    $depCN = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['depNombre'];
                    $escuelaPrograma = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['escNombre'].' - '.$primerRegistroCampus['progNombre'];
                    $mensualidadBase = $primerRegistroCampus["mensualidad"];
                    $numeromesesBase = $primerRegistroCampus["numMeses"];
                    $acumuladoMes = 0;
                    $acumuladoAnio = 0;
                    $acumuladoEquivalente = 0;
                  @endphp


                  @if ($tituloCampus != $campCVE)
                      @if ($nivelAlumnos > 0)
                          <tr>
                              <td colspan="8">&nbsp;</td>
                          </tr>
                          <tr>
                              <td align="left" colspan="5" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
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
                          <td colspan="8">&nbsp;</td>
                      </tr>
                      <tr>
                          <td align="left" colspan="6" ><b>&nbsp;&nbsp;&nbsp;{{$campCVE}} {{strtoupper($escuelaPrograma)}}</b></td>
                          <td align="left" colspan="2" ><b>Cuota Mensual Estimada: ${{number_format($mensualidadBase, 2, '.', ',')}}</b></td>
                      </tr>
                      <tr>
                          <td align="left" colspan="5"><b>Número de Alumnos % Beca Importe Total</b></td>
                          <td align="center" colspan="3"></td>
                      </tr>
                      {{$tituloCampus = $campCVE}}
                      {{$tituloNivel = $escuelaPrograma}}
                  @else
                      @if ($tituloNivel != $escuelaPrograma)
                          @if ($nivelAlumnos > 0)

                              <tr>
                                  <td colspan="8">&nbsp;</td>
                              </tr>

                              <tr>
                                  <td align="left" colspan="5">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                                  <td align="right"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}} </b></td>
                                  <td align="right"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                                  <td align="right"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
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

                              <tr>
                                  <td colspan="8">&nbsp;</td>
                              </tr>

                          @endif
                          <tr>
                              <td align="left" colspan="6">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($escuelaPrograma)}}</b></td>
                              <td align="left" colspan="2"><b>Cuota Mensual Estimada: ${{number_format($mensualidadBase, 2, '.', ',')}}</b></td>
                          </tr>
                          {{$tituloNivel = $escuelaPrograma}}

                          <tr>
                              <td align="left" colspan="5"><b>Número de Alumnos % Beca  Importe Total</b></td>
                              <td align="center" colspan="3"></td>
                          </tr>

                      @endif
                  @endif


                  @foreach ($item as $campus)
                      @php
                          $equivalente = $campus["porBeca"];
                          $mensualidad = $campus['mensualidad'];
                          $numdeMeses = $campus["numMeses"];

                          $acumuladoMes = $acumuladoMes + ($equivalente * $mensualidad);
                          $acumuladoAnio = $acumuladoAnio + (($equivalente * $mensualidad) * $numdeMeses);
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
                      <td align="left" colspan="5">{{$cuenta}} de {{$porcentajeBecas}}% =  ${{number_format($acumuladoMes, 2, '.', ',')}}</td>
                      <td align="center"></td>
                      <td align="right">${{number_format($acumuladoMes, 2, '.', ',')}}</td>
                      <td align="right">${{number_format($acumuladoAnio, 2, '.', ',')}}</td>
                  </tr>

                  {{$nivelAlumnos = $nivelAlumnos + $cuenta}}
                  {{$nivelacumuladoMes = $nivelacumuladoMes + $acumuladoMes}}
                  {{$nivelacumuladoAnio = $nivelacumuladoAnio + $acumuladoAnio}}
                  {{$nivelEquivalente = $nivelEquivalente + $acumuladoEquivalente}}
                  {{$acumuladoEquivalente = 0}}
                  {{$acumuladoMes = 0}}
                  {{$acumuladoAnio = 0}}

            @endforeach
            <tr>
                    <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                    <td align="left" colspan="5" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
                    {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                    {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                    {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                    {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
            </tr>
            <tr>
                    <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                    <td colspan="5">&nbsp;</td>
                    <td class="letraencabezado" align="right"><b>Totales:</b></td>
                    <td align="right"><b>${{number_format($totalacumuladoMes, 2, '.', ',')}}</b></td>
                    <td align="right"><b>${{number_format($totalacumuladoAnio, 2, '.', ',')}}</b></td>
            </tr>

           </tbody>
          </table>