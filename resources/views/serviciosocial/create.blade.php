@extends('layouts.dashboard')

@section('template_title')
	Servicio Social
@endsection

@section('head')
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="{{url('serviciosocial')}}" class="breadcrumb">Lista de Servicio Social</a>
	<label class="breadcrumb">Agregar Serv. Social</label>
@endsection

@section('content')
<div class="row">
	<div class="col s12">
		{!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'serviciosocial.store', 'method' => 'POST']) !!}
		<div class="card">
			<div class="card-content">
				<span class="card-title">AGREGAR SERVICIO SOCIAL</span>
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
                        <div class="col s12 m4">
                            <input type="text" placeholder="Buscar por: Clave alumno" id="aluClave" value="{{old('aluClave')}}" type="text" name="aluClave" style="width: 100%;" />
                        </div>
                        <div class="col s12 m4">
                            <input type="text" placeholder="Buscar por: Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" type="text" name="nombreAlumno" style="width: 100%;" />
                        </div>
                        <div class="col s12 m4">
                                <button class="btn-large waves-effect darken-3 btn-buscar-alumno">
                                    <i class="material-icons left">search</i>
                                    Buscar
                                </button>
                        </div>
                </div>
                
                <div class="row">
                    <div class="col s12 m12 l12">
                        {!! Form::label('resumen_id', 'Alumno *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="resumen_id" class="browser-default validate select2" required name="resumen_id" style="width: 100%;">
                                <option value="" disabled>RESULTADOS DE BUSQUEDA</option>
                            </select>
                           
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('progClave', 'Clave de Programa *', array('class' => '')); !!}
                        </div>
                    </div> --}}
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssLugar', NULL, array('id' => 'ssLugar', 'class' => 'validate','required')) !!}
                            {!! Form::label('ssLugar', 'Lugar *', array('class' => '')); !!}
                        </div>
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <label for="alcance_regional">Alcance regional*</label>
                        <select class="browser-default validate select2" name="alcance_regional" id="alcance_regional" data-alcance-regional="{{old('alcance_regional')}}" style="width:100%;" required>
                            <option value="municipal">Municipal</option>
                            <option value="estatal">Estatal</option>
                            <option value="federal">Federal</option>
                        </select>
                    </div> --}}
                    <div class="col s12 m6 l4">
                        <br>
                        {!! Form::label('ssClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach($clasificacion as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssDireccion', NULL, array('id' => 'ssDireccion', 'class' => 'validate')) !!}
                            {!! Form::label('ssDireccion', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssTelefono', NULL, array('id' => 'ssTelefono', 'class' => 'validate','maxlength' => '30')) !!}
                            {!! Form::label('ssTelefono', 'Telefono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssJefeSuperior', NULL, array('id' => 'ssJefeSuperior', 'class' => 'validate')) !!}
                            {!! Form::label('ssJefeSuperior', 'Jefe Superior', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<p style="text-align:center;">Horarios</p>
                	<br>
                	<div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioLunes', NULL, array('id' => 'ssHorarioLunes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioLunes', 'Lunes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMartes', NULL, array('id' => 'ssHorarioMartes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMartes', 'Martes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMiercoles', NULL, array('id' => 'ssHorarioMiercoles', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMiercoles', 'Miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioJueves', NULL, array('id' => 'ssHorarioJueves', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioJueves', 'Jueves', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioViernes', NULL, array('id' => 'ssHorarioViernes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioViernes', 'Viernes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioSabado', NULL, array('id' => 'ssHorarioSabado', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioSabado', 'Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioDomingo', NULL, array('id' => 'ssHorarioDomingo', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioDomingo', 'Domingo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                	{{-- <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;">
                        	<option value="" selected disabled>Seleccione una opción</option>
                            @foreach($clasificacion as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col s12 m6 l4">
                    	<br>
                            {!! Form::label('ssFechaInicio', 'Fecha de Inicio', array('class' => '')); !!}
                            {!! Form::date('ssFechaInicio', NULL, array('id' => 'ssFechaInicio', 'class' => 'validate','required')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Inicio</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoInicio', NULL, array('id' => 'ssNumeroPeriodoInicio', 'class' => 'validate','required','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoInicio', 'Número *', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoInicio', NULL, array('id' => 'ssAnioPeriodoInicio', 'class' => 'validate','required','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoInicio', 'Año *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        <div class="input-field">
                            {!! Form::text('ssNumeroAsignacion', NULL, array('id' => 'ssNumeroAsignacion', 'class' => 'validate','maxlength'=>'8')) !!}
                            {!! Form::label('ssNumeroAsignacion', 'Número de asignación ', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <br>
                            {!! Form::label('ssFechaLiberacion', 'Fecha de Liberación', array('class' => '')); !!}
                            {!! Form::date('ssFechaLiberacion', NULL, array('id' => 'ssFechaLiberacion', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Liberación</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoLiberacion', NULL, array('id' => 'ssNumeroPeriodoLiberacion', 'class' => 'validate','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoLiberacion', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoLiberacion', NULL, array('id' => 'ssAnioPeriodoLiberacion', 'class' => 'validate','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoLiberacion', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssEstadoActual', 'Estado Actual *', array('class' => '')); !!}
                        <select id="ssEstadoActual" class="browser-default validate select2" required name="ssEstadoActual" style="width: 100%;">
                            @foreach($estadoActual as $key => $value)
                                @if($key == 'A')
                                    <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte1', 'Reporte 1', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte1', NULL, array('id' => 'ssFechaReporte1', 'class' => 'validate')) !!}
                        </div>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte2', 'Reporte 2', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte2', NULL, array('id' => 'ssFechaReporte2', 'class' => 'validate')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte3', 'Reporte 3', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte3', NULL, array('id' => 'ssFechaReporte3', 'class' => 'validate')) !!}
                        </div>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte4', 'Reporte 4', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte4', NULL, array('id' => 'ssFechaReporte4', 'class' => 'validate')) !!}
                        </div>
                    </div>
                </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
      		{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
    var resumenIdOld = "{{old("resumen_id")}}";
      if (resumenIdOld) {
        buscarAlumno()
      }
    $(".btn-buscar-alumno").on("click", function (e) {
        e.preventDefault()

        var aluClave = $("#aluClave").val()
        var nombreAlumno = $("#nombreAlumno").val()
        if (aluClave === "" && nombreAlumno === "") {
            swal({
                title: "Busqueda de alumnos",
                text: "Debes de tener al menos un dato de alumnos capturados",
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: '#0277bd',
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                swal.close()
            });

        } else {
            buscarAlumno()
        }


    function buscarAlumno()
      {
        var nombreAlumno = $("#nombreAlumno").val()
        var aluClave = $("#aluClave").val()

        $.ajax({
            type: "GET",
            url: base_url + `/api/serviciosocial/filtrar_alumnos`,
            data: {
                nombreAlumno: nombreAlumno,
                aluClave: aluClave,
                // _token: $("meta[name=csrf-token]").attr("content")
            },
            dataType: "json"
        })
        .done(function(res) {
            $("#resumen_id").empty()

            if (res.length > 0) {
                res.forEach(resumen => {
                    $("#resumen_id").append(`<option value=${resumen.resumen_id}>
                        ${resumen.ubiClave} | ${resumen.depClave} | ${resumen.progClave} | ${resumen.planClave}
                        (Periodo ingreso: ${resumen.perNumero}/${resumen.perAnio})
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ${resumen.aluClave} - ${resumen.nombreCompleto}</option>`);
                });
                $('#resumen_id').trigger('click');
                $('#resumen_id').trigger('change');
            }

        });
      } //buscarAlumno.
    });
    });
</script>
@endsection