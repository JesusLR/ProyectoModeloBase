<table class="table">

  <thead>
    <th>UNIVERSIDAD MODELO
    </th>
  </thead>
</table>
<table class="table">
  <thead>
    <th>ALUMNOS CON MATERIAS SERIADAS REPROBADAS
    </th>
  </thead>
</table>

<table class="table">
  <thead>
    <th>Período: {{$periodo}}
    </th>
  </thead>
</table>
@if ($tipoReporte == 1)
    <table class="table">
      <thead>
      <tr>
        <th>Ubi</th>
        <th>Dep</th>
        <th>Esc</th>
        <th>Prog</th>
        <th>Sem</th>
        <th>Cve Pago</th>
        <th>Nombre</th>
        <th>TI</th>
        <th>Rep</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($datos as $item1)
      <tr>
        <td>{{$item1['ubiClave']}}</td>
        <td>{{$item1['depClave']}}</td>
        <td>{{$item1['escClave']}}</td>
        <td>{{$item1['progClave']}}</td>
        <td>{{$item1['cgtGradoSemestre']}}</td>
        <td>{{$item1['aluClave']}}</td>
        <td>{{$item1['aluNombre']}}</td>
        <td>{{$item1['tipoIngreso']}}</td>
        <td >{{$item1['totalReprobadas']}}</td>
      </tr>
      @endforeach
    </tbody>
    </table>
@endif
@if ($tipoReporte == 2)
    <table class="table">
      <thead>
      <tr>
        <th>Ubi</th>
        <th>Dep</th>
        <th>Esc</th>
        <th>Prog</th>
        <th>Sem</th>
        <th>Cve Pago</th>
        <th>Nombre</th>
        <th>TI</th>
        <th>Rep Clave</th>
        <th>Reprobada</th>
        <th>Cur Clave</th>
        <th>Cursando</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($datos as $item2)
      <tr>
        <td>{{$item2['ubiClave']}}</td>
        <td>{{$item2['depClave']}}</td>
        <td>{{$item2['escClave']}}</td>
        <td>{{$item2['progClave']}}</td>
        <td>{{$item2['semestre']}}</td>
        <td>{{$item2['aluClave']}}</td>
        <td>{{$item2['aluNombre']}}</td>
        <td>{{$item2['tipoIngreso']}}</td>
        <td>{{$item2['repClave']}}</td>
        <td>{{$item2['repNombre']}}</td>
        <td>{{$item2['curClave']}}</td>
        <td>{{$item2['curNombre']}}</td>
      </tr>
      @endforeach
    </tbody>
    </table>
@endif
@if ($tipoReporte == 3)
    <table>
      <thead>
      <tr>
        <th>Ubi</th>
        <th>Dep</th>
        <th>Esc</th>
        <th>Prog</th>
        <th>Sem</th>
        <th>Gpo</th>
        <th>Cve Pago</th>
        <th>Nombre</th>
        <th>TI</th>
        <th>Clave</th>
        <th>Materia</th>
        <th>Sem Materia</th>
        <th>Calif</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($datos as $item3)
      <tr>
        <td>{{$item3['ubiClave']}}</td>
        <td>{{$item3['depClave']}}</td>
        <td>{{$item3['escClave']}}</td>
        <td>{{$item3['progClave']}}</td>
        <td>{{$item3['cgtGradoSemestre']}}</td>
        <td>{{$item3['cgtGrupo']}}</td>
        <td>{{$item3['aluClave']}}</td>
        <td>{{$item3['aluNombre']}}</td>
        <td>{{$item3['curTipoIngreso']}}</td>
        <td>{{$item3['matClave']}}</td>
        <td>{{$item3['matNombre']}}</td>
        <td>{{$item3['matSemestre']}}</td>
        <td>{{$item3['calificacion']}}</td>
      </tr>
      @endforeach
    </tbody>
    </table>
@endif