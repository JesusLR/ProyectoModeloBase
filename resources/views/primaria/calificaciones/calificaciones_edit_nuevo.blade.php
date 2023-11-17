@extends('layouts.dashboard')

@section('template_title')
Primaria calificaciones Nuevo
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('primaria_grupo')}}" class="breadcrumb">Inicio</a>
<a href="{{route('primaria_grupo.index')}}" class="breadcrumb">Lista de Grupo</a>
<a href="#"
    class="breadcrumb">Editar calificación</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'primaria_calificacion.calificaciones.update_calificacion', 'method' => 'POST']) !!}

        {{--
        <div class="row">
            <input type="number" id="nuevo" lang="en" value="3.1" data-decimals="1" placeholder="1.0" step="0.1" min="0.0" max="10.0">
        </div>
        --}}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CAPTURA DE CALIFICACIONES DEL GRUPO #{{$calificaciones[0]->primaria_grupo_id}}</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                            {{-- <li class="tab"><a href="#equivalente">Equivalente</a></li> --}}
                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR--}}
                <div id="general">


                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id2', 'Periodo *', ['class' => '']); !!}
                            <input type="text" value="{{$calificaciones[0]->perNumero}}-{{\Carbon\Carbon::parse($calificaciones[0]->perFechaInicial)->format('Y')}}" readonly>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('primaria_grupo_id2', 'Grupo *', ['class' => '']); !!}
                            <input type="text" readonly
                            @if ($calificaciones[0]->matClaveAsignatura != "")
                            value="{{$calificaciones[0]->gpoGrado}}{{$calificaciones[0]->gpoClave}}, Prog: {{$calificaciones[0]->progClave}}, Asignatura: {{$calificaciones[0]->matClaveAsignatura}}-{{$calificaciones[0]->matNombreAsignatura}}"
                            @else
                            value="{{$calificaciones[0]->gpoGrado}}{{$calificaciones[0]->gpoClave}}, Prog: {{$calificaciones[0]->progClave}}, Materia: {{$calificaciones[0]->matClave}}-{{$calificaciones[0]->matNombre}}"
                            @endif
                            >
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('materia_id2', 'Materia *', ['class' => '']); !!}
                            <input type="text" readonly value="{{$calificaciones[0]->matNombre}}">
                        </div>
                    </div>

                    <div class="row">
                     
                        <div class="col s12 m6 l4">
                            {!! Form::label('que_mes_se_evalua', 'Mes de evaluación *', array('class' => '')); !!}
                            <select id="que_mes_se_evalua_alumno" class="browser-default validate select2" required name="que_mes_se_evalua_alumno"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                <option value="OCTUBRE">OCTUBRE</option>
                                <option value="NOVIEMBRE">NOVIEMBRE</option>
                                <option value="ENERO">DICIEMBRE-ENERO</option>
                                <option value="FEBRERO">FEBRERO</option>
                                <option value="MARZO">MARZO</option>
                                <option value="ABRIL">ABRIL</option>
                                <option value="MAYO">MAYO</option>
                                <option value="JUNIO">JUNIO</option>
                            </select>
                        </div>

                       
                    </div>



                </div>
                <br>
                <div class="row">
                    <h5 id="info"></h5>
                </div>

                <div class="row" style="display: none;" id="alerta-menos-de-ciente">
                    <div class="col s12 m6 l12">
                        <h6 style="color: red">
                            "Aún NO SE HAN DEFINIDO TODAS LAS EVIDENCIAS DE APRENDIZAJE para este mes (porcentaje menor al 100%). Favor de regresar al módulo de GRUPOS, EVIDENCIAS DE APRENDIZAJE, seleccione el mes y termine de ingresar las evidencias faltantes para llegar al 100%."

                        </h6>
                    </div>
                </div>
                <div class="row" style="display: none;" id="alerta-min-max-calif">
                    <div class="col s12 m6 l12">
                        <h6 style="color: red">
                            Nota:
                            <p>Calificación de captura mínima permitida es 5</p>
                            <p>Calificación de captura máxima permitida es 10</p>

                        </h6>                      
                    </div>
                </div>

                <table class="bordered" id="table_inscritos" style="display: none;">
                    <thead>
                        <tr>
                            <td style="display: none;">ID</td>
                            <th>#</th>
                            <th>CLAVE PAGO</th>
                            <th>NOMBRE ALUMNO</th>
                            <th>CALIFICACIÓN <label id="que_mes" style="color: white;"></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($calificaciones as $key => $item)
                            <tr>
                                <td style="display: none;">{{$item->id}}</td>
                                <td>{{$key+1}}</td>
                                <td>{{$item->aluClave}}</td>
                                <td>{{$item->perApellido1.' '.$item->perApellido2.' '.$item->perNombre}}</td>
                                <td style="display: none;" class="ocultaSep"><input type="number" id="inscCalificacionSep" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionSep}}" name="inscCalificacionSep[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaOct"><input type="number" id="inscCalificacionOct" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionOct}}" name="inscCalificacionOct[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaNov"><input type="number" id="inscCalificacionNov" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionNov}}" name="inscCalificacionNov[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaEne"><input type="number" id="inscCalificacionEne" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionEne}}" name="inscCalificacionEne[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaFeb"><input type="number" id="inscCalificacionFeb" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionFeb}}" name="inscCalificacionFeb[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaMar"><input type="number" id="inscCalificacionMar" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionMar}}" name="inscCalificacionMar[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaAbr"><input type="number" id="inscCalificacionAbr" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionAbr}}" name="inscCalificacionAbr[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaMay"><input type="number" id="inscCalificacionMay" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionMay}}" name="inscCalificacionMay[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                                <td style="display: none;" class="ocultaJun"><input type="number" id="inscCalificacionJun" onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value="{{$item->inscCalificacionJun}}" name="inscCalificacionJun[]" step="0.1" lang="en"  min="5" max="10" class="noUpperCase"></td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
              

            </div>

            <div class="card-action" id="btn-ocultar-si-es-menor-a-cien" style="display: none">
                <button type="submit" onclick="this.disabled=true;this.form.submit();this.innerText='Guardando datos...';" class="btn-guardar btn-large waves-effect darken-3"><i
                        class="material-icons left">save</i>Guardar</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>



<style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table thead {
      background: #01579B;
      color: #fff;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
</style>


@endsection

@section('footer_scripts')

<script>

$("#que_mes_se_evalua_alumno").change(function(){

    var mes_evaluar = $('select[id=que_mes_se_evalua_alumno]').val();

    $("#table_inscritos").show();
    $("#btn-ocultar-si-es-menor-a-cien").show();
    $("#alerta-min-max-calif").show();


    
    if(mes_evaluar == "SEPTIEMBRE"){
        $("#que_mes").html("SEPTIEMBRE");
        $(".ocultaSep").show();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "OCTUBRE"){
        $("#que_mes").html("OCTUBRE");
        $(".ocultaSep").hide();
        $(".ocultaOct").show();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "NOVIEMBRE"){
        $("#que_mes").html("NOVIEMBRE");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").show();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "ENERO"){
        $("#que_mes").html("ENERO");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").show();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "FEBRERO"){
        $("#que_mes").html("FEBRERO");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").show();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "MARZO"){
        $("#que_mes").html("MARZO");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").show();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "ABRIL"){
        $("#que_mes").html("ABRIL");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").show();
        $(".ocultaMay").hide();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "MAYO"){
        $("#que_mes").html("MAYO");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").show();
        $(".ocultaJun").hide();
    }

    if(mes_evaluar == "JUNIO"){
        $("#que_mes").html("JUNIO");
        $(".ocultaSep").hide();
        $(".ocultaOct").hide();
        $(".ocultaNov").hide();
        $(".ocultaEne").hide();
        $(".ocultaFeb").hide();
        $(".ocultaMar").hide();
        $(".ocultaAbr").hide();
        $(".ocultaMay").hide();
        $(".ocultaJun").show();
    }
    
    
});
</script>

@endsection
