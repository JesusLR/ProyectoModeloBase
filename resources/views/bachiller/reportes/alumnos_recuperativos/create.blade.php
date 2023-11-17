@extends('layouts.dashboard')

@section('template_title')
    Reporte
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Reporte de alumnos recuperativos</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_alumnos_recuperativos.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REPORTE DE ALUMNOS INSCRITOS A RECUPERATIVOS</span>

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
                      {!! Form::label('tipoReporte', 'Vista de reporte *', array('class' => '')); !!}
                      <select id="tipoReporte" data-departamento-id="{{old('tipoReporte')}}"
                        class="browser-default validate select2" required name="tipoReporte" style="width: 100%;">
                        <option value="1">EXCEL</option>
                        <option value="2">PDF</option>
                      </select>
                    </div>
                  </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $selected = '';

                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                        echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    } else {
                                        if ($ubicacion->id == old("ubicacion_id")) {
                                            $selected = 'selected';
                                        }

                                        echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-periodo-id="{{old('periodo_id')}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                  
                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('bachiller_recuperativo_id', NULL, array('id' => 'bachiller_recuperativo_id', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('bachiller_recuperativo_id', 'Folio', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate', 'maxlength'=>10)) !!}
                            {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                        </div>
                    </div>                
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('clave_empleado', NULL, array('id' => 'clave_empleado', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('clave_empleado', 'Clave empleado', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('empApellido1', NULL, array('id' => 'empApellido1', 'class' => 'validate', 'maxlength'=>100)) !!}
                            {!! Form::label('empApellido1', 'Apellido 1 docente', array('class' => '')); !!}
                        </div>
                    </div>              
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('empApellido2', NULL, array('id' => 'empApellido2', 'class' => 'validate', 'maxlength'=>100)) !!}
                            {!! Form::label('empApellido2', 'Apellido 2 docente', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('empNombre', NULL, array('id' => 'empNombre', 'class' => 'validate', 'maxlength'=>100)) !!}
                            {!! Form::label('empNombre', 'Nombre(s) docente', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('fechaExamen', 'Fecha examen', array('class' => '')); !!}
                        {!! Form::date('fechaExamen', NULL, array('id' => 'fechaExamen', 'class' => 'validate', 'maxlength'=>10)) !!}
                    </div>
                </div>

                {{--  <div class="row">                  
                    <div class="col s12 m6 l12">
                        {!! Form::label('recuperativo_id', 'Recuperativo *', array('class' => '')); !!}
                        <input class="validated" type="hidden" data-gpoSemestre-id="{{old('recuperativo_id')}}">
                        <select id="recuperativo_id"
                            data-recuperativo-id="{{old('recuperativo_id')}}"
                            class="browser-default validate select2" required name="recuperativo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>            
                </div>  --}}



          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_todos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')


<script type="text/javascript">

    $(document).ready(function() {


        // OBTENER CGTS POR PLAN ${event.target.value}
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();

            $("#recuperativo_id").empty();
            $("#recuperativo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/reporte/getRecuperativos/bachiller_alumnos_recuperativos/${event.target.value}/${plan_id}/`,function(res,sta){
                res.forEach(element => {
                    if(element.perNombre == null){
                        var nombreDocente = "";
                    }else{
                        var nombreDocente = element.perNombre;
                    }

                    if(element.perApellido1 == null){
                        var apellido1Docente = "";
                    }else{
                        var apellido1Docente = element.perApellido1;
                    }

                    if(element.perApellido2 == null){
                        var apellido2Docente = "";
                    }else{
                        var apellido2Docente = element.perApellido2;
                    }

                    var date = element.extFecha;
                    var separar = date.split("-");
                    var day = separar[2];
                    var month = separar[1];
                    var year = separar[0];
                    var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    if(month == "01" || month == "02" || month == "03" || month == "04" || month == "05" || month == "06" || month == "07" || month == "08" || month == "09"){
                        var newV = month.split("");
                    }
                    var mesString = meses[newV[1]-1];
                    var fechaNueva = `${day}/${mesString}/${year}`;


                    
                    $("#recuperativo_id").append(`<option value=${element.id}>Folio: ${element.id} - Materia: ${element.matClave}-${element.matNombre} - Docente: ${nombreDocente} ${apellido1Docente} ${apellido2Docente} - Fecha examen: ${fechaNueva}</option>`);
                });
            });
        });

        // OBTENER CGTS POR PLAN ${event.target.value}
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();

            $("#recuperativo_id").empty();
            $("#recuperativo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/reporte/getRecuperativos/bachiller_alumnos_recuperativos/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {

                    if(element.perNombre == null){
                        var nombreDocente = "";
                    }else{
                        var nombreDocente = element.perNombre;
                    }

                    if(element.perApellido1 == null){
                        var apellido1Docente = "";
                    }else{
                        var apellido1Docente = element.perApellido1;
                    }

                    if(element.perApellido2 == null){
                        var apellido2Docente = "";
                    }else{
                        var apellido2Docente = element.perApellido2;
                    }

                    var date = element.extFecha;
                    var separar = date.split("-");
                    var day = separar[2];
                    var month = separar[1];
                    var year = separar[0];
                    var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    if(month == "01" || month == "02" || month == "03" || month == "04" || month == "05" || month == "06" || month == "07" || month == "08" || month == "09"){
                        var newV = month.split("");
                    }
                    var mesString = meses[newV[1]-1];
                    var fechaNueva = `${day}/${mesString}/${year}`;

                    $("#recuperativo_id").append(`<option value=${element.id}>Folio: ${element.id} - Materia: ${element.matClave}-${element.matNombre} - Docente: ${nombreDocente} ${apellido1Docente} ${apellido2Docente} - Fecha examen: ${fechaNueva}</option>`);                
                });
            });
        });

     });
</script>



@endsection