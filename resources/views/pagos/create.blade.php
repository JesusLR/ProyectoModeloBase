@extends('layouts.dashboard')

@section('template_title')
    Referencia de pago
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('pago')}}" class="breadcrumb">Referencia de pago</a>
@endsection

@section('content')
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'pago.store', 'method' => 'POST']) !!}
    <div class="card ">
        <div class="card-content ">
        <span class="card-title">GENERAR REFERENCIA DE PAGO</span>

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
                <input id="curso_id" name="curso_id" value="" type="hidden" />
                <div class="col s12 l3">
                    {!! Form::label('cuoFecha', 'Fecha del día de hoy *', ['class' => '']); !!}
                    <input id="cuoFecha" name="cuoFecha" class="validate" type="date" required value="<?= date("Y-m-d"); ?>">
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave de alumno *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::number('cuoAnio', NULL, array('id' => 'cuoAnio', 'class' => 'validate','maxLength' => '4','required')) !!}
                    {!! Form::label('cuoAnio', 'Año de inicio de curso *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarAlumno','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('ubiNombre', NULL, array('id' => 'ubiNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('ubiNombre', 'Ubicación (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perNumero', 'Periodo (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div>
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('aluNombre', NULL, array('id' => 'aluNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('aluNombre', 'Nombre de alumno (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::number('cuoConcepto', NULL, array('id' => 'cuoConcepto', 'class' => 'validate','required')) !!}
                    {!! Form::label('cuoConcepto', 'Concepto *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarConcepto','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('nomConcepto', NULL, array('id' => 'nomConcepto', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('nomConcepto', 'Nombre de concepto (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('importeNormal', NULL, array('id' => 'importeNormal', 'class' => 'validate','required')) !!}
                    {!! Form::label('importeNormal', 'Importe pago normal *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('importeBeca', NULL, array('id' => 'importeBeca', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('importeBeca', '%Beca (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('convenio', NULL, array('id' => 'convenio', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('convenio', 'Convenio (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 l3">
                    {!! Form::label('cuoFechaVenc', 'Fecha de vencimiento (opcional)', ['class' => '']); !!}
                    <input id="cuoFechaVenc" name="cuoFechaVenc" class="validate" type="date" value="">
                </div>
            </div>

        </div>

        </div>
        <div class="card-action">
        {!! Form::button('<i class="material-icons left">save</i> Generar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('footer_scripts')
    @include('scripts.referencia')
@endsection