@extends('layouts.dashboard')

@section('template_title')
    Bachiller materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_materia')}}" class="breadcrumb">Lista de materias</a>
    <label class="breadcrumb">Agregar materia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_materia.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MATERIA</span>

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
                        <div class="input-field">
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => '','maxlength'=>'30')) !!}
                            {!! Form::label('matClave', 'Clave materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombre', NULL, array('id' => 'matNombre', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('matNombre', 'Nombre materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreCorto', NULL, array('id' => 'matNombreCorto', 'class' => '','maxlength'=>'15')) !!}
                            {!! Form::label('matNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('matVigentePlanPeriodoActual', 'Materia activa', array('class' => '')); !!}
                        <select id="matVigentePlanPeriodoActual" class="browser-default validate select2" name="matVigentePlanPeriodoActual" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Grado/Semestre *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('matSemestre')}}">
                        <select id="matSemestre"
                            data-gposemestre-id="{{old('matSemestre')}}"
                            class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('matCreditos', NULL, array('id' => 'matCreditos', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                            {!! Form::label('matCreditos', 'Créditos', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="matClasificacion" class="browser-default validate select2" name="matClasificacion" style="width: 100%;">

                            @if (auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1)
                            <option value="B" {{old('matClasificacion') == "B" ? "selected": ""}}>BÁSICA</option>
                            <option value="O" {{old('matClasificacion') == "O" ? "selected": ""}}>OPTATIVA</option>
                            <option value="U" {{old('matClasificacion') == "U" ? "selected": ""}}>OCUPACIONAL</option>
                            <option value="X" {{old('matClasificacion') == "X" ? "selected": ""}}>EXTRAOFICIAL</option>
                            <option value="C" {{old('matClasificacion') == "C" ? "selected": ""}}>COMPLEMENTARIA</option>
                            <option value="B" {{old('matClasificacion') == "C" ? "selected": ""}}>BÁSICA INGLES</option>
                            @endif
                            
                            @if (auth()->user()->campus_cch == 1)
                            <option value="B" {{old('matClasificacion') == "B" ? "selected": ""}}>BÁSICA</option>
                            <option value="X" {{old('matClasificacion') == "X" ? "selected": ""}}>EXTRACURRICULAR</option>
                            <option value="C" {{old('matClasificacion') == "C" ? "selected": ""}}>COMPETENCIAS</option>
                            <option value="E" {{old('matClasificacion') == "E" ? "selected": ""}}>ESPECIALIDAD</option>
                            @endif
                            
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matEspecialidad', NULL, array('id' => 'matEspecialidad', 'class' => 'validate','maxlength'=>'3')) !!}
                            {!! Form::label('matEspecialidad', 'Especialidad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matTipoAcreditacion', 'Tipo de acreditación', array('class' => '')); !!}
                        <select id="matTipoAcreditacion" class="browser-default validate select2" name="matTipoAcreditacion" style="width: 100%;">
                            <option value="N" {{old('matTipoAcreditacion') == "N" ? "selected": ""}}>NUMÉRICO</option>
                            <option value="A" {{old('matTipoAcreditacion') == "A" ? "selected": ""}}>ALFABÉTICO</option>
                            <option value="M" {{old('matTipoAcreditacion') == "M" ? "selected": ""}}>MIXTO</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('matPorcentajeParcial', NULL, array('id' => 'matPorcentajeParcial', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('matPorcentajeParcial', '% Examen parcial', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('matPorcentajeOrdinario', NULL, array('id' => 'matPorcentajeOrdinario', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('matPorcentajeOrdinario', '% Examen ordinario', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreOficial', NULL, array('id' => 'matNombreOficial', 'class' => 'validate','maxlength'=>'78')) !!}
                            {!! Form::label('matNombreOficial', 'Nombre oficial', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('matOrdenVisual', NULL, array('id' => 'matOrdenVisual', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                            {!! Form::label('matOrdenVisual', 'Orden visual', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l2">
                        <div class="input-field col s6 m6 l3">
                            <a name="agregarMateriaBachiller" id="agregarMateriaBachiller" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                                data-position="right" data-tooltip="Agregar Materia">
                                <i class=material-icons>library_add</i>
                            </a>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <table id="tbl-materias-bachiller" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Clave materia</th>
                                    <th>Nombre</th>
                                    <th>Nombre corto</th>
                                    <th>Materia activa</th>
                                    <th>Grado</th>
                                    <th>Creditos</th>
                                    <th>Clasificación</th>
                                    <th>Especialidad</th>
                                    <th>Tipo de acreditación</th>
                                    <th>% Examen parcial</th>
                                    <th>% Examen Ordinario</th>
                                    <th>Nombre Oficial</th>
                                    <th>Orden visual</th>
                                    <th style="display: none;">especialidad</th>
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

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')



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
$(document).ready(function(){
    $('.submit-button').prop('disabled',true);
    function tablaMateria(datos,planId){
    var table_row = `<tr><input type="hidden" name="materias[]" 
        value="${planId}~${datos[0]}~${datos[1]}~${datos[2]}~${datos[3]}~${datos[4]}~${datos[5]}~${datos[6]}~${datos[7]}~${datos[8]}~${datos[9]}~${datos[10]}~${datos[11]}~${datos[12]}~${datos[13]}~${datos[14]}"/>`+
        '<td>'+datos[0]+'</td>'+
        '<td>'+datos[1]+'</td>'+
        '<td>'+datos[2]+'</td>'+
        '<td>'+datos[3]+'</td>'+
        '<td>'+datos[4]+'</td>'+
        '<td>'+datos[5]+'</td>'+
        '<td>'+datos[6]+'</td>'+
        '<td>'+datos[7]+'</td>'+
        '<td>'+datos[8]+'</td>'+
        '<td>'+datos[9]+'</td>'+
        '<td>'+datos[10]+'</td>'+
        '<td>'+datos[11]+'</td>'+
        '<td>'+datos[12]+'</td>'+
        '<td>'+datos[13]+'</td>'+
        '<td style="display:none;">'+datos[14]+'</td>'+
        '<td><a class="quitar" style="cursor:pointer;" title="Quitar materia">'+
            '<i class=material-icons>delete</i>'+
        '</a></td>'+
        '</tr>';
    $('#tbl-materias-bachiller tbody').append(table_row);
}

    $('#agregarMateriaBachiller').on('click',function(e){
        e.preventDefault();
        
    var planId = $('#plan_id option:selected').val();

    var planClave = $('#plan_id option:selected').html();
    var matClave = $('#matClave').val();
    var matNombre = $('#matNombre').val();
    var matNombreCorto = $('#matNombreCorto').val();
    var matVigentePlanPeriodoActual = $("#matVigentePlanPeriodoActual").val();
    var matSemestre = $('#matSemestre').val();
    var matCreditos = $('#matCreditos').val();
    var matClasificacion = $('#matClasificacion').val();
    var matEspecialidad = $('#matEspecialidad').val();
    var matTipoAcreditacion = $('#matTipoAcreditacion').val();
    var matPorcentajeParcial = $('#matPorcentajeParcial').val();
    var matPorcentajeOrdinario = $('#matPorcentajeOrdinario').val();
    var matNombreOficial = $('#matNombreOficial').val();
    var matOrdenVisual = $('#matOrdenVisual').val();
    var clasificacionSelect = $('select[name="matClasificacion"] option:selected').text();

    var nuevoValor = clasificacionSelect;
    if($("#ubicacion_id").val() == 1 || $("#ubicacion_id").val() == 2){
        
        if(clasificacionSelect == "BÁSICA"){
            nuevoValor = "BASICA";
        }else{
            nuevoValor = clasificacionSelect;
        }
    
        if(clasificacionSelect == "BÁSICA INGLES"){
            nuevoValor = "BASICA INGLES";
        }else{
            nuevoValor = clasificacionSelect;
        }

        if(clasificacionSelect == "EXTRAOFICIAL"){
            nuevoValor = "EXTRA";
        }else{
            nuevoValor = clasificacionSelect;
        }
    }

    if($("#ubicacion_id").val() == 3){
        
        if(clasificacionSelect == "BÁSICA"){
            nuevoValor = "BASICA";
        }else{
            nuevoValor = clasificacionSelect;
        }
    }
    

    if(matClave && matNombre && matNombreCorto && matSemestre){             
        $('#ubicacion_id').prop('disabled',true);
        $('#departamento_id').prop('disabled',true);
        $('#escuela_id').prop('disabled',true);
        $('#programa_id').prop('disabled',true);
        $('#plan_id').prop('disabled',true);
        $('.submit-button').prop('disabled',false);
        

        var datos = [
            planClave,
            matClave,
            matNombre,
            matNombreCorto,
            matVigentePlanPeriodoActual,
            matSemestre,
            matCreditos,
            matClasificacion,
            matEspecialidad,
            matTipoAcreditacion,
            matPorcentajeParcial,
            matPorcentajeOrdinario,
            matNombreOficial,
            matOrdenVisual,
            nuevoValor
        ];

            tablaMateria(datos,planId);
            $('#matClave').val('');
            $('#matNombre').val('');
            $('#matNombreCorto').val('');
            $('#matVigentePlanPeriodoActual').val('');
            $('#matCreditos').val('');
            $('#matEspecialidad').val('');
            $('#matPorcentajeParcial').val('');
            $('#matPorcentajeOrdinario').val('');
            $('#matNombreOficial').val('');
            $('#matOrdenVisual').val('');
        }else{
            swal('Ingrese todos los datos de la materia para poder agregarla a lista \n'+
            'Datos necesarios: \n'+
            'Clave materia, Nombre, Nombre corto y Grado');
        }
    });

    $('#tbl-materias-bachiller').on('click','.quitar', function () {
        $(this).closest('tr').remove();
        if($('#tbl-materias-bachiller tbody tr').length == 0){
            $('#ubicacion_id').prop('disabled',false);
            $('#departamento_id').prop('disabled',false);
            $('#escuela_id').prop('disabled',false);
            $('#programa_id').prop('disabled',false);
            $('#plan_id').prop('disabled',false);
            $('.submit-button').prop('disabled',true);
        }
    });

});
</script>


@endsection