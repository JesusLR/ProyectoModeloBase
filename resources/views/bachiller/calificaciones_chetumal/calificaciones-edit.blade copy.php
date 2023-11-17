@extends('layouts.dashboard')

@section('template_title')
Bachiller calificaciones
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('bachiller.bachiller_grupo_seq.index')}}" class="breadcrumb">Lista de Grupo</a>
<a href="{{url('bachiller_calificacion_seq/grupo/'.$grupos_inscritos[0]->bachiller_grupo_id.'/edit')}}" class="breadcrumb">Editar calificación</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_calificacion_seq.calificaciones.update_calificacion', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR CALIFICACIONES GRUPO #{{$grupos_inscritos[0]->bachiller_grupo_id}}</span>

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


                    <input type="hidden" id="bachiller_cch_grupo_id" name="bachiller_cch_grupo_id" value="{{$grupos_inscritos[0]->bachiller_grupo_id}}">
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id2', 'Ciclo escolar *', ['class' => '']); !!}
                            <select name="periodo_id2" id="periodo_id2" class="browser-default validate select2"
                                style="width: 100%;">
                                <option value="{{$grupos_inscritos[0]->periodo_id}}">
                                    {{$grupos_inscritos[0]->perNumero.'-'.$grupos_inscritos[0]->perAnio}}
                                </option>

                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('grupo_id2', 'Grado-Grupo *', ['class' => '']); !!}
                            <select name="grupo_id2" id="grupo_id2"
                                class="browser-default validate select2" style="width: 100%;">
                                <option value="{{$grupos_inscritos[0]->bachiller_grupo_id}}">
                                    {{$grupos_inscritos[0]->gpoGrado}}-{{$grupos_inscritos[0]->gpoClave}}
                                </option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('materia_id2', 'Materia *', ['class' => '']); !!}
                            <select name="materia_id2" id="materia_id2" class="browser-default validate select2"
                                style="width: 100%;">
                                <option value="{{$grupos_inscritos[0]->id_materia}}">{{$grupos_inscritos[0]->matNombre}}
                            </select>
                        </div>
                    </div>

                    <div class="row">

                        @if ($grupos_inscritos[0]->gpoMatComplementaria != "")
                        <div class="col s12 m6 l4">
                            {!! Form::label('complementaria', 'Complemento *', ['class' => '']); !!}
                            <select name="complementaria" id="complementaria" class="browser-default validate select2" style="width: 100%;">
                                <option value="{{$grupos_inscritos[0]->id_materia}}">{{$grupos_inscritos[0]->gpoMatComplementaria}}
                            </select>
                        </div>
                        @endif
                        
                        <div class="col s12 m6 l4">
                            {!! Form::label('que_se_va_a_calificar', '¿Que desea calificar? *', array('class' => '')); !!}
                            <select id="que_se_va_a_calificar" class="browser-default validate select2" required
                                name="que_se_va_a_calificar" style="width: 100%;"
                                data-mes-idold="que_se_va_a_calificar">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="parcial1">* ORDINARIO PRIMER PARCIAL</option>
                                <option value="parcial2">* ORDINARIO SEGUNDO PARCIAL</option>
                                <option value="parcial3">* ORDINARIO TERCER PARCIAL</option>
                                <option value="parcial4">* ORDINARIO CUARTO PARCIAL</option>
                                <option value="recuperacion">* RECUPERACIÓN</option>
                                <option value="extraordinario">* EXTRAORDINARIO DE REGULARIZACIÓN</option>
                                <option value="especial">* EXÁMEN ESPECIAL</option>
                            </select>
                        </div>               
                    
                        
                    </div>


                </div>
                <br>
                <div class="row">
                    <h5 id="info"></h5>
                </div>
                <div class="row" id="Tablaalumnos" style="display: none;">
                    <div class="col s12">
                        <table class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th>Núm</th>
                                    <th>Clave Pago</th>
                                    <th>Nombre Alumno</th>
                                    <th style="display: none" id="ordi1">Ordinario Calificacion Parcial 1</th>
                                    <th style="display: none" id="faltasOrdi1">Faltas Ordinario Parcial 1</th>

                                    <th style="display: none" id="ordi2">Ordinario Calificacion Parcial 2</th>
                                    <th style="display: none" id="faltasOrdi2">Faltas Ordinario Parcial 2</th>

                                    <th style="display: none" id="ordi3">Ordinario Calificacion Parcial 3</th>
                                    <th style="display: none" id="faltasOrdi3">Faltas Ordinario Parcial 3</th>

                                    <th style="display: none" id="ordi4">Ordinario Calificacion Parcial 4</th>
                                    <th style="display: none" id="faltasOrdi4">Faltas Ordinario Parcial 4</th>

                                    <th style="display: none" id="recu1">Calificación Recuperativo 1</th>
                                    <th style="display: none" id="recu2">Calificación Recuperativo 2</th>
                                    <th style="display: none" id="recu3">Calificación Recuperativo 3</th>
                                    <th style="display: none" id="recu4">Calificación Recuperativo 4</th>


                                    <th style="display: none" id="extra1">Calificación Extraordinario 1</th>
                                    <th style="display: none" id="extra2">Calificación Extraordinario 2</th>
                                    <th style="display: none" id="extra3">Calificación Extraordinario 3</th>
                                    <th style="display: none" id="extra4">Calificación Extraordinario 4</th>

                                    <th style="display: none" id="espe">Calificación Especial</th>

                                    <th style="display: none">ID</th>



                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($grupos_inscritos as $key => $item)
                                <tr>
                                    
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->aluClave}}</td>
                                    <td>{{$item->perApellido1}} {{$item->perApellido2}} {{$item->perNombre}}</td>

                                    {{--  /* ------------------------------- INICIO ORDINARIOS ------------------------------- */  --}}
                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionOrdinarioParcial1" name="insCalificacionOrdinarioParcial1[]" value="{{$item->insCalificacionOrdinarioParcial1}}" @if ($item->insCalificacionOrdinarioParcial1 < 6) style="border-color: red" @else style="border-color: #01579B;" @endif></td>
                                    <td style="display: none"><input type="number" id="insFaltasOrdinarioParcial1" name="insFaltasOrdinarioParcial1[]" value="{{$item->insFaltasOrdinarioParcial1}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionOrdinarioParcial2" name="insCalificacionOrdinarioParcial2[]" value="{{$item->insCalificacionOrdinarioParcial2}}" @if ($item->insCalificacionOrdinarioParcial2 < 6) style="border-color: red" @else style="border-color: #01579B;" @endif></td>
                                    <td style="display: none"><input type="number" id="insFaltasOrdinarioParcial2" name="insFaltasOrdinarioParcial2[]" value="{{$item->insFaltasOrdinarioParcial2}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionOrdinarioParcial3" name="insCalificacionOrdinarioParcial3[]" value="{{$item->insCalificacionOrdinarioParcial3}}" @if ($item->insCalificacionOrdinarioParcial3 < 6) style="border-color: red" @else style="border-color: #01579B;" @endif></td>
                                    <td style="display: none"><input type="number" id="insFaltasOrdinarioParcial3" name="insFaltasOrdinarioParcial3[]" value="{{$item->insFaltasOrdinarioParcial3}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionOrdinarioParcial4" name="insCalificacionOrdinarioParcial4[]" value="{{$item->insCalificacionOrdinarioParcial4}}" @if ($item->insCalificacionOrdinarioParcial4 < 6) style="border-color: red" @else style="border-color: #01579B;" @endif></td>
                                    <td style="display: none"><input type="number" id="insFaltasOrdinarioParcial4" name="insFaltasOrdinarioParcial4[]" value="{{$item->insFaltasOrdinarioParcial4}}"></td>

                                    {{--  /* ----------------------------- FIN ORDINARIOS ----------------------------- */  --}}

                                    
                                    {{--  /* --------------------------- INICIO RECUPERATIVOS --------------------------- */  --}}
                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionRecuperativoParcial1" name="insCalificacionRecuperativoParcial1[]" value="{{$item->insCalificacionRecuperativoParcial1}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionRecuperativoParcial2" name="insCalificacionRecuperativoParcial2[]" value="{{$item->insCalificacionRecuperativoParcial2}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionRecuperativoParcial3" name="insCalificacionRecuperativoParcial3[]" value="{{$item->insCalificacionRecuperativoParcial3}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionRecuperativoParcial4" name="insCalificacionRecuperativoParcial4[]" value="{{$item->insCalificacionRecuperativoParcial4}}"></td>
                                    {{--  /* ---------------------------- FIN RECUPERATIVOS --------------------------- */  --}}

                                    {{--  /* ------------------------- INICIO EXTRAORDINARIOS ------------------------- */  --}}
                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionExtraOrdinarioParcial1" name="insCalificacionExtraOrdinarioParcial1[]" value="{{$item->insCalificacionExtraOrdinarioParcial1}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionExtraOrdinarioParcial2" name="insCalificacionExtraOrdinarioParcial2[]" value="{{$item->insCalificacionExtraOrdinarioParcial2}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionExtraOrdinarioParcial3" name="insCalificacionExtraOrdinarioParcial3[]" value="{{$item->insCalificacionExtraOrdinarioParcial3}}"></td>

                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionExtraOrdinarioParcial4" name="insCalificacionExtraOrdinarioParcial4[]" value="{{$item->insCalificacionExtraOrdinarioParcial4}}"></td>
                                    {{--  /* --------------------------- FIN EXTRAORDINARIOS -------------------------- */  --}}

                                    {{--  /* -------------------------------- ESPECIAL -------------------------------- */  --}}
                                    <td style="display: none"><input onblur="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" step="0.1" class="noUpperCase" type="number" id="insCalificacionEspecial" name="insCalificacionEspecial[]" value="{{$item->insCalificacionEspecial}}"></td>

                                    <td style="display: none"><input type="text" name="bachiller_cch_inscrito_id[]" id="bachiller_cch_inscrito_id" value="{{$item->id}}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Actulizando datos...";this.form.submit(); alerta();','class' =>
                'btn-large btn-save waves-effect darken-3 btn-guardar','type' => 'submit']) !!}
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
    table th {
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



@include('bachiller.calificaciones_chetumal.funcionesJs')

<script>
    function alerta(){

        var html = "";
        html += "<div class='preloader-wrapper big active'>"+
            "<div class='spinner-layer spinner-blue-only'>"+
              "<div class='circle-clipper left'>"+
                "<div class='circle'></div>"+
              "</div><div class='gap-patch'>"+
                "<div class='circle'></div>"+
              "</div><div class='circle-clipper right'>"+
                "<div class='circle'></div>"+
              "</div>"+
            "</div>"+
          "</div>";

        html += "<p>" + "</p>"

        swal({
            html:true,
            title: "Guardando...",
            text: html,
            showConfirmButton: false
            //confirmButtonText: "Ok",
        })
    }
</script>
{{--  @include('bachiller.calificaciones_chetumal.creamos_listado_alumno')  --}}


@endsection
