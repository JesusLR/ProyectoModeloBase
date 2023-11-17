@extends('layouts.dashboard')

@section('template_title')
    Bachiller materia complementaria
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_materia')}}" class="breadcrumb">Lista de materias</a>
    <a href="{{route('bachiller.bachiller_materia.index_acd', ['materia_id' => $bachiller_materia->materia_id, 'plan_id' => $bachiller_materia->plan_id])}}" class="breadcrumb">Lista de materias complementarias</a>
    <label class="breadcrumb">Agregar materia complementaria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_materia.store_acd', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MATERIA COMPLEMENTARIA A MATERIA: <b>{{$bachiller_materia->matClave.'-'.$bachiller_materia->matNombre}}</b></span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$bachiller_materia->ubicacion_id}}}">{{$bachiller_materia->ubiClave.'-'.$bachiller_materia->ubiNombre}}</option>                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$bachiller_materia->departamento_id}}}">{{$bachiller_materia->depClave.'-'.$bachiller_materia->depNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$bachiller_materia->escuela_id}}}">{{$bachiller_materia->escClave.'-'.$bachiller_materia->escNombre}}</option> 
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
                            <option value="{{$bachiller_materia->programa_id}}}">{{$bachiller_materia->progClave.'-'.$bachiller_materia->progNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$bachiller_materia->plan_id}}">{{$bachiller_materia->planClave}}</option> 
                        </select>
                    </div>

                    <input type="hidden" name="bachiller_materia_id" id="bachiller_materia_id" value="{{$bachiller_materia->materia_id}}">
                    <input type="hidden" name="gpoGrado" id="gpoGrado" value="{{$bachiller_materia->matSemestre}}">
                    <input type="hidden" name="bachiller_matClave" id="bachiller_matClave" value="{{$bachiller_materia->matClave}}">


                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoMatComplementaria', NULL, array('id' => 'gpoMatComplementaria', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('gpoMatComplementaria', 'Nombre materia *', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('bachiller_matPorcentajeCalificacion', NULL, array('id' => 'bachiller_matPorcentajeCalificacion', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('bachiller_matPorcentajeCalificacion', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        {!! Form::label('matVigentePlanPeriodoActual', 'Materia activa', array('class' => '')); !!}
                        <select id="matVigentePlanPeriodoActual" class="browser-default validate select2" name="matVigentePlanPeriodoActual" style="width: 100%;">
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>   --}}
                </div>
               
                <div class="col s12 m6 l2">
                    <div class="input-field col s6 m6 l3">
                        <a name="agregarMateriaComplementariaBachiller" id="agregarMateriaComplementariaBachiller" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                            data-position="right" data-tooltip="Agregar Materia">
                            <i class=material-icons>library_add</i>
                        </a>
                    </div>
                  </div>
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-materias-bachiller" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Período</th>
                                    <th>Nombre</th>
                                    <th>Grado</th>
                                    <th>Porcentaje</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

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

<script>

    var departamentoId = $("#departamento_id").val();
    $.get(base_url+`/bachiller_periodo/todos/periodos/${departamentoId}`,function(res2,sta){
        var perSeleccionado;


        var periodoSeleccionadoOld = $("#periodo_id").data("periodo-id")

        console.log(periodoSeleccionadoOld)
        $("#periodo_id").empty()
        res2.forEach(element => {

            var selected = "";
            if (element.id === periodoSeleccionadoOld) {
                console.log("entra")
                console.log(element.id)
                selected = "selected";
            }

            $("#periodo_id").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
        });
        //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
        $.get(base_url+`/bachiller_periodo/api/periodo/${perSeleccionado}`,function(res3,sta){
            $("#perFechaInicial").val(res3.perFechaInicial);
            $("#perFechaFinal").val(res3.perFechaFinal);
            Materialize.updateTextFields();
        });

        $('#periodo_id').trigger('change'); // Notify only Select2 of changes
    });//TERMINA PERIODO
</script>

