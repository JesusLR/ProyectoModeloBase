@extends('layouts.dashboard')

@section('template_title')
    Bachiller porcentaje
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_porcentaje.index')}}" class="breadcrumb">Lista de porcentajes</a>
    <a href="{{url('bachiller_porcentaje/'.$porcentajes->id)}}" class="breadcrumb">Editar porcentaje</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_porcentaje.update', $porcentajes->id])) }}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">PORCENTAJE #{{$porcentajes->id}}</span>

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
                            <input type="text" readonly="true" value="{{$ubicacion->ubiNombre}}">                            
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <input type="text" readonly="true" value="{{$departamento->depNombre}}">                            

                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <input type="text" readonly="true" value="{{$escuela->escClave}}-{{$escuela->escNombre}}">                            

                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <input type="text" readonly="true" value="{{$periodo->perNumero}}-{{$periodo->perAnioPago}}">                            

                        </div>
                        <div class="col s12 m6 l4">                             
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            <input type="text" readonly="true" value="{{$periodo->perFechaInicial}}">                            

                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">                               
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                                <input type="text" readonly="true" value="{{$periodo->perFechaFinal}}">                        

                            </div>
                        </div>
                    </div>
              

                    <p>Primer período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_septiembre">Porcentaje septiembre *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_septiembre}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_octubre">Porcentaje octubre *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_octubre}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_noviembre">Porcentaje noviembre *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_noviembre}}">
                            </div>
                        </div>
                    </div>

                    <p>Segundo período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_enero">Porcentaje enero *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_enero}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_febrero">Porcentaje febrero *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_febrero}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_marzo">Porcentaje marzo *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_marzo}}">
                            </div>
                        </div>
                    </div>

                    <p>Tercer período</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_abril">Porcentaje abril *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_abril}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_mayo">Porcentaje mayo *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_mayo}}">
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="porc_junio">Porcentaje junio *</label>
                                <input type="text" readonly="true" value="{{$porcentajes->porc_junio}}">
                            </div>
                        </div>
                    </div>


                </div>

                
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
@include('bachiller.scripts.planes')
@include('bachiller.scripts.periodos')
@include('bachiller.scripts.cgts')
@include('bachiller.scripts.cursos')




@endsection
