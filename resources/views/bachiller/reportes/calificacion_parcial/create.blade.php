@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Constancia de calificaciones parciales</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_calificacion_parcial.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Constancia de calificaciones parciales</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="filtros">

           <div class="row">
            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('ubicacion_id', 'Campus*', ['class' => '']); !!}
              <select name="ubicacion_id" id="ubicacion_id" required class="browser-default validate select2" style="width: 100%;">
                <option value="">Seleccionar Ubicación</option>
                @foreach ($ubicacion as $item)
                <option value="{{$item->id}}">{{$item->ubiNombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('leyenda', 'Leyenda *', ['class' => '']); !!}
              <select name="leyenda" required id="leyenda" class="browser-default validate select2" style="width: 100%;">
                <option value="SEMESTRE">SEMESTRE</option>
                <option value="GRADO">GRADO</option>

              </select>
            </div>
           </div>


           <div class="row">
              <div class="col s12 m6 l4">
                <label for="perNumero">Número de periodo*</label>
                  <select name="perNumero" id="perNumero" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="1">1</option>
                    <option value="3">3</option>
                  </select>                  
              </div>
              <div class="col s12 m6 l4">
                <label for="perAnio">Año*</label>
                <select name="perAnio" id="perAnio" class="browser-default validate select2" style="width:100%;" required>
                  @for($i = $anioActual; $i > 1996; $i--)
                    <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('aluClave', 'Clave de pago*', array('class' => '')); !!}
                </div>
              </div>
            </div>
  
            
         
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
  @include('bachiller.scripts.grupo-semestre')
  

@endsection

