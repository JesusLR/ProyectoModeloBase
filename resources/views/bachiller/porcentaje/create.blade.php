@extends('layouts.dashboard')

@section('template_title')
    Bachiller porcentaje
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_porcentaje.index')}}" class="breadcrumb">Lista de porcentajes</a>
    <a href="{{route('bachiller.bachiller_porcentaje.create')}}" class="breadcrumb">Agregar porcentaje</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_porcentaje.store', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR PORCENTAJE</span>

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
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
              

                    <p>Primer período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_septiembre">Porcentaje septiembre *</label>
                                <input type="number" id="porc_septiembre" name="porc_septiembre" value="{{old('porc_septiembre')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_octubre">Porcentaje octubre *</label>
                                <input type="number" id="porc_octubre" name="porc_octubre" value="{{old('porc_octubre')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_noviembre">Porcentaje noviembre *</label>
                                <input type="number" id="porc_noviembre" name="porc_noviembre" value="{{old('porc_noviembre')}}"  min="0" max="100">
                            </div>
                        </div>
                    </div>

                    <p>Segundo período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_enero">Porcentaje enero *</label>
                                <input type="number" id="porc_enero" name="porc_enero" value="{{old('porc_enero')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_febrero">Porcentaje febrero *</label>
                                <input type="number" id="porc_febrero" name="porc_febrero" value="{{old('porc_febrero')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_marzo">Porcentaje marzo *</label>
                                <input type="number" id="porc_marzo" name="porc_marzo" value="{{old('porc_marzo')}}"  min="0" max="100">
                            </div>
                        </div>
                    </div>

                    <p>Tercer período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_abril">Porcentaje abril *</label>
                                <input type="number" id="porc_abril" name="porc_abril" value="{{old('porc_abril')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_mayo">Porcentaje mayo *</label>
                                <input type="number" id="porc_mayo" name="porc_mayo" value="{{old('porc_mayo')}}"  min="0" max="100">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_junio">Porcentaje junio *</label>
                                <input type="number" id="porc_junio" name="porc_junio" value="{{old('porc_junio')}}"  min="0" max="100">
                            </div>
                        </div>
                    </div>


                </div>

                
            </div>


            <div class="card-action">
                <button class="btn-large btn-save waves-effect darken-3" type="submit"><i class="material-icons left">save</i>Guardar</button>
               
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

  <style>
    * {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-size: 16px;
        background: #fff;
        font-family: "Roboto";
    }
    
    .wrap {
        width: 90%;
        max-width: 1000px;
        margin: 0 20px;
        /*margin: auto;*/
    }
    
    .formulario h2 {
        font-size: 16px;
        color: #001F3F;
        margin-bottom: 20px;
        margin-left: 20px;
    }
    
    .formulario > div {
        padding: 20px 0;
        border-bottom: 1px solid #ccc;
    }
  </style>
@endsection

@section('footer_scripts')


@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')
@include('bachiller.scripts.cgts')
@include('bachiller.scripts.cursos')




@endsection
