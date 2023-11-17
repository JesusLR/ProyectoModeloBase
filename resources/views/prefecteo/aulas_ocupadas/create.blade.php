@extends('layouts.dashboard')

@section('template_title')
    Prefecteo
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Aulas Ocupadas por Escuelas</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'aulas/ocupadas/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AULAS OCUPADAS POR ESCUELA</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                </ul>
              </div>
            </nav>
            {{-- GENERAL BAR--}}
            <div id="filtros">
                <div class="row">
                    <div class="col s12 m4 14" style="margin-top:10px;">
                        <p style="text-align:center;">Rango de horas para prefecteo</p>
                      <div class="input-field col s12 m6 14">
                        <select name="horas1" id="horas1" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar hora</option>
                          @foreach ($horas as $key => $item)
                          <option value="{{$key}}">{{$item}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="input-field col s12 m6 14">
                          {!! Form::label('horas2', 'Hora Final', ['class' => '']); !!}
                        <select name="horas2" id="horas2" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar hora</option>
                        </select>
                      </div>
                    </div>
                    {{-- <div class="col s12 m4 14">
                      <br>
                      <div class="input-field">
                        <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar Departamento</option>
                          @foreach ($departamentos as $key => $depto)
                          <option value="{{$key}}">{{$depto}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> --}}
                    <div class="col s12 m4 14">
                      <div class="input-field">
                        <p style="text-align:center;">Fecha de revisión</p>
                        {!! Form::date('fecharev', $fechaActual, array('id' => 'fecharev', 'class' => 'validate', 'required')) !!}
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                      <label for="ubicacion_id">Ubicación*</label>
                      <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                          @foreach($ubicaciones as $ubicacion)
                              <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="departamento_id">Departamento*</label>
                      <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="periodo_id">Periodo*</label>
                      <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                      <label for="escuela_id">Escuela</label>
                      <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="programa_id">Programa</label>
                      <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                </div>

                {{-- <div class="row">
                  <div class="col s12 m6 l4">
                        <p style="text-align:center;">Periodo</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                            {!! Form::label('perNumero', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0','max'=>$fechaActual->year, 'required')) !!}
                            {!! Form::label('perAnio', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                      <br>
                        <div class="input-field">
                            {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','required')) !!}
                            {!! Form::label('ubiClave', 'Clave de ubicación', array('class' => '')); !!}
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                            {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                            {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                        </div>
                    </div>
                </div> --}}

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <div class="preloader">
      <div id=""></div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection


@section('footer_scripts')


<script type="text/javascript">
    $(document).ready(function() {

      var ubicacion = $('#ubicacion_id');
      var departamento = $('#departamento_id');
      var escuela = $('#escuela_id');

      var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
      if(ubicacion_id) {
          ubicacion.val(ubicacion_id).select2();
          getDepartamentos(ubicacion_id);
      }

      ubicacion.on('change', function() {
          this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
      });

      departamento.on('change', function() {
          if(this.value) {
              getPeriodos(this.value);
              getEscuelas(this.value);
          } else {
              resetSelect('periodo_id');
              resetSelect('escuela_id');
          }
      });

      escuela.on('change', function() {
          this.value ? getProgramas(this.value) : resetSelect('programa_id');
      });


      $('#horas1').on('change',function(){
        var hora1 = parseInt($(this).val());
        var horas = {!! json_encode($horas) !!};

        if(hora1){
          var horas2 = [];
          $.each(horas,function(key,value){
            if(key >= hora1){
              horas2[key] = value;
            }
          });

          $('#horas2').empty();
          horas2.forEach(function(key,value){
            $('#horas2').append('<option value="'+ value +'">'+ key +'</option>');
          });
        }else{
          $('#horas2').empty();
        }

      });
    });
</script>
@endsection