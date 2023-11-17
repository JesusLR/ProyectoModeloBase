@extends('layouts.dashboard')

@section('template_title')
    Bachiller migrar inscritos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Migrar inscritos</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_migrar_inscritos_acd.store', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">MIGRAR INSCRITOS</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">datos de origen</a></li>
                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR--}}
                <div id="general">

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                $selected = '';
                                if($ubicacion->id == $ubicacion_id){
                                $selected = 'selected';
                                }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>      
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>                  
                    </div>


                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                            <select id="gpoGrado" class="browser-default validate select2" required name="gpoGrado" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('grupo_origen_id', 'Grupo Origen *', array('class' => '')); !!}
                            <select id="grupo_origen_id" class="browser-default validate select2" required name="grupo_origen_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                
                            </select>
                        </div>
                        
                    </div>

                    <br>
                    <span class="card-title"><b>SELECCIONE EL GRUPO DESTINO</b></span>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id_destino', 'Periodo destino *', array('class' => '')); !!}
                            <select id="periodo_id_destino" class="browser-default validate select2" required name="periodo_id_destino"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('gpoGrado_destino', 'Grado destino*', array('class' => '')); !!}
                            <select id="gpoGrado_destino" class="browser-default validate select2" required name="gpoGrado_destino"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>                        

                        <div class="col s12 m6 l4">
                            {!! Form::label('grupo_id_destino', 'Grupo ACD destino *', array('class' => '')); !!}
                            <select id="grupo_id_destino" class="browser-default validate select2" required name="grupo_id_destino"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                </div>
                


                <br>
                <br>
                <div class="row" id="Tabla" style="display: none;">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                </div>

            </div>

            

            <div class="card-action">             
                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar-migracion-acd btn-large waves-effect  darken-3']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
<style>
    table tbody tr:nth-child(odd) {
        background: #E5E3E3;
    }

    table tbody tr:nth-child(even) {
        background: #F0ECEB;
    }

    table th {
        background: #01579B;
        color: #fff;

    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
    
      
    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
        border-color: #01579B;
        background-color: #01579B;
    }      

      
</style>

@section('footer_scripts')


{{--  @include('bachiller.scripts.migrarinscritosACD2')  --}}
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.migrarIncritosACD.guardadoDeMigracion')
@include('bachiller.migrarIncritosACD.obtenerGrupoOrigen')
@include('bachiller.migrarIncritosACD.obtenerGrupoDestino')
@include('bachiller.migrarIncritosACD.crearTable')


<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#gpoGrado").empty();
            $("#gpoGrado").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#gpoGrado").data("gpoGrado-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#gpoGrado").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    });
</script>


@endsection
