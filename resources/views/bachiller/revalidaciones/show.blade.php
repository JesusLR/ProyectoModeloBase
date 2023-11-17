@extends('layouts.dashboard')

@section('template_title')
  Bachiller historico
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_revalidaciones.index')}}" class="breadcrumb">Lista de historial académico (revalidaciones)</a>
    <label class="breadcrumb">Ver historico</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      
        {!! Form::hidden('alumno_id', $historico->alumno_id, ['id' => 'alumno_id']) !!}
        {!! Form::hidden('plan_id', $historico->plan_id, ['id' => 'plan_id']) !!}
        {{--  {!! Form::hidden('periodo_id', $historico->periodo_id, ['id' => 'periodo_id']) !!}  --}}


        <div class="card ">
          <div class="card-content ">
            <span class="card-title">HISTORICO #{{$historico->id}}</span>
            
            <p>
              ({{$historico->aluClave}})
              {{$historico->perNombre}}
              {{$historico->perApellido1}}
              {{$historico->perApellido2}}
            </p>
            <p>
              Período: {{$historico->perNumero}}-{{$historico->perAnio}}
            </p>
            <p>
              ({{$historico->planClave}}) {{$historico->progClave}} {{$historico->progNombre}}
            </p>

            <p>
              Materia: ({{$historico->matClave}}) {{$historico->matNombre}}
            </p>



            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended" style="margin-top: 20px;">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>


            <div id="general">

            
              

                <div class="row">                     

                    <div class="col s12 m6 l4">
                        {!! Form::label('histPeriodoAcreditacion', 'Tipo oficio', ['class' => '']); !!}
                        <input type="text" readonly name="histPeriodoAcreditacion" id="histPeriodoAcreditacion"
                   
                        @if ($historico->histPeriodoAcreditacion == "RV")
                            value="Revalidación"
                        @endif
                        @if ($historico->histPeriodoAcreditacion == "RC")
                            value="Recursamiento"
                        @endif
                        >
    
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('fechaOficio', 'Fecha Oficio/Rec *', ['class' => '']); !!}                       
                        {!! Form::date('fechaOficio', $historico->histFechaExamen, array('id' => 'fechaOficio', 'class' =>'validate', 'readonly')) !!}
                    </div>               
                    
                </div>

                
                
               


            </div>

           
          </div>
        
        </div>
    </div>
  </div>




@endsection

@section('footer_scripts')
@endsection