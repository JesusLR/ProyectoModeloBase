@extends('layouts.dashboard')

@section('template_title')
    secundaria materia complementaria
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_materia')}}" class="breadcrumb">Lista de materias</a>
    <a href="{{route('secundaria.secundaria_materia.index_acd', ['materia_id' => $secundaria_materia->materia_id, 'plan_id' => $secundaria_materia->plan_id])}}" class="breadcrumb">Lista de materias complementarias</a>
    <label class="breadcrumb">Agregar materia complementaria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_materia.store_acd', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MATERIA COMPLEMENTARIA A MATERIA: <b>{{$secundaria_materia->matClave.'-'.$secundaria_materia->matNombre}}</b></span>

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
                            <option value="{{$secundaria_materia->ubicacion_id}}}">{{$secundaria_materia->ubiClave.'-'.$secundaria_materia->ubiNombre}}</option>                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$secundaria_materia->departamento_id}}}">{{$secundaria_materia->depClave.'-'.$secundaria_materia->depNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$secundaria_materia->escuela_id}}}">{{$secundaria_materia->escClave.'-'.$secundaria_materia->escNombre}}</option> 
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
                            <option value="{{$secundaria_materia->programa_id}}}">{{$secundaria_materia->progClave.'-'.$secundaria_materia->progNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$secundaria_materia->plan_id}}">{{$secundaria_materia->planClave}}</option> 
                        </select>
                    </div>

                    <input type="hidden" name="secundaria_materia_id" id="secundaria_materia_id" value="{{$secundaria_materia->materia_id}}">
                    <input type="hidden" name="gpoGrado" id="gpoGrado" value="{{$secundaria_materia->matSemestre}}">
                    <input type="hidden" name="secundaria_matClave" id="secundaria_matClave" value="{{$secundaria_materia->matClave}}">


                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoMatComplementaria', NULL, array('id' => 'gpoMatComplementaria', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('gpoMatComplementaria', 'Nombre materia *', array('class' => '')); !!}
                        </div>
                    </div>
{{--  
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('secundaria_matPorcentajeCalificacion', NULL, array('id' => 'secundaria_matPorcentajeCalificacion', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('secundaria_matPorcentajeCalificacion', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div>  --}}
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
                        <a name="agregarMateriaComplementariasecundaria" id="agregarMateriaComplementariasecundaria" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                            data-position="right" data-tooltip="Agregar Materia">
                            <i class=material-icons>library_add</i>
                        </a>
                    </div>
                  </div>
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-materias-secundaria" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Período</th>
                                    <th>Nombre</th>
                                    <th>Grado</th>
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
    $.get(base_url+`/secundaria_periodo/todos/periodos/${departamentoId}`,function(res2,sta){
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
        $.get(base_url+`/secundaria_periodo/api/periodo/${perSeleccionado}`,function(res3,sta){
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




            $.get(base_url + `/secundaria_plan/plan/semestre/${event.target.value}`, function(res,sta) {
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
    
        function tablaMateria(datos,planId,periodoId,secundaria_materia_id,secundaria_matClave) {
            var table_row = `<tr><input type="hidden" name="materias_acd[]" 
            value="${planId}~${periodoId}~${secundaria_materia_id}~${secundaria_matClave}~${datos[0]}~${datos[1]}~${datos[2]}~${datos[3]}"/>` +
                '<td>' + datos[0] + '</td>' +
                '<td>' + datos[1] + '</td>' +
                '<td>' + datos[2] + '</td>' +
                '<td>' + datos[3] + '</td>' +
                '<td style="display: none;"><input id="periodo_id2" type="text" name="periodo_id2" value="'+periodoId+'"></td>' +
                '<td><a class="quitar" style="cursor:pointer;" title="Quitar materia">' +
                '<i class=material-icons>delete</i>' +
                '</a></td>' +
                '</tr>';
            $('#tbl-materias-secundaria tbody').append(table_row);
        }
    
        $('#agregarMateriaComplementariasecundaria').on('click', function(e) {
            e.preventDefault();
    
            var planId = $('#plan_id option:selected').val();
            var planClave = $('#plan_id option:selected').html();
            var periodoId = $('#periodo_id option:selected').val();
            var periodoClave = $('#periodo_id option:selected').html();
            var secundaria_materia_id = $('#secundaria_materia_id').val();
            var secundaria_matClave = $('#secundaria_matClave').val();
            var gpoGrado = $('#gpoGrado').val();
            var gpoMatComplementaria = $('#gpoMatComplementaria').val();
    
            if (gpoMatComplementaria) {
    
                $('#periodo_id').prop('disabled', true);
                $('.submit-button').prop('disabled', false);
    
    
                var datos = [
                    planClave,
                    periodoClave,
                    gpoMatComplementaria,
                    gpoGrado
                ];
    
                tablaMateria(datos, planId, periodoId, secundaria_materia_id, secundaria_matClave);
                $('#gpoMatComplementaria').val('');
            } else {
                swal('Ingrese todos los datos de la materia para poder agregarla a lista \n' +
                    'Datos necesarios: \n' +
                    'Nombre, Porcentaje');
            }
        });
    
        $('#tbl-materias-secundaria').on('click', '.quitar', function() {
            $(this).closest('tr').remove();
            if ($('#tbl-materias-secundaria tbody tr').length == 0) {
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