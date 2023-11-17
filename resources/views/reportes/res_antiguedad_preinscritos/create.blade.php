@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de Antiguedad de preinscritos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/res_antiguedad_preinscritos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de Antiguedad de preinscritos</span>
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
              <div class="col s12 m6 l6">
                {!! Form::label('ubicacion', 'Ubicación *', ['class' => '',]); !!}
                <select name="ubicacion" id="ubicacion" class="browser-default validate select2" style="width: 100%;">
                  @foreach ($ubicacion as $item)
                   <option value="{{$item->id}}">{{$item->ubiClave}} - {{$item->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l6">
                {!! Form::label('departamento', 'Departamento *', ['class' => '',]); !!}
                <select name="departamento" id="departamento" class="browser-default validate select2" style="width: 100%;">
                  <option value="" disabled>Seleccionar departamento</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('periodo', 'Periodo *', ['class' => '',]); !!}
                <select name="periodo" id="periodo" class="browser-default validate select2" style="width: 100%;">
                  <option value="" disabled>Seleccionar periodo</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaInicial', NULL, array('id' => 'fechaInicial', 'readonly')) !!}
                  {!! Form::label('fechaInicial', 'Fecha Inicial', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaFinal', NULL, array('id' => 'fechaFinal','readonly')) !!}
                  {!! Form::label('fechaFinal', 'Fecha Final', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('primerIngreso', 'Primer Ingreso o Todos *', ['class' => '',]); !!}
                <select name="primerIngreso" id="primerIngreso" class="browser-default validate select2" style="width: 100%;">
                  <option value="todos" selected>Todos</option>
                  <option value="primer">Primer Ingreso</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('tipoReporte', 'Tipo de reporte *', ['class' => '',]); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                  <option value="resumen" selected>Resumen</option>
                  <option value="detalle">Detalle</option>
                </select>
              </div>
           </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript">
$(document).ready(function(){
    function obtenerDepartamento(ubicacion_id){
      $.get(base_url+`/obtenerDepartamento/${ubicacion_id}`,function(data){
        $('#departamento').empty();
        $.each(data['departamentos'],function(key,value){
          $('#departamento').append('<option value="'+value.id+'">'+value.depClave+' - '+value.depNombre+'</option>');
        });
        obtenerPeriodos($('#departamento').val());
      });
    }

    function obtenerPeriodos(departamento_id){
      $.get(base_url+`/obtenerPeriodos/${departamento_id}`,function(data){
        $('#periodo').empty();
        $.each(data,function(key,value){
          $('#periodo').append('<option value="'+value.id+'">'+value.perNumero+'-'+value.perAnio+'</option>');
        });
        obtenerFechas($('#periodo').val())
      });
    }

    function obtenerFechas(periodo_id){
      $.get(base_url+`/obtenerFechas/${periodo_id}`,function(data){
        $('#fechaInicial').empty();
        $('#fechaFinal').empty();
        $('#fechaInicial').val(data['fechaInicial']);
        $('#fechaFinal').val(data['fechaFinal']);
        Materialize.updateTextFields();
      });
    }
  // Rellenar los datos al entrar a la vista
  obtenerDepartamento($('#ubicacion').val());
  
  // Rellenar los datos al escoger una opción
  $('#ubicacion').change(function(){
    var ubicacion_id = $(this).val();
    obtenerDepartamento(ubicacion_id);
  });

  $('#departamento').change(function(){
    var departamento_id = $(this).val();
    obtenerPeriodos(departamento_id);
  })

  $('#periodo').change(function(){
    var periodo_id = $(this).val();
    obtenerFechas(periodo_id);
  });
});
</script>

@endsection