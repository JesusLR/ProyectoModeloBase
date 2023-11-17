@extends('layouts.dashboard')

@section('template_title')
    Optativa
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('optativa')}}" class="breadcrumb">Lista de optativas</a>
    <label class="breadcrumb">Agregar optativa</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'optativa.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR OPTATIVA</span>

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
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if($ubicacion->id == $ubicacion_id){
                                    echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }else{
                                    echo '<option value="'.$ubicacion->id.'">'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('materia_id', 'Materia optativa *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('optNumero', NULL, array('id' => 'optNumero', 'class' => 'validate','min'=>'0','max'=>'99','onKeyPress="if(this.value.length==2) return false;"')) !!}
                            {!! Form::label('optNumero', 'Número de Optativa *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m8">
                        <div class="input-field">
                            {!! Form::text('optNombre', NULL, array('id' => 'optNombre', 'class' => 'validate','maxlength'=>'78')) !!}
                            {!! Form::label('optNombre', 'Nombre optativa *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('optClaveEspecifica', NULL, array('id' => 'optClaveEspecifica', 'class' => 'validate','maxlength'=>'25')) !!}
                            {!! Form::label('optClaveEspecifica', 'Clave específica *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s6 m6 l3">
                            <a name="agregarOptativa" id="agregarOptativa" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                                data-position="right" data-tooltip="Agregar Optativa">
                                <i class=material-icons>library_add</i>
                            </a>
                        </div>
                      </div>
                </div>
                
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-optativas" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Materia optativa</th>
                                <th>Número de optativa</th>
                                <th>Nombre optativa</th>
                                <th>Clave específica</th>
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
@include('scripts.preferencias')
@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.cgts')
@include('scripts.materias-optativas')

<script>
$(document).ready(function(){
    $('.submit-button').prop('disabled',true);
    function tablaOptativa(materia_id,optNumero,optNombre,optClaveEspecifica){
        var table_row = `<tr><input type="hidden" name="optativas[]" value="${materia_id}|${optNumero}|${optNombre}|${optClaveEspecifica}"/>`+
            '<td>'+materia_id+'</td>'+
            '<td>'+optNumero+'</td>'+
            '<td>'+optNombre+'</td>'+
            '<td>'+optClaveEspecifica+'</td>'+
            '<td><a class="quitar" style="cursor:pointer;" title="Quitar optativa">'+
                '<i class=material-icons>delete</i>'+
            '</a></td>'+
            '</tr>';
        $('#tbl-optativas tbody').append(table_row);
    }

    $('#agregarOptativa').on('click',function(e){
        e.preventDefault();

        var materia_id = $('#materia_id').val();
        var optNumero = $('#optNumero').val();
        var optNombre = $('#optNombre').val();
        var optClaveEspecifica = $('#optClaveEspecifica').val();

        if(materia_id && optNumero && optNombre && optClaveEspecifica){             
            $('#ubicacion_id').prop('disabled',true);
            $('#departamento_id').prop('disabled',true);
            $('#escuela_id').prop('disabled',true);
            $('#programa_id').prop('disabled',true);
            $('#plan_id').prop('disabled',true);
            $('#materia_id').prop('disabled',true);
            $('.submit-button').prop('disabled',false);

            tablaOptativa(materia_id,optNumero,optNombre,optClaveEspecifica);
            $('#optNumero').val('');
            $('#optNombre').val('');
            $('#optClaveEspecifica').val('');
        }else{
            swal('Ingrese todos los datos de la optativa para poder agregarla a lista');
        }
    });

    $('#tbl-optativas').on('click','.quitar', function () {
        $(this).closest('tr').remove();
        if($('#tbl-optativas tbody tr').length == 0){
            $('#ubicacion_id').prop('disabled',false);
            $('#departamento_id').prop('disabled',false);
            $('#escuela_id').prop('disabled',false);
            $('#programa_id').prop('disabled',false);
            $('#plan_id').prop('disabled',false);
            $('#materia_id').prop('disabled',false);
            $('.submit-button').prop('disabled',true);
        }
    });

});
</script>
@endsection