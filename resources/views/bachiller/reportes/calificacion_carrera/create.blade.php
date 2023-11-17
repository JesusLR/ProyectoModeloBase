@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Constancia de calificaciones de toda la carrera</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_calificacion_carrera.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Constancia de calificaciones de toda la carrera</span>
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
              {!! Form::label('ubicacion_id', 'Campus', ['class' => '']); !!}
              <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicacion as $ubicacion)
                @php
                $selected = '';

                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'
                </option>';
                } else {
                if ($ubicacion->id == old("ubicacion_id")) {
                $selected = 'selected';
                }

                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                  '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                }
                @endphp
                @endforeach
              </select>
            </div>
            {{--  <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('firmante', 'Firmante', ['class' => '']); !!}
              <select name="firmante" id="firmante" class="browser-default validate select2" required style="width: 100%;">
                <option value="">Seleccionar Firmante</option>
              </select>
            </div>  --}}
            <div class="col s12 m6 l4" style="margin-top:10px;">
              {!! Form::label('leyenda', 'Leyenda a mostrar', ['class' => '']); !!}
              <select name="leyenda" id="leyenda" class="browser-default validate select2" required
                style="width: 100%;">
                <option value="SEMESTRE">SEMESTRE</option>
                <option value="GRADO">GRADO</option>
              </select>
            </div>
           </div>

           <hr>
           
           <div class="row">
              <div class="col s12 m6 l4">
                <div class="col s12 m6 l6">
                  <label for="perNumero">Número*</label>
                  <select name="perNumero" id="perNumero" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="1">1</option>
                    <option value="3">3</option>
                  </select>
                </div>
                <div class="col s12 m6 l6">
                  <label for="perAnio">Año*</label>
                  <select name="perAnio" id="perAnio" class="browser-default validate select2" style="width:100%;" required>
                    @for($i = $anioActual; $i > 1996; $i--)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('aluClave', 'Clave de pago*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <label for="mensaje">¿Desea incluir mensaje certificado en trámite?</label>
                <select name="mensaje" id="mensaje" class="browser-default validate select2" style="width:100%;">
                  <option value="NO">NO</option>
                  <option value="COMPLETO">COMPLETO</option>
                  <option value="PARCIAL">PARCIAL</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula alumno', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
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
  @include('scripts.grupo-semestre')
  
<script type="text/javascript">
$(document).ready(function() {
  $('#ubicacion_id').on('change',function(){
      var ubicacion_id = $(this).val();
      if (ubicacion_id) {
        $.ajax({
        processing : 'true',
        serverSide : 'true',
        url:"calificacion_carrera/cambiarFirmante/"+ubicacion_id,
        method:"POST",
        data : {ubicacion_id:ubicacion_id,"_token":"{{ csrf_token() }}"},
        dataType:"json",
        success:function(data){
          console.log(data);
          $('#firmante').empty();
          $.each(data,function(key,value){
            $('#firmante').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
      }else{
        $('#firmante').empty();
      }
  });
});
</script>
@endsection
