@extends('layouts.dashboard')

@section('template_title')
    Solicitar extraordinario
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_extraordinario')}}" class="breadcrumb">Lista de extraordinarios</a>
    <a href="{{url('solicitudes/bachiller_extraordinario')}}" class="breadcrumb">Lista de solicitudes</a>
    <label class="breadcrumb">Agregar solicitud</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'store.bachiller_solicitud','target'=>"_blank", 'method' => 'POST', 'id' => 'form_solicitud']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR SOLICITUD EXTRAORDINARIO</span>

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
                        <div class="input-field">
                        {!! Form::number('extraordinario_id', NULL, array('id' => 'extraordinario_id', 'class' => 'validate','required','min'=>'0','max'=>'99999999999999999999','onKeyPress="if(this.value.length==20) return false;"')) !!}
                        {!! Form::label('extraordinario_id', 'Clave de examen *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id' => 'btnBuscarExtra','class' => 'btn-large waves-effect modal-trigger']) !!}
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                        <select id="alumno_id" class="browser-default validate select2" required name="alumno_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::button('<i class="material-icons left">verified_user</i> Validar alumno', ['id' => 'btnValidarAlumno','class' => 'btn-large waves-effect modal-trigger']) !!}
                    </div>
                </div>

    

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('iexFecha', 'Fecha de solicitud *', array('class' => '')); !!}
                        {!! Form::date('iexFecha', date('Y-m-d'), array('id' => 'iexFecha', 'class' => ' validate','required')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('iexEstado', 'Estado pago *', ['class' => '']); !!}
                        <select name="iexEstado" id="iexEstado" class="browser-default validate select2" style="width: 100%;">
                        <option value="P">PAGADO</option>
                        <option value="N">NO PAGADO</option>
                        <option value="C">CANCELADO</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <h5>Detalles del extraordinario</h5>
            <div class="row">
                <div class="col s12 m4 14">
                    <div class="input-field">
                        {!! Form::text('empleado_id', NULL, array('id'=>'empleado_id','readonly' => 'true')) !!}
                        {!! Form::label('empleado_id', 'Docente', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m4 14">
                    <div class="input-field">
                    {!! Form::text('materia_id', NULL, array('id'=>'materia_id','readonly' => 'true')) !!}
                    {!! Form::label('materia_id', 'Materia', ['class' => '']); !!}
                    </div>
                </div>
                {{--  <div class="col s12 m4 14">
                    <div class="input-field">
                    {!! Form::text('optativa_id', NULL, array('id'=>'optativa_id','readonly' => 'true')) !!}
                    {!! Form::label('optativa_id', 'Optativa', ['class' => '']); !!}
                    </div>
                </div>  --}}
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('ubiClave', NULL, array('id'=>'ubiClave','readonly' => 'true')) !!}
                      {!! Form::label('ubiClave', 'Ubicación', array('class' => '')); !!}
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('departamento_id', NULL, array('id'=>'departamento_id','readonly' => 'true')) !!}
                      {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('escuela_id', NULL, array('id'=>'escuela_id','readonly' => 'true')) !!}
                      {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('programa_id', NULL, array('id'=>'programa_id','readonly' => 'true')) !!}
                        {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 14">
                        {!! Form::text('plan_id', NULL, array('id'=>'plan_id','readonly' => 'true')) !!}
                        {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                    </div>
                    <div class="input-field col s12 m6 14">
                        {!! Form::text('periodo_id', NULL, array('id'=>'periodo_id','readonly' => 'true')) !!}
                        {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 14">
                    {!! Form::text('perFechaInicial', NULL, array('id'=>'perFechaInicial','readonly' => 'true')) !!}
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                    </div>
                    <div class="input-field col s12 m6 14">
                    {!! Form::text('perFechaFinal', NULL, array('id'=>'perFechaFinal','readonly' => 'true')) !!}
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 14">
                        {!! Form::text('matSemestre', NULL, array('id'=>'matSemestre','readonly' => 'true')) !!}
                        {!! Form::label('matSemestre', 'Semestre', array('class' => '')); !!}
                    </div>
                    <div class="input-field col s12 m6 14">
                    {!! Form::text('extGrupo', NULL, array('id'=>'extGrupo','readonly' => 'true')) !!}
                    {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 14">
                    {!! Form::text('aula_id', NULL, array('id'=>'aula_id','readonly' => 'true')) !!}
                    {!! Form::label('aula_id', 'Aula', ['class' => '']); !!}
                    </div>
                    <div class="input-field col s12 m6 14">
                      {!! Form::text('extFecha', NULL, array('id'=>'extFecha','readonly' => 'true')) !!}
                      {!! Form::label('extFecha', 'Fecha examen', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field col s12 m6 14">
                      {!! Form::text('extHora', NULL, array('id'=>'extHora','readonly' => 'true')) !!}
                      {!! Form::label('extHora', 'Hora examen', ['class' => '']); !!}
                    </div>
                    <div class="input-field col s12 m6 14">
                        {!! Form::text('extPago', NULL, array('id'=>'extPago','readonly' => 'true')) !!}
                        {!! Form::label('extPago', 'Costo Examen', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        {!! Form::text('empleado_sinodal_id', NULL, array('id'=>'empleado_sinodal_id','readonly' => 'true')) !!}
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', ['class' => '']); !!}
                    </div>
                </div>
            </div>

            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'extSaveButton','class' => 'btn-large waves-effect  darken-3', 'disabled']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <div class="preloader">
      <div id=""></div>
  </div>


@endsection

@section('footer_scripts')

@include('bachiller.scripts.funcionesAuxiliares')

@include('bachiller.scripts.solicitudes')


<script type="text/javascript">
    $(document).on('click', '#btnValidarAlumno', function (e) {
        var extraordinario_id = $("#extraordinario_id").val()
        var alumno_id = $("#alumno_id").val()

        $.get(base_url + `/api/bachiller_extraordinario/validarAlumnoPresentaExtra/` + extraordinario_id + "/" + alumno_id, function(res,sta) {
            console.log(res)
            if (res.puedePresentarExtra) {
                swal({
                    title: "Escuela modelo",
                    text: "El alumno puede presentar examen extraordinario.",
                    type: "success",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: '#3085d6',
                    showCancelButton: false
                    }, function(isConfirm) {
                    if (isConfirm) {
                         $('#extSaveButton').prop('disabled', false);
                    } 
                });

            } else {
                swal({
                    title: "Notificación",
                    text: "El alumno NO está autorizado a presentar examen extraordinario: \n"+ res.msg 
                        + " \n ¿Deseas continuar?",
                    type: "warning",
                    confirmButtonText: "Continuar de todas formas",
                    confirmButtonColor: '#3085d6',
                    showCancelButton: true
                    }, function(isConfirm) {
                    if (isConfirm) {
                        $('#extSaveButton').prop('disabled', false);
                    } 
                });
            }
        });

        $('#extSaveButton').on('click', function(e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            $('#form_solicitud').submit();
        });

    });
</script>
@endsection