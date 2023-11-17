<table class="table">
  <thead>
    <th align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;">ESCUELA MODELO S.C.P.
    </th>
  </thead>
</table>
<table class="table">
  <thead>
    <th align="center" style="font-weight: 400; font-size:11px; border-bottom: 1px solid #000;">{{$elTitulo}}
    </th>
  </thead>
</table>
<table class="table">
    <thead>
    <th align="center" style="font-weight: 400; font-size:11px; border-bottom: 1px solid #000;">{{$laUbicacion}}
    </th>
    </thead>
</table>
<table class="table">
    <thead>
    <th align="center" style="font-weight: 400; font-size:11px; border-bottom: 1px solid #000;">{{$elMes}}
    </th>
    </thead>
</table>
<table class="table">
  <thead>
    <th align="center" style="font-weight: 400; font-size:11px; border-bottom: 1px solid #000;">{{$elPeriodo}}
    </th>
  </thead>
</table>
<table class="table">
    <thead>
    <th align="center" style="font-weight: 400; font-size:10px; border-bottom: 1px solid #000;">Fecha: {{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}
    </th>
    </thead>
</table>
<table class="table">
    <thead>
    <th align="center" style="font-weight: 400; font-size:10px; border-bottom: 1px solid #000;">Hora: {{$horaActual}}
    </th>
    </thead>
</table>
<table class="table">
    <thead>
    <th align="center" style="font-weight: 400; font-size:10px; border-bottom: 1px solid #000;">Ultimo pago: {{$ultimaFechaPago}}
    </th>
    </thead>
</table>

    <table class="table">
      <thead>
          <tr>
              <th style="font-weight:bold;">Clave de Pago</th>
              <th colspan="5" style="font-weight:bold;">Nombre Completo del Alumno</th>
              <th style="font-weight:bold;">Año Escolar de Pago</th>
              <th style="font-weight:bold;">Edo Alumno</th>
              <th style="font-weight:bold;">Cve Esc</th>
              <th style="font-weight:bold;">Cve Prog</th>
              <th style="font-weight:bold;">Grado</th>
              <th style="font-weight:bold;">Grupo</th>
              <th style="font-weight:bold;">Edo Curso</th>
              <th style="font-weight:bold;">Plan pago</th>
              <th style="font-weight:bold;">Tipo Beca</th>
              <th style="font-weight:bold;">% Beca</th>
              <th style="font-weight:bold;">Insc 99</th>
              <th style="font-weight:bold;">Sep</th>
              <th style="font-weight:bold;">Oct</th>
              <th style="font-weight:bold;">Nov</th>
              <th style="font-weight:bold;">Dic</th>
              <th style="font-weight:bold;">Ene</th>
              <th style="font-weight:bold;">Insc 00</th>
              <th style="font-weight:bold;">Feb</th>
              <th style="font-weight:bold;">Mar</th>
              <th style="font-weight:bold;">Abr</th>
              <th style="font-weight:bold;">May</th>
              <th style="font-weight:bold;">Jun</th>
              <th style="font-weight:bold;">Jul</th>
              <th style="font-weight:bold;">Ago</th>
              <th style="font-weight:bold;">Año Escolar de Pago</th>
              <th style="font-weight:bold;">Edo Alumno</th>
              <th style="font-weight:bold;">Cve Esc</th>
              <th style="font-weight:bold;">Cve Prog</th>
              <th style="font-weight:bold;">Grado</th>
              <th style="font-weight:bold;">Grupo</th>
              <th style="font-weight:bold;">Edo Curso</th>
              <th style="font-weight:bold;">Plan pago</th>
              <th style="font-weight:bold;">Tipo Beca</th>
              <th style="font-weight:bold;">% Beca</th>
              <th style="font-weight:bold;">Insc 99</th>
              <th style="font-weight:bold;">Sep</th>
              <th style="font-weight:bold;">Oct</th>
              <th style="font-weight:bold;">Nov</th>
              <th style="font-weight:bold;">Dic</th>
              <th style="font-weight:bold;">Ene</th>
              <th style="font-weight:bold;">Insc 00</th>
              <th style="font-weight:bold;">Feb</th>
              <th style="font-weight:bold;">Mar</th>
              <th style="font-weight:bold;">Abr</th>
              <th style="font-weight:bold;">May</th>
              <th style="font-weight:bold;">Jun</th>
              <th style="font-weight:bold;">Jul</th>
              <th style="font-weight:bold;">Ago</th>
              <th style="font-weight:bold;">SUMA</th>
          </tr>
    </thead>
    <tbody>
      @foreach ($datos as $item)
      <tr>
          <td >{{$item->cve_pago}}</td>
          <td colspan="5">{{$item->alumno}}</td>
          <td >{{$item->perAnioPago_anterior}}</td>
          <td >{{$item->alu_estado_anterior}}</td>
          <td >{{$item->cve_escuela_anterior}}</td>
          <td >{{$item->cve_programa_anterior}}</td>
          <td >{{$item->grado_anterior}}</td>
          <td >{{$item->grupo_anterior}}</td>
          <td >{{$item->cur_estado_anterior}}</td>
          <td >{{$item->plan_pago_anterior}}</td>
          <td >{{$item->cur_tipo_beca_anterior}}</td>
          <td >{{$item->cur_por_beca_anterior}}</td>
          <td >{{ empty($item->cve99_xcobrar_anterior) ? ' ' :number_format((float)$item->cve99_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve01_xcobrar_anterior) ? ' ' :number_format((float)$item->cve01_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve02_xcobrar_anterior) ? ' ' :number_format((float)$item->cve02_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve03_xcobrar_anterior) ? ' ' :number_format((float)$item->cve03_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve04_xcobrar_anterior) ? ' ' :number_format((float)$item->cve04_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve05_xcobrar_anterior) ? ' ' :number_format((float)$item->cve05_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve00_xcobrar_anterior) ? ' ' :number_format((float)$item->cve00_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve06_xcobrar_anterior) ? ' ' :number_format((float)$item->cve06_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve07_xcobrar_anterior) ? ' ' :number_format((float)$item->cve07_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve08_xcobrar_anterior) ? ' ' :number_format((float)$item->cve08_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve09_xcobrar_anterior) ? ' ' :number_format((float)$item->cve09_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve10_xcobrar_anterior) ? ' ' :number_format((float)$item->cve10_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve11_xcobrar_anterior) ? ' ' :number_format((float)$item->cve11_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve12_xcobrar_anterior) ? ' ' :number_format((float)$item->cve12_xcobrar_anterior, 2, '.', ',')}}</td>
          <td >{{$item->perAnioPago}}</td>
          <td >{{$item->alu_estado}}</td>
          <td >{{$item->cve_escuela}}</td>
          <td >{{$item->cve_programa}}</td>
          <td >{{$item->grado}}</td>
          <td >{{$item->grupo}}</td>
          <td >{{$item->cur_estado}}</td>
          <td >{{$item->plan_pago}}</td>
          <td >{{$item->cur_tipo_beca}}</td>
          <td >{{$item->cur_por_beca}}</td>
          <td >{{ empty($item->cve99_xcobrar) ? ' ' :number_format((float)$item->cve99_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve01_xcobrar) ? ' ' :number_format((float)$item->cve01_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve02_xcobrar) ? ' ' :number_format((float)$item->cve02_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve03_xcobrar) ? ' ' :number_format((float)$item->cve03_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve04_xcobrar) ? ' ' :number_format((float)$item->cve04_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve05_xcobrar) ? ' ' :number_format((float)$item->cve05_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve00_xcobrar) ? ' ' :number_format((float)$item->cve00_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve06_xcobrar) ? ' ' :number_format((float)$item->cve06_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve07_xcobrar) ? ' ' :number_format((float)$item->cve07_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve08_xcobrar) ? ' ' :number_format((float)$item->cve08_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve09_xcobrar) ? ' ' :number_format((float)$item->cve09_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve10_xcobrar) ? ' ' :number_format((float)$item->cve10_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve11_xcobrar) ? ' ' :number_format((float)$item->cve11_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->cve12_xcobrar) ? ' ' :number_format((float)$item->cve12_xcobrar, 2, '.', ',')}}</td>
          <td >{{ empty($item->suma) ? ' ' :number_format((float)$item->suma, 2, '.', ',')}}</td>
      </tr>
      @endforeach
    </tbody>
    </table>


