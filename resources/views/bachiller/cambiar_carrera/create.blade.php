@extends('layouts.dashboard')

@section('template_title')
    Bachiler cambiar cgt 
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Preinscritos</a>
    <label class="breadcrumb">Cambiar CGT</label>
@endsection

@section('content')



<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => "bachiller_cambiar_cgt_preinscrito/{$curso_id}/cambiar", 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">Cambiar de CGT => <b>{{$alumno_curso}}</b></span>

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
                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="ubicacion_id">Ubicacion*</label>
                                <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion->id}}" id="ubicacion_id" name="ubicacion_id" style="width:100%;" required disabled>
                                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="departamento_id">Departamento*</label>
                                <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id') ?: $departamento->id}}" id="departamento_id" name="departamento_id" style="width:100%;" required disabled>
                                    <option value="{{$departamento->id}}">{{$departamento->depClave.'-'.$departamento->depNombre}}</option>
                                </select>
                            </div>          
                            <div class="col s12 m6 l4">
                                <label for="escuela_id">Escuela*</label>
                                <select disabled class="browser-default validate select2" data-escuela-id="{{old('escuela_id') ?: $escuela->id}}" id="escuela_id" name="escuela_id" style="width:100%;" required>
                                    <option value="{{$escuela->id}}">{{$escuela->escClave.'-'.$escuela->escNombre}}</option>
                                </select>
                            </div>                  
                        </div>

                        <div class="row">
                            
                            <div class="col s12 m6 l4">
                                <label for="periodo_id">Periodo*</label>
                                <select class="browser-default validate select2 busqueda-cgt" data-periodo-id="{{old('periodo_id') ?: $periodo->id}}" id="periodo_id" name="periodo_id" style="width:100%;" required disabled>
                                    <option value="{{$periodo->id}}">{{$periodo->perNumero.'-'.$periodo->perAnio}}</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="programa_id">Programa*</label>
                                <select class="browser-default validate select2" data-programa-id="{{old('programa_id') ?: $programa->id}}" id="programa_id" name="programa_id" style="width:100%;" required>
                                    <option value="{{$programa->id}}">{{$programa->progClave.'-'.$programa->progNombre}}</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="col s12 m6 l6">
                                    <label for="plan_id">Plan*</label>
                                    <select class="browser-default validate select2 busqueda-cgt" data-plan-id="{{old('plan_id') ?: $plan->id}}" id="plan_id" name="plan_id" style="width:100%;" required>
                                        <option value="{{$plan->id}}">{{$plan->planClave}}</option>
                                    </select>
                                </div>
                                <div class="col s12 m6 l6">
                                    <label for="cgt_id">Cgt*</label>
                                    <select class="browser-default validate select2" data-cgt-id="{{old('cgt_id') ?: $cgt_actual}}" id="cgt_id" name="cgt_id" style="width:100%;">
                                        <option value="">SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>


@endsection

@section('footer_scripts')

<script>
    let periodo_id = $('#periodo_id').data('periodo-id');
    let plan_id = $('#plan_id').data('plan-id');
    let cgt_id = $('#plan_id').data('plan-id');
    let leyenda = "";

    $.get(base_url+`/bachiller_cgt/api/cgts/${plan_id}/${periodo_id}`, function(res,sta) {

        //seleccionar el post preservado
        var cgt_id_old = $("#cgt_id").data("cgt-id")
        $("#cgt_id").empty()
        res.forEach(element => {
            var selected = "";
            if (element.id === cgt_id_old) {
                console.log("entra")
                console.log(element.id)
                selected = "selected";

                leyenda = "(ACTUAL)";
            }else{
                leyenda = "";
            }

            $("#cgt_id").append(`<option value=${element.id} ${selected}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno} ${leyenda}</option>`);

            
        });
        $('#cgt_id').trigger('change'); // Notify only Select2 of changes
    });

</script>

@endsection