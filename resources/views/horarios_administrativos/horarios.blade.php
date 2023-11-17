@extends('layouts.dashboard')

@php use App\Http\Helpers\Utils; @endphp

@section('template_title')
    Horarios Administrativos
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('horarios_administrativos')}}" class="breadcrumb">Horarios administrativos</a>
    <a href="{{url()->current()}}" class="breadcrumb">Calendario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'horarios_administrativos/agregarHorarios', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR HORARIOS AL MAESTRO #{{--$grupo->id--}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <br>
                <input id="periodo_id" name="periodo_id" type="hidden" value="{{$periodoId}}">
                <input id="empleado_id" name="empleado_id" type="hidden" value="{{$claveMaestro}}">
                <div class="row">
                    <div class="col s12">
                        <span>Período: <b>{{$periodo->perNumero}} / {{$periodo->perAnio}}</b></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span>Ubicación: <b> ({{$periodo->departamento->ubicacion->ubiClave}}) {{$periodo->departamento->ubicacion->ubiNombre}}</b></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <!-- <span>Escuela: <b>($grupo->plan->programa->escuela->escClave}}) $grupo->plan->programa->escuela->escNombre}}</b></span> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <span>Docente: <b>{{$maestro->persona->perNombre}} {{$maestro->persona->perApellido1}} {{$maestro->persona->perApellido2}}</b></span>
                    </div>
                </div>



                <div class="row">
                    <div class="col s12">
                        <span>Total horas docente: <b>{{$totalHorasMaestro}}</b></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <span>Total horas administrativo: <b>{{$totalHorasAdmivo}}</b></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span>Total horas laborales: <b>{{$totalHorasLaborales}}</b></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span>Total horas contrato: <b>{{$maestro->empHorasCon}}</b></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('ghDia', 'Día', array('class' => '')); !!}
                        <select id="ghDia" class="browser-default validate select2" required name="ghDia" style="width: 100%;">
                            @for($i=1;$i<=6;$i++)
                                <option value="{{$i}}" @if(old('ghDia') == $i) {{ 'selected' }} @endif>{{Utils::diaSemana($i)}}</option>
                            @endFor
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3">
                        {!! Form::label('ghInicio', 'Hora Inicio', array('class' => '')); !!}
                        <select id="ghInicio" class="browser-default validate select2" required name="ghInicio" style="width: 100%;">
                            @for($i=7;$i<=22;$i++)
                                <option value="{{$i}}" @if(old('ghInicio') == $i) {{ 'selected' }} @endif>{{$i}}Hrs</option>
                            @endFor
                        </select>
                    </div>
                    <div class="col s12 m3">
                        {!! Form::label('gMinInicio', 'Minutos', array('class' => '')); !!}
                        <select id="gMinInicio" class="browser-default validate select2" required name="gMinInicio" style="width: 100%; margin-top: 10px;">
                            <option value="00">0 Min</option>
                            <option value="05">5 Min</option>
                            <option value="10">10 Min</option>
                            <option value="15">15 Min</option>
                            <option value="20">20 Min</option>
                            <option value="25">25 Min</option>
                            <option value="30">30 Min</option>
                            <option value="35">35 Min</option>
                            <option value="40">40 Min</option>
                            <option value="45">45 Min</option>
                            <option value="50">50 Min</option>
                            <option value="55">55 Min</option>
                        </select>
                    </div>

                    <div class="col s12 m3">
                        {!! Form::label('ghFinal', 'Hora Final', array('class' => '')); !!}
                        <select id="ghFinal" class="browser-default validate select2" required name="ghFinal" style="width: 100%;">
                            @for($i=7;$i<=22;$i++)
                                <option value="{{$i}}" @if(old('ghFinal') == $i) {{ 'selected' }} @endif>{{$i}}Hrs</option>
                            @endFor
                        </select>
                    </div>
                    <div class="col s12 m3">
                        {!! Form::label('gMinFinal', 'Minutos', array('class' => '')); !!}
                        <select id="gMinFinal" class="browser-default validate select2" required name="gMinFinal" style="width: 100%; margin-top: 10px;">
                            <option value="00" selected>0 Min</option>
                            <option value="05">5 Min</option>
                            <option value="10">10 Min</option>
                            <option value="15">15 Min</option>
                            <option value="20">20 Min</option>
                            <option value="25">25 Min</option>
                            <option value="30">30 Min</option>
                            <option value="35">35 Min</option>
                            <option value="40">40 Min</option>
                            <option value="45">45 Min</option>
                            <option value="50">50 Min</option>
                            <option value="55">55 Min</option>
                        </select>
                    </div>
                </div>
                <div class="card-action">
                {!! Form::button('<i class="material-icons left">add</i> Agregar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col l6 m12 s12">
                        <p><b>HORARIOS ADMINISTRATIVOS</b></p>
                        <table id="tbl-horario" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col l6 m12 s12">
                        <p><b>HORARIOS POR GRUPO</b></p>
                        <table id="tbl-horario-gpo" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Materia</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        var periodoId = $('#periodo_id').val();
        var claveMaestro = $('#empleado_id').val();

        if (claveMaestro !== "" && claveMaestro !== null && periodoId !== "" && periodoId !== null) {
            $('#tbl-horario').dataTable({
                "language":{"url":base_url + "/api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                // "pageLength": 5,
                "bPaginate": false,
                "ajax": {
                    "type" : "GET",
                    'url': base_url + "/api/horarios_administrativos/horario/" + claveMaestro + "/" + periodoId,
                    beforeSend: function () {
                        $('.preloader').fadeIn(200, function() {
                            $(this).append('<div id="preloader"></div>');
                        });
                    },
                    complete: function () {
                        $('.preloader').fadeOut(200, function() {
                            $('#preloader').remove();
                        });
                    },
                },
                "columns":[
                    {data: "dia"},
                    {data: "horaInicio"},
                    {data: "horaFinal"},
                    {data: "action"}
                ]
            });
        }



        $('#tbl-horario-gpo').dataTable({
            "language":{"url":base_url + "/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            // "pageLength": 5,
            "bPaginate": false,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/horarios_administrativos/horario_gpo/" + claveMaestro + "/" + periodoId,
                beforeSend: function () {
                    $('.preloader').fadeIn(200, function() {
                        $(this).append('<div id="preloader"></div>');
                    });
                },
                complete: function () {
                    $('.preloader').fadeOut(200, function() {
                        $('#preloader').remove();
                    });
                },
            },
            "columns":[
                {data: "dia"},
                {data: "horaInicio"},
                {data: "horaFinal"},
                {data: "materia"},
            ]
        });




    });
</script>
@endsection