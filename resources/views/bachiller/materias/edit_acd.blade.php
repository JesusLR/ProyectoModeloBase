@extends('layouts.dashboard')

@section('template_title')
    Bachiller materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_materia')}}" class="breadcrumb">Lista de materias</a>
    <a href="{{route('bachiller.bachiller_materia.index_acd', ['materia_id' => $materia_acd->bachiller_materia_id, 'plan_id' => $materia_acd->plan_id])}}" class="breadcrumb">Lista de materias complementarias</a>
    <label class="breadcrumb">Editar materia complementaria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_materia_acd.update_acd', $materia_acd->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR MATERIA COMPLEMENTARIA #{{$materia_acd->id}} DE LA MATERIA: <b>{{$materia_acd->matClave.'-'.$materia_acd->matNombre}}</b></span>

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
                            <option value="{{$materia_acd->ubicacion_id}}}">{{$materia_acd->ubiClave.'-'.$materia_acd->ubiNombre}}</option>                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$materia_acd->departamento_id}}}">{{$materia_acd->depClave.'-'.$materia_acd->depNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$materia_acd->escuela_id}}}">{{$materia_acd->escClave.'-'.$materia_acd->escNombre}}</option> 
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-periodo-id="{{$materia_acd->periodo_id}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$materia_acd->programa_id}}}">{{$materia_acd->progClave.'-'.$materia_acd->progNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$materia_acd->plan_id}}">{{$materia_acd->planClave}}</option> 
                        </select>
                    </div>

                    <input type="hidden" name="bachiller_materia_id" id="bachiller_materia_id" value="{{$materia_acd->bachiller_materia_id}}">
                    <input type="hidden" name="gpoGrado" id="gpoGrado" value="{{$materia_acd->matSemestre}}">
                    <input type="hidden" name="bachiller_matClave" id="bachiller_matClave" value="{{$materia_acd->matClave}}">


                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoMatComplementaria', $materia_acd->gpoMatComplementaria, array('id' => 'gpoMatComplementaria', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('gpoMatComplementaria', 'Nombre materia *', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('bachiller_matPorcentajeCalificacion', $materia_acd->bachiller_matPorcentajeCalificacion, array('id' => 'bachiller_matPorcentajeCalificacion', 'class' => '','maxlength'=>'60')) !!}
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



@endsection