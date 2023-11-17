@extends('layouts.dashboard')

@section('template_title')
    Actividad
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('universidad.universidad_actividades.index')}}" class="breadcrumb">Lista de actividades</a>
    <a href="{{ url('actividades/'.$actividad->id) }}" class="breadcrumb">Ver actividad</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ACTIVIDAD #{{$actividad->id}}</span>

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

                <input type="hidden" name="id" id="id" value="{{$actividad->id}}">
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad->ubiClave ."-". $actividad->ubiNombre}}">
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad->depClave.'-'.$actividad->depNombre}}">
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad->escClave.'-'.$actividad->escNombre}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad->perNumero.'-'.$actividad->perAnioPago}}">
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $actividad->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $actividad->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad->progClave.'-'.$actividad->progNombre}}">
                    </div>
                  
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('actGrupo', $actividad->actGrupo, array('id' => 'actGrupo', 'class' => 'validate','maxlength'=>'3', 'required', 'readonly')) !!}
                        {!! Form::label('actGrupo', 'Actividad *', array('class' => '')); !!}
                        </div>
                    </div>


                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('actDescripcion', $actividad->actDescripcion, array('id' => 'actDescripcion', 'class' => 'validate','maxlength'=>'255', 'readonly')) !!}
                        {!! Form::label('actDescripcion', 'Descripción actividad *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actImporte" id="actImporte" step="0.0" value="{{$actividad->actImporte}}" readonly>
                            {!! Form::label('actImporte', 'Cantidad importe de cada pago (en M.N,) *', array('class' => '')); !!}
                        </div>
                    </div>
                  
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actNumeroPagos" id="actNumeroPagos" value="{{$actividad->actNumeroPagos}}" readonly>
                        {!! Form::label('actNumeroPagos', 'Número de pagos durante el período *', array('class' => '')); !!}
                        </div>
                    </div>


                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actCupo" id="actCupo" value="{{$actividad->actCupo}}" readonly>
                        {!! Form::label('actCupo', 'Cupo máximo de inscripciones *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('actividad_id', 'Instrucctor (a) *', array('class' => '')); !!}
                        <input type="text" value="{{$actividad->perApellido1.' '.$actividad->perApellido2.' '.$actividad->perNombre}}" readonly>
                    </div>
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



       

        


    });
</script>



@endsection