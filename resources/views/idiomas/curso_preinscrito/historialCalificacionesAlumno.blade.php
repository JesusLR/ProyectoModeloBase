@extends('layouts.dashboard')

@section('template_title')
  Historial de calificaciones
@endsection


@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Lista de Preinscripción</a>
    <a href="{{url('idiomas_curso/' . $curso->curso_id . '/historial_calificaciones_alumno')}}" class="breadcrumb">Historial de calificaciones</a>
@endsection

@section('content')


<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">HISTORIAL DE CALIFICACIONES</span>
        <p>
          ({{$curso->aluClave}})
          {{$curso->perNombre}}
          {{$curso->perApellido1}}
          {{$curso->perApellido2}}
        </p>
        <p>
          Programa: {{ $curso->progClave }} - {{ $curso->progNombre }}
        </p>
        <p>
          Periodo: {{ $curso->perNumero }} - {{ $curso->perAnio }}
        </p>

        {{-- NAVIGATION BAR--}}
        <nav class="nav-extended" style="margin-top: 20px;">
          <div class="nav-content">
            <ul class="tabs tabs-transparent">
              <li class="tab"><a class="active" href="#resumen">Resumen</a></li>
              <li class="tab"><a href="#materias">Materias</a></li>
            </ul>
          </div>
        </nav>

        {{-- GENERAL BAR--}}
        <div id="resumen">
          <input type="hidden" id="cursoId" data-curso-id="{{ $curso->curso_id }}" />
          <div class="row">
            <div class="col s12">
              <table id="tbl-idiomas-resumen-calificaciones" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>Calificación</th>
                    <th>Ponderado</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <div id="materias">
          <div class="row">
            <div class="col s12">
              <table id="tbl-idiomas-calificaciones" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Clave Materia</th>
                    <th>Nombre Materia</th>
                    <!-- <th>Año</th>
                    <th>Período</th> -->
                    <th>Reporte 1</th>
                    <th>Reporte 2</th>
                    <th>MidTerm</th>
                    <th>Proyecto 1</th>
                    <th>Reporte 3</th>
                    <th>Reporte 4</th>
                    <th>Final Exam</th>
                    <th>Proyecto 2</th>
                    <th>Final Score</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <!-- <th></th>
                    <th></th> -->
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}


<script type="text/javascript">
  $(document).ready(function() {


    var cursoId = $("#cursoId").data("curso-id")

    $('#tbl-idiomas-resumen-calificaciones').dataTable({
      "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
      },
      "serverSide": true,
      "dom": '"top"i',
      "pageLength": 10,
      "stateSave": true,
      "ordering": false,
      "ajax": {
        "type" : "GET",
        'url': base_url + '/api/idiomas_curso/' + cursoId + '/listHistorialCalifAlumnosResumen/',
        beforeSend: function () {
          $('.preloader').fadeIn(200, function() { $(this).append('<div id="preloader"></div>'); });
        },
        complete: function () {
          $('.preloader').fadeOut(200, function() { $('#preloader').remove(); });
        }
      },
      "columns":[
        {data: "evaluacion"},
        {data: "calificacion"},
        {data: "ponderado"},
      ],
      //Apply the search
      initComplete: function () {
        var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

        var index = 0
        this.api().columns().every(function () {
          var column = this;
          var columnClass = column.footer().className;
          if(columnClass != 'non_searchable'){
            var input = document.createElement("input");

            var columnDataOld = searchFill.columns[index].search.search
            $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


            $(input).appendTo($(column.footer()).empty())
            .on('change', function () {
              column.search($(this).val(), false, false, true).draw();
            });
          }

          index ++
        });

      },
      stateSaveCallback: function(settings,data) {
        localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
      },
      stateLoadCallback: function(settings) {
        return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
      }
    });

    $('#tbl-idiomas-calificaciones').dataTable({
      "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
      },
      "serverSide": true,
      "dom": '"top"i',
      "pageLength": 5,
      "stateSave": true,
      "ajax": {
        "type" : "GET",
        'url': base_url + '/api/idiomas_curso/' + cursoId + '/listHistorialCalifAlumnos/',
        beforeSend: function () {
          $('.preloader').fadeIn(200, function() { $(this).append('<div id="preloader"></div>'); });
        },
        complete: function () {
          $('.preloader').fadeOut(200, function() { $('#preloader').remove(); });
        }
      },
      "columns":[
        {data: "matClave",   name:"idiomas_materias.matClave"},
        {data: "matNombre",  name:"idiomas_materias.matNombre"},
        // {data: "perAnio",    name:"periodos.perAnio"},
        // {data: "perNumero",  name:"periodos.perNumero"},
        {data: "cmReporte1", name:"idiomas_calificaciones_materia.cmReporte1"},
        {data: "cmReporte2", name:"idiomas_calificaciones_materia.cmReporte2"},
        {data: "rcMidTerm",  name:"idiomas_resumen_calificaciones.rcMidTerm"},
        {data: "rcProject1", name:"idiomas_resumen_calificaciones.rcProject1"},
        {data: "cmReporte3", name:"idiomas_calificaciones_materia.cmReporte3"},
        {data: "cmReporte4", name:"idiomas_calificaciones_materia.cmReporte4"},
        {data: "rcFinalExam",  name:"idiomas_resumen_calificaciones.rcFinalExam"},
        {data: "rcProject2", name:"idiomas_resumen_calificaciones.rcProject2"},
        {data: "rcFinalScore", name:"idiomas_resumen_calificaciones.rcFinalScore"},
      ],
      //Apply the search
      initComplete: function () {
        var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

        var index = 0
        this.api().columns().every(function () {
          var column = this;
          var columnClass = column.footer().className;
          if(columnClass != 'non_searchable'){
            var input = document.createElement("input");

            var columnDataOld = searchFill.columns[index].search.search
            $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


            $(input).appendTo($(column.footer()).empty())
            .on('change', function () {
              column.search($(this).val(), false, false, true).draw();
            });
          }

          index ++
        });

      },
      stateSaveCallback: function(settings,data) {
        localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
      },
      stateLoadCallback: function(settings) {
        return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
      }
    });
  });
</script>
@endsection