<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER MATERIA SEMESTRE Y SEMESTRE CGT
        $("#plan_id").change( event => {
            $("#matSemestre").empty();
            $("#matSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);




            $.get(base_url + `/bachiller_plan/plan/semestre/${event.target.value}`, function(res,sta) {
                //seleccionar el post preservado
                var gpoSemestreSeleccionadoOld = $(".gpoSemestreOld").data("gposemestre-idold")
                console.log(gpoSemestreSeleccionadoOld)

                $("#matSemestre").empty()
                //PARA PRIMARIA SON 6 GRADOS
                //for (i = 1; i <= res.planPeriodos; i++) {
                for (i = 1; i <= 6; i++) {    
                    var selected = "";
                    if (i === gpoSemestreSeleccionadoOld) {
                        selected = "selected";
                    }


                    $("#matSemestre").append(`<option value="${i}" ${selected}>${i}</option>`);
                }

                $('#matSemestre').trigger('change'); // Notify only Select2 of changes
            });
        });
     });
</script>

<script>
    $(document).ready(function() {
        $('.submit-button').prop('disabled', true);
    
        function tablaMateria(datos,planId,periodoId,bachiller_materia_id,bachiller_matClave) {
            var table_row = `<tr><input type="hidden" name="materias_acd[]" 
            value="${planId}~${periodoId}~${bachiller_materia_id}~${bachiller_matClave}~${datos[0]}~${datos[1]}~${datos[2]}~${datos[3]}~${datos[4]}"/>` +
                '<td>' + datos[0] + '</td>' +
                '<td>' + datos[1] + '</td>' +
                '<td>' + datos[2] + '</td>' +
                '<td>' + datos[3] + '</td>' +
                '<td>' + datos[4] + '</td>' +
                '<td><a class="quitar" style="cursor:pointer;" title="Quitar materia">' +
                '<i class=material-icons>delete</i>' +
                '</a></td>' +
                '</tr>';
            $('#tbl-materias-bachiller tbody').append(table_row);
        }
    
        $('#agregarMateriaComplementariaBachiller').on('click', function(e) {
            e.preventDefault();
    
            var planId = $('#plan_id option:selected').val();
            var planClave = $('#plan_id option:selected').html();
            var periodoId = $('#periodo_id option:selected').val();
            var periodoClave = $('#periodo_id option:selected').html();
            var bachiller_materia_id = $('#bachiller_materia_id').val();
            var bachiller_matClave = $('#bachiller_matClave').val();
            var gpoGrado = $('#gpoGrado').val();
            var gpoMatComplementaria = $('#gpoMatComplementaria').val();
            var bachiller_matPorcentajeCalificacion = $('#bachiller_matPorcentajeCalificacion').val();
    
            if (gpoMatComplementaria && bachiller_matPorcentajeCalificacion) {
    
                $('#periodo_id').prop('disabled', true);
                $('.submit-button').prop('disabled', false);
    
    
                var datos = [
                    planClave,
                    periodoClave,
                    gpoMatComplementaria,
                    gpoGrado,
                    bachiller_matPorcentajeCalificacion                    
                ];
    
                tablaMateria(datos, planId, periodoId, bachiller_materia_id, bachiller_matClave);
                $('#gpoMatComplementaria').val('');
                $('#bachiller_matPorcentajeCalificacion').val('');
            } else {
                swal('Ingrese todos los datos de la materia para poder agregarla a lista \n' +
                    'Datos necesarios: \n' +
                    'Nombre, Porcentaje');
            }
        });
    
        $('#tbl-materias-bachiller').on('click', '.quitar', function() {
            $(this).closest('tr').remove();
            if ($('#tbl-materias-bachiller tbody tr').length == 0) {
                $('#ubicacion_id').prop('disabled', false);
                $('#departamento_id').prop('disabled', false);
                $('#escuela_id').prop('disabled', false);
                $('#programa_id').prop('disabled', false);
                $('#plan_id').prop('disabled', false);
                $('#periodo_id').prop('disabled', false);
                $('.submit-button').prop('disabled', true);
            }
        });
    
    });
</script>


@endsection