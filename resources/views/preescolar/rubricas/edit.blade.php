@extends('layouts.dashboard')

@section('template_title')
   Preescolar rúbrica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_rubricas')}}" class="breadcrumb">Lista de rubricas</a>
    <label class="breadcrumb">Editar rúbrica</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['preescolar.preescolar_rubricas.update', $rubrica->id])) }}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">EDITAR RÚBRICA #{{$rubrica->id}}</span>

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
                                {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                                        <option value="{{$rubrica->ubicacion_id}}">{{$rubrica->ubiClave.'-'.$rubrica->ubiNombre}}</option>
                                    </select>                                   
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="departamento_id" data-departamento-id="{{$rubrica->departamento_id}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                                        <option value="{{$rubrica->departamento_id}}">{{$rubrica->depClave.'-'.$rubrica->depNombre}}</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                                <div style="position: relative;">
                                    <select id="escuela_id" data-departamento-id="{{$rubrica->escuela_id}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                                        <option value="{{$rubrica->escuela_id}}" >{{$rubrica->escClave.'-'.$rubrica->escNombre}}</option>
                                    </select>                                   
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                                <select id="periodo_id" data-periodo-id="" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                    <option value="{{$rubrica->periodo_id}}">{{$rubrica->perNumero.'-'.$rubrica->perAnioPago}}</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                                {!! Form::date('perFechaInicial', $rubrica->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                                {!! Form::date('perFechaFinal', $rubrica->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="programa_id" data-programa-id="{{$rubrica->programa_id}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                                        <option value="{{$rubrica->programa_id}}" >{{$rubrica->progClave}}-{{$rubrica->progNombre}}</option>
                                        {{--  @foreach ($programas as $programa)
                                            <option value="{{$programa->id}}" {{ $programa->id == $rubrica->programa_id ? 'selected="selected"' : '' }}>{{$programa->progClave.'-'.$programa->progNombre}}</option>
                                        @endforeach  --}}
                                    </select>                                    
                                </div>
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('preescolar_rubricas_tipo_id', 'Tipo *', array('class' => '')); !!}
                                <select id="preescolar_rubricas_tipo_id" data-preescolar_rubricas_tipo="{{$rubrica->preescolar_rubricas_tipo_id}}" class="browser-default validate select2" required name="preescolar_rubricas_tipo_id" style="width: 100%;" required>
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    {{--  @foreach ($preescolar_rubricas_tipo as $tipo_rubrica)
                                        <option value="{{$tipo_rubrica->id}}" {{ $tipo_rubrica->id == $rubrica->preescolar_rubricas_tipo_id ? 'selected="selected"' : '' }}>{{$tipo_rubrica->tipo}}</option>
                                    @endforeach  --}}
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
                                <select id="grado" data-grado="{{$rubrica->grado}}" class="browser-default validate select2" required name="grado" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="1" {{ $rubrica->grado == "1" ? 'selected="selected"' : '' }}>1</option>
                                    <option value="2" {{ $rubrica->grado == "2" ? 'selected="selected"' : '' }}>2</option>
                                    <option value="3" {{ $rubrica->grado == "3" ? 'selected="selected"' : '' }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre1', 'Trimestre 1', array('class' => '')); !!}
                                <select id="trimestre1" class="browser-default validate select2" name="trimestre1" style="width: 100%;" required>
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="1" {{ $rubrica->trimestre1 == "1" ? 'selected="selected"' : '' }}>SI APLICA</option>
                                    <option value="" {{ $rubrica->trimestre1 == "" ? 'selected="selected"' : '' }}>NO APLICA</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre2', 'Trimestre 2', array('class' => '')); !!}
                                <select id="trimestre2" class="browser-default validate select2" name="trimestre2" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="2" {{ $rubrica->trimestre2 == "2" ? 'selected="selected"' : '' }}>SI APLICA</option>
                                    <option value="" {{ $rubrica->trimestre2 == "" ? 'selected="selected"' : '' }}>NO APLICA</option>
                                </select>
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre3', 'Trimestre 3', array('class' => '')); !!}
                                <select id="trimestre3" class="browser-default validate select2" name="trimestre3" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <<option value="3" {{ $rubrica->trimestre3 == "3" ? 'selected="selected"' : '' }}>SI APLICA</>
                                    <option value="" {{ $rubrica->trimestre3 == "" ? 'selected="selected"' : '' }}>NO APLICA</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col s12 m6 l4">
                                <div class="input-field">
                                {!! Form::text('rubrica', $rubrica->rubrica, array('id' => 'rubrica', 'class' => 'validate noUpperCase','required','maxlength'=>'255')) !!}
                                {!! Form::label('rubrica', 'Rúbrica *', array('class' => '')); !!}
                                </div>
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('aplica', ' Rúbrica Activada *', array('class' => '')); !!}
                                <select id="aplica" class="browser-default validate select2" name="aplica" style="width: 100%;" required>
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="SI" {{ $rubrica->aplica == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                    <option value="NO" {{ $rubrica->aplica == "NO" ? 'selected="selected"' : '' }}>NO</option>
                                </select>
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('orden_impresion', 'Ordenar despues de... *', array('class' => '')); !!}
                                <select id="orden_impresion" data-orden_impresion-id="" class="browser-default validate select2" name="orden_impresion" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

{{--  @include('preescolar.scripts.preferencias')
@include('preescolar.scripts.departamentos')
@include('preescolar.scripts.escuelas')
@include('preescolar.scripts.programas')
@include('preescolar.scripts.planes')  --}}
@include('preescolar.rubricas.getTipoRubrica')

<script type="text/javascript">
    $(document).ready(function() {


        var ubicacion_id = $("#ubicacion_id").val();
        var departamento_id = $("#departamento_id").data("departamento-id")

        var programa_id = $("#programa_id").data("programa-id")
        var grado = $("#grado").data("grado")


        /*function getDepartamentosPre(ubicacion_id, targetSelect = 'departamento_id', val = null, dataName = null) {

            var select = $('#' + targetSelect);
            var current_data = dataName || 'departamento-id';
            var current_value = val || select.data(current_data);
            //select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
             select.empty();
            $.ajax({
                type: 'GET',
                url: base_url + '/preescolar_rubricas/getDepartamentosPre/' + ubicacion_id,
                dataType: 'json',
                data: { ubicacion_id: ubicacion_id },
                success: function(departamentos) {
                    if (departamentos) {
                        $.each(departamentos, function(key, value) {
                            select.append(new Option(value.depClave + '-' + value.depNombre, value.id));
                            (value.id == current_value) && select.val(value.id);
                        });
                        select.trigger('change');
                        select.trigger('click');
                    }
                },
                error: function(Xhr, textMessage, errorMessage) {
                    console.log(errorMessage);
                }
            });
        } //getDepartamentos.**/

        function getRubricasPre(programa_id, grado, targetSelect = 'orden_impresion', val = null, dataName = null) {
            var select = $('#' + targetSelect);
            var current_data = dataName || 'rubrica-id';
            var current_value = val || select.data(current_data);
            select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
            $.ajax({
                type: 'GET',
                url: base_url + '/preescolar_rubricas/getRubricasPre/' + programa_id + '/' + grado,
                dataType: 'json',
                success: function(rubricas) {
                    if (rubricas) {
                        if (rubricas.length > 0) {
                            $.each(rubricas, function(key, value) {
                                select.append(new Option('En lugar de: '+value.rubrica, value.orden_impresion));
                                (value.orden_impresion == current_value) && select.val(value.orden_impresion);
                            });
                        } else {
                            select.append(new Option('SIN RESULTADOS', ''));
                        }
                        select.trigger('change');
                        select.trigger('click');
                    }
                },
                error: function(Xhr, textMessage, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }

        grado && getRubricasPre(programa_id, grado, 'orden_impresion');
        $('#grado').on('change', function() {
            grado_id = $(this).val();
            grado_id && getRubricasPre(programa_id, grado_id, 'orden_impresion');
        });

      /*var ubicacion_id = $('#ubicacion_id').val();
      var departamento_id = $('#departamento_id').val();
      var escuela_id = $('#escuela_id').val();
      var programa_id = $('#programa_id').val();
      let grado = $('#grado').val();
      var periodo_id = $('#periodo_id').val();
      var plan_id = $('#plan_id').val();*/


      /*ubicacion_id && getDepartamentosPre(ubicacion_id, 'departamento_id');
      $('#ubicacion_id').on('change', function() {
        ubicacion_id = $(this).val();
        ubicacion_id && getDepartamentosPre(ubicacion_id, 'departamento_id');
      });

      grado && getRubricasPre(programa_id, grado, 'orden_impresion');
      $('#grado').on('change', function() {
        grado_id = $(this).val();
        grado_id && getRubricasPre(programa_id, grado_id, 'orden_impresion');
      });

      if(departamento_id) {
        obtenerEscuelas(departamento_id, 'escuela_id');
        getPeriodos(departamento_id);
      }
      $('#departamento_id').on('change', function() {
        departamento_id = $(this).val();
        if(departamento_id) {
            obtenerEscuelas(departamento_id, 'escuela_id');
            getPeriodos(departamento_id);
        }
      });

      escuela_id && getProgramas(escuela_id, 'programa_id');
      $('#escuela_id').on('change', function() {
        escuela_id = $(this).val();
        escuela_id && getProgramas(escuela_id, 'programa_id');
      });

      programa_id && getPlanes(programa_id, 'plan_id');
      $('#programa_id').on('change', function() {
        programa_id = $(this).val();
        programa_id && getPlanes(programa_id, 'plan_id');
      });

      periodo_id && periodo_fechasInicioFin(periodo_id);
      $('#periodo_id').on('change', function() {
        periodo_id = $(this).val();
        periodo_id && periodo_fechasInicioFin(periodo_id);
        (periodo_id && plan_id) && getCgts_plan_periodo(plan_id, periodo_id, 'cgt_id');
      });

      (periodo_id && plan_id) && getCgts_plan_periodo(plan_id, periodo_id, 'cgt_id');
      $('#plan_id').on('change', function() {
        plan_id = $(this).val();
        (periodo_id && plan_id) && getCgts_plan_periodo(plan_id, periodo_id, 'cgt_id');
      });*/




    }); //document.ready




</script>

@endsection
