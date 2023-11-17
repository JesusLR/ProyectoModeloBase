@extends('layouts.dashboard')

@section('template_title')
    Primaria materia asignatura
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_materias_asignaturas.index')}}" class="breadcrumb">Lista de materias asignaturas</a>
    <label class="breadcrumb">Agregar materia asignatura</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_materias_asignaturas.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MATERIA ASIGNATURA</span>

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
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-idold="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Grado *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('matSemestre')}}">
                        <select id="matSemestre"
                            data-gposemestre-idold="{{old('matSemestre')}}"
                            class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('primaria_materia_id', 'Materia *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('primaria_materia_id')}}">
                        <select id="primaria_materia_id"
                            data-gposemestre-idold="{{old('primaria_materia_id')}}"
                            class="browser-default validate select2" required name="primaria_materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClaveAsignatura', old('matClaveAsignatura'), array('id' => 'matClaveAsignatura', 'class' => '','maxlength'=>'4')) !!}
                            {!! Form::label('matClaveAsignatura', 'Clave asignatura *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreAsignatura', old('matNombreAsignatura'), array('id' => 'matNombreAsignatura', 'class' => '','maxlength'=>'150')) !!}
                            {!! Form::label('matNombreAsignatura', 'Nombre asignatura *', array('class' => '')); !!}
                        </div>
                    </div>     
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" onKeyDown="if(this.value.length==3) return false;" max="100" name="matAsignaturaPorcentaje" id="matAsignaturaPorcentaje" value="{{old('matAsignaturaPorcentaje')}}">
                            {!! Form::label('matAsignaturaPorcentaje', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

              
                <div class="row">              
                    <div class="col s12 m6 l2">
                        <div class="input-field col s6 m6 l3">
                            <a name="agregarMateriaPrimaria" id="agregarMateriaPrimaria" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                                data-position="right" data-tooltip="Agregar Materia">
                                <i class=material-icons>library_add</i>
                            </a>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <table id="tbl-materias" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Período</th>
                                <th>Grado</th>
                                <th>Materia</th>
                                <th>Clave asignatura</th>
                                <th>Nombre asignatura</th>
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
@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')
@include('primaria.materias_asignaturas.obtenerMateriasJS')


<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER MATERIA SEMESTRE Y SEMESTRE CGT
        $("#plan_id").change( event => {
            $("#matSemestre").empty();
            $("#matSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);




            $.get(base_url + `/primaria_plan/plan/semestre/${event.target.value}`, function(res,sta) {
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
$(document).ready(function(){
    $('.submit-button').prop('disabled',true);
    function tablaMateria(datos,planId, primaria_materia_id, periodo_id){
    var table_row = `<tr><input type="hidden" name="materias[]" 
    value="${planId}~${primaria_materia_id}~${periodo_id}~${datos[0]}~${datos[1]}~${datos[2]}~${datos[3]}~${datos[4]}~${datos[5]}~${datos[6]}"/>`+
        '<td>'+datos[0]+'</td>'+
        '<td>'+datos[1]+'</td>'+
        '<td>'+datos[2]+'</td>'+
        '<td>'+datos[3]+'</td>'+
        '<td>'+datos[4]+'</td>'+
        '<td>'+datos[5]+'</td>'+
        '<td>'+datos[6]+'</td>'+        
        '<td><a class="quitar" style="cursor:pointer;" title="Quitar materia">'+
            '<i class=material-icons>delete</i>'+
        '</a></td>'+
        '</tr>';
    $('#tbl-materias tbody').append(table_row);
}

    $('#agregarMateriaPrimaria').on('click',function(e){
        e.preventDefault();
        

    var planId = $('#plan_id option:selected').val();
    var planClave = $('#plan_id option:selected').html();
    var periodo_id = $('#periodo_id option:selected').val();
    var periodoAnio = $('#periodo_id option:selected').html();
    var matClaveAsignatura = $('#matClaveAsignatura').val();
    var matNombreAsignatura = $('#matNombreAsignatura').val();
    var matSemestre = $('#matSemestre').val();
    var matAsignaturaPorcentaje = $("#matAsignaturaPorcentaje").val();
    var primaria_materia_id = $('select[id=primaria_materia_id]').val();
    var primariaMateriaId = $('#primaria_materia_id option:selected').html();


    if(primaria_materia_id && matClaveAsignatura && matNombreAsignatura && matSemestre && matAsignaturaPorcentaje){             
        $('#ubicacion_id').prop('disabled',true);
        $('#departamento_id').prop('disabled',true);
        $('#escuela_id').prop('disabled',true);
        $('#programa_id').prop('disabled',true);
        $('#plan_id').prop('disabled',true);
        $('#periodo_id').prop('disabled',true);
        $('#matSemestre').prop('disabled',true);
        $('#primaria_materia_id').prop('disabled',true);


        $('.submit-button').prop('disabled',false);
        

        var datos = [
            planClave,
            periodoAnio,
            matSemestre,
            primariaMateriaId,
            matClaveAsignatura,
            matNombreAsignatura,
            matAsignaturaPorcentaje            
        ];

            tablaMateria(datos,planId, primaria_materia_id, periodo_id);
            $('#matClaveAsignatura').val('');
            $('#matNombreAsignatura').val('');
            $('#matAsignaturaPorcentaje').val('');
        }else{
            swal('Ingrese todos los datos de la materia para poder agregarla a lista \n'+
            'Datos necesarios: \n'+
            'Materia, Clave asignatura, Nombre asignatura, Grado, Porcentaje');
        }
    });

    $('#tbl-materias').on('click','.quitar', function () {
        $(this).closest('tr').remove();
        if($('#tbl-materias tbody tr').length == 0){
            $('#ubicacion_id').prop('disabled',false);
            $('#departamento_id').prop('disabled',false);
            $('#escuela_id').prop('disabled',false);
            $('#programa_id').prop('disabled',false);
            $('#plan_id').prop('disabled',false);
            $('#primaria_materia_id').prop('disabled',false);
            $('#matSemestre').prop('disabled',false);
            $('#periodo_id').prop('disabled',false);
            $('.submit-button').prop('disabled',true);
        }
    });

});
</script>


@endsection