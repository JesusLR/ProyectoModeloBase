@extends('layouts.dashboard')

@php use App\Http\Helpers\Utils; @endphp

@section('template_title')
    Calificación
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('grupo')}}" class="breadcrumb">Lista de Grupos</a>
    <a href="" class="breadcrumb">Calificaciones</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'calificacion.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
          <span class="card-title">CALIFICACIONES DEL GRUPO #{{$grupo->id}}</span>
            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#parciales">Parciales</a></li>
                  <li class="tab"><a href="#ordinarios">Ordinarios</a></li>
                </ul>
              </div>
            </nav>

            <br>
            <input id="grupo_id" name="grupo_id" type="hidden" value="{{$grupo->id}}">
            <div class="row">
                <div class="col s12">
                    <span>Programa: <b>{{$grupo->plan->programa->progNombre}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Plan: <b>{{$grupo->plan->planClave}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Materia: <b>{{$grupo->materia->matClave}}-{{$grupo->materia->matNombre}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Curso-Grado-Turno: <b>{{$grupo->gpoSemestre}}-{{$grupo->gpoClave}}-{{$grupo->gpoTurno}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>
                        Docente: <b>{{$grupo->empleado->persona->perNombre}}
                        {{$grupo->empleado->persona->perApellido1}}
                        {{$grupo->empleado->persona->perApellido2}}</b>
                    </span>
                </div>
            </div>
            <div class="row">

                {{-- si estado_act es igual a CA, preguntar mandar mensaje de advertencia por archivos mandados a segey --}}

                <div class="col s12">
                    <span>Estado de grupo: <b>{{Utils::estadoGrupo($grupo->estado_act)}}</b></span>
                    {{-- SOLO SE AGREGA EL BOTÓN ABRIR GRUPO A LOS PERMISOS TIPO A Y B --}}
                    @if ($grupo->estado_act == 'C' && $permiso != 'C' && $permiso != 'D')
                        <a href="{{url('grupo/cambiarEstado/'.$grupo->id.'/B')}}"
                            data-grupo-clave_actv="{{$grupo->clave_actv}}"
                            data-grupo-id="{{$grupo->id}}"
                            class="btn-abrir-grupo waves-effect waves-light btn">
                            Abrir grupo
                        </a>
                    @endif
                </div>
            </div>
            <br>
            <input id="matPorcentajeParcial" type="hidden" value="{{$matPorcentajeParcial}}">
            <input id="matPorcentajeOrdinario" type="hidden" value="{{$matPorcentajeOrdinario}}">
            {{-- GENERAL BAR--}}
            <div id="parciales">
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-parciales" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Clave alumno</th>
                                <th>Nombre alumno</th>
                                <th>Pa1</th>
                                <th>Fa1</th>
                                <th>Pa2</th>
                                <th>Fa2</th>
                                @if($TERCER_PARCIAL)
                                <th>Pa3</th>
                                <th>Fa3</th>
                                @endif
                                <th>ProPar</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $consecutivo=1;
                                    $tabindexP1=100;
                                    $tabindexP2=200;
                                    if ($TERCER_PARCIAL) {
                                        $tabindexP3=300;
                                        $tabindexPR=400;
                                        $tabindexOR=500;
                                    } else {
                                        $tabindexPR=300;
                                        $tabindexOR=400;
                                    }
                                @endphp

                                @foreach ($inscritos as $inscrito)
                                <tr>
                                    <td>{{$consecutivo}}</td>
                                    <td>{{$inscrito->curso->alumno->aluClave}}</td>
                                    <td>
                                        {{$inscrito->curso->alumno->persona->perApellido1 . ' ' .
                                        $inscrito->curso->alumno->persona->perApellido2  . ' ' .
                                        $inscrito->curso->alumno->persona->perNombre}}
                                    </td>
                                    @if($grupo->materia->matTipoAcreditacion == 'N')
                                        <td>
                                            <input tabindex='{{$tabindexP1}}'
                                                name="calificaciones[inscCalificacionParcial1][{{$inscrito->id}}]"
                                                type="number" class="calif parcial{{$inscrito->id}}" min="0" max="100"
                                                <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>
                                                value="{{$inscrito->calificacion->inscCalificacionParcial1}}"
                                                data-inscritoid="{{$inscrito->id}}">
                                        </td>

                                        <td>
                                            <input tabindex='{{$tabindexP1}}'
                                                name="calificaciones[inscFaltasParcial1][{{$inscrito->id}}]"
                                                type="number" class="calif" min="0" max="100"
                                                <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>
                                                value="{{$inscrito->calificacion->inscFaltasParcial1}}">
                                        </td>

                                        <td>
                                            <input tabindex='{{$tabindexP2}}'
                                                name="calificaciones[inscCalificacionParcial2][{{$inscrito->id}}]"
                                                type="number" class="calif parcial{{$inscrito->id}}" min="0" max="100"
                                                   @php
                                                       if($grupo->estado_act == 'C'){
                                                           if($inscrito->calificacion->inscCalificacionParcial1 == null){
                                                               echo 'hidden';
                                                           }else{
                                                               echo 'readonly  onfocus="this.blur()"';
                                                           }
                                                       }
                                                   @endphp
                                                value="{{$inscrito->calificacion->inscCalificacionParcial2}}"
                                                data-inscritoid="{{$inscrito->id}}">
                                        </td>

                                        <td>
                                            <input tabindex='{{$tabindexP2}}'
                                                name="calificaciones[inscFaltasParcial2][{{$inscrito->id}}]"
                                                type="number" class="calif" min="0" max="100"
                                                   @php
                                                       if($grupo->estado_act == 'C'){
                                                           if($inscrito->calificacion->inscCalificacionParcial1 == null){
                                                               echo 'hidden';
                                                           }else{
                                                               echo 'readonly  onfocus="this.blur()"';
                                                           }
                                                       }
                                                   @endphp
                                                value="{{$inscrito->calificacion->inscFaltasParcial2}}">
                                        </td>
                                        @if($TERCER_PARCIAL)
                                        <td>
                                            <input tabindex='{{$tabindexP3}}'
                                                name="calificaciones[inscCalificacionParcial3][{{$inscrito->id}}]"
                                                type="number" class="calif parcial{{$inscrito->id}}" min="0" max="100"
                                                   @php
                                                       if($grupo->estado_act == 'C'){
                                                           if($inscrito->calificacion->inscCalificacionParcial2 == null){
                                                               echo 'hidden';
                                                           }else{
                                                               echo 'readonly  onfocus="this.blur()"';
                                                           }
                                                       }
                                                   @endphp
                                                value="{{$inscrito->calificacion->inscCalificacionParcial3}}"
                                                data-inscritoid="{{$inscrito->id}}">
                                        </td>

                                        <td>
                                            <input tabindex='{{$tabindexP3}}'
                                            name="calificaciones[inscFaltasParcial3][{{$inscrito->id}}]"
                                            type="number" class="calif" min="0" max="100"
                                                   @php
                                                       if($grupo->estado_act == 'C'){
                                                           if($inscrito->calificacion->inscCalificacionParcial2 == null){
                                                               echo 'hidden';
                                                           }else{
                                                               echo 'readonly  onfocus="this.blur()"';
                                                           }
                                                       }
                                                   @endphp
                                            value="{{$inscrito->calificacion->inscFaltasParcial3}}">
                                        </td>
                                        @endif

                                        <td>
                                            <input tabindex='{{$tabindexPR}}'
                                                name="calificaciones[inscPromedioParciales][{{$inscrito->id}}]"
                                                id="inscPromedioParciales{{$inscrito->id}}"
                                                type="text" min="0" max="100" readonly  onfocus="this.blur()"
                                                value="{{$inscrito->calificacion->inscPromedioParciales}}">
                                        </td>
                                        @php
                                            $tabindexP1++;
                                            $tabindexP2++;
                                            if($TERCER_PARCIAL) $tabindexP3++;
                                            $tabindexPR++;
                                            $tabindexOR++;
                                        @endphp
                                    @else
                                        <td>
                                            <select name="calificaciones[inscCalificacionParcial1][{{$inscrito->id}}]" <?= ($grupo->estado_act == 'C') ? 'readonly onfocus="this.blur()"' : '' ?>>
                                                <option value="" selected>SELECCIONA</option>
                                                <option value="0" @if($inscrito->calificacion->inscCalificacionParcial1 == "0") {{ 'selected' }} @endif>APROBADO</option>
                                                <option value="1" @if($inscrito->calificacion->inscCalificacionParcial1 == "1") {{ 'selected' }} @endif>REPROBADO</option>
                                            </select>
                                        </td>
                                        <td><input name="calificaciones[inscFaltasParcial1][{{$inscrito->id}}]" type="number" min="0" max="100" onKeyPress="if(this.value.length==3) return false;" <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?> value="{{$inscrito->calificacion->inscFaltasParcial1}}"></td>
                                        <td>
                                            <select name="calificaciones[inscCalificacionParcial2][{{$inscrito->id}}]" <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>>
                                                <option value="" selected>SELECCIONA</option>
                                                <option value="0" @if($inscrito->calificacion->inscCalificacionParcial2 == "0") {{ 'selected' }} @endif>APROBADO</option>
                                                <option value="1" @if($inscrito->calificacion->inscCalificacionParcial2 == "1") {{ 'selected' }} @endif>REPROBADO</option>
                                            </select>
                                        </td>
                                        <td><input name="calificaciones[inscFaltasParcial2][{{$inscrito->id}}]" type="number" min="0" max="100" onKeyPress="if(this.value.length==3) return false;" <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?> value="{{$inscrito->calificacion->inscFaltasParcial2}}"></td>
                                        @if($TERCER_PARCIAL)
                                        <td>
                                            <select name="calificaciones[inscCalificacionParcial3][{{$inscrito->id}}]" <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>>
                                                <option value="" selected>SELECCIONA</option>
                                                <option value="0" @if($inscrito->calificacion->inscCalificacionParcial3 == "0") {{ 'selected' }} @endif>APROBADO</option>
                                                <option value="1" @if($inscrito->calificacion->inscCalificacionParcial3 == "1") {{ 'selected' }} @endif>REPROBADO</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="calificacione2s[inscFaltasParcial3][{{$inscrito->id}}]"
                                            type="number" class="calif" min="0" max="100"  <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>
                                            value="{{$inscrito->calificacion->inscFaltasParcial3}}"></td>
                                            @endif
                                        <td>
                                        </td>
                                    @endif
                                </tr>
                                    @php
                                        $consecutivo++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- GENERAL BAR--}}
            <div id="ordinarios">
                    <div class="row">
                        <div class="col s12">
                            <table id="tbl-ordinarios" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clave alumno</th>
                                    <th>Nombre alumno</th>
                                    <th>Promedio parciales ({{$matPorcentajeParcial}}%)</th>
                                    <th>Ordinario ({{$matPorcentajeOrdinario}}%)</th>
                                    <th>Final</th>
                                    <th>Inasistencia</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $consecutivo=1; @endphp
                                    @foreach ($inscritos as $inscrito)
                                    <tr>
                                        <td>{{$consecutivo}}</td>
                                        <td>{{$inscrito->curso->alumno->aluClave}}</td>
                                        <td>{{$inscrito->curso->alumno->persona->perApellido1.' '.$inscrito->curso->alumno->persona->perApellido2.' '.$inscrito->curso->alumno->persona->perNombre}}</td>
                                        @if($grupo->materia->matTipoAcreditacion == 'N')
                                            <td><input id="inscPromedioParciales2{{$inscrito->id}}" type="text" readonly  onfocus="this.blur()" value="{{$inscrito->calificacion->inscPromedioParciales}}"></td>
                                            <td>
                                                <input tabindex='{{$tabindexOR}}' id="inscCalificacionOrdinario{{$inscrito->id}}"
                                                
                                                    name="calificaciones[inscCalificacionOrdinario][{{$inscrito->id}}]"
                                                    type="number" min="0" max="100"
                                                    value="{{$inscrito->calificacion->inscCalificacionOrdinario}}"
                                                    onfocusout="calcularPromedioFinal({{$inscrito->id}})">
                                            </td>
                                            <td>
                                                @if (!is_null($inscrito->calificacion->inscCalificacionOrdinario))
                                                    <input id="incsCalificacionFinal{{$inscrito->id}}"
                                                        name="calificaciones[incsCalificacionFinal][{{$inscrito->id}}]"
                                                        type="text" min="0" max="100" readonly  onfocus="this.blur()" value="{{$inscrito->calificacion->incsCalificacionFinal}}">
                                                @else
                                                    <input id="incsCalificacionFinal{{$inscrito->id}}"
                                                        name="calificaciones[incsCalificacionFinal][{{$inscrito->id}}]"
                                                        type="text" min="0" max="100" readonly  onfocus="this.blur()" value="">
                                                @endif
                                            </td>
                                        @else
                                            <td>
                                                <input type="hidden" name="calificaciones[inscPromedioParciales][{{$inscrito->id}}]" readonly  onfocus="this.blur()" value="0">
                                            </td>
                                            <td>
                                            {{-- <input name="calificaciones[inscCalificacionOrdinario][{{$inscrito->id}}]"
                                                    id="inscCalificacionOrdinario{{$inscrito->id}}"
                                                    type="number" min="0" max="1" onfocusout="calcularPromedioFinalApr({{$inscrito->id}})"
                                                    value="{{$inscrito->calificacion->inscCalificacionOrdinario}}"> --}}




                                                <select name="calificaciones[inscCalificacionOrdinario][{{$inscrito->id}}]" >
                                                    <option value="" selected >SELECCIONA</option>
                                                    <option value="0" @if($inscrito->calificacion->inscCalificacionOrdinario == "0") {{ 'selected' }} @endif>APROBADO</option>
                                                    <option value="1" @if($inscrito->calificacion->inscCalificacionOrdinario == "1") {{ 'selected' }} @endif>REPROBADO</option>
                                                </select>
                                            </td>
                                            <td>
                                                    <input name="calificaciones[incsCalificacionFinal][{{$inscrito->id}}]"
                                                        id="incsCalificacionFinal{{$inscrito->id}}"
                                                        type="number" min="0" max="1"
                                                        readonly  onfocus="this.blur()"
                                                        value="{{$inscrito->calificacion->incsCalificacionFinal}}">
                                            </td>
                                        @endif
                                        <td>
                                            @if($grupo->materia->matTipoAcreditacion == 'N')
                                                @if (!is_null($inscrito->calificacion->inscPromedioParciales))
                                                    <select name="calificaciones[inscMotivoFalta][{{$inscrito->id}}]" <?= ($grupo->estado_act == 'C') ? 'readonly  onfocus="this.blur()"' : '' ?>>
                                                        @foreach ($motivosFalta as $item)
                                                            <option value="{{$item->id}}" {{$inscrito->calificacion->motivofalta_id == $item->id ? "selected": ""}}>{{$item->mfDescripcion}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @php $consecutivo++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

          </div>
          <div class="card-action">
                @if (!Utils::validaPermiso('grupo', $grupo->plan->programa_id))
                    @if($grupo->estado_act != 'C')
                        {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                    @endif
                @endif
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('scripts.calificacion')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-parciales').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "dom": '"top"i',
            "ordering": false,
            "bPaginate": false,
            "order": [
                [2, 'asc']
            ]
        });
        $('#tbl-ordinarios').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "dom": '"top"i',
            "ordering": false,
            "bPaginate": false,
            "order": [
                [2, 'asc']
            ]
        });
    });
</script>



<script type="text/javascript">
    $(document).on("click", ".btn-abrir-grupo", function(e) {
        e.preventDefault()

        var grupoId   = $(this).data("grupo-id");
        var claveActv = $(this).data("grupo-clave_actv");



        console.log(base_url + "grupo/cambiarEstado/" + grupoId + "/B")


        if (claveActv === "CA") {
            swal({
                title: "Abrir grupo",
                text: "Se mandaron archivos de la SEP para este grupo, ¿Está seguro que desea continuar?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = base_url + "/grupo/cambiarEstado/" + grupoId + "/B";
                }

                swal.close()
            });
        } else {
            window.location.href = base_url + "/grupo/cambiarEstado/" + grupoId + "/B";
        }
    })


        // disable mousewheel on a input number field when in focus
    // (to prevent Cromium browsers change the value when scrolling)
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault()
        })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll')
    })
</script>


@endsection
