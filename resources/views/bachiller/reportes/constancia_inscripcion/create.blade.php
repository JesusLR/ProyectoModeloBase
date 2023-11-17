@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Constancia de inscripción</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_constancia_inscripcion.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CONSTANCIA DE INSCRIPCIÓN</span>

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

                    <div class="col s12 m6 l4">
                      {!! Form::label('ubicaciones', 'Campus', ['class' => '',]); !!}
                      <select name="ubicaciones" id="ubicaciones" class="browser-default validate select2" style="width: 100%;" required>
                        <option value="">Seleccionar Ubicación</option>
                        @foreach ($ubicaciones as $item)
                            <option value="{{$item->id}}">{{$item->ubiNombre}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('matPeriodo', '¿Deseas incluir las materias que está cursando en el período?', ['class' => '']); !!}
                        <select name="matPeriodo" id="matPeriodo" class="browser-default validate select2" style="width: 100%;">
                            @foreach($materia_periodo as $key => $value)
                                <option value="{{$key}}" @if(old('matPeriodo') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('leyenda', 'Leyenda de los textos', ['class' => '']); !!}
                        <select name="leyenda" id="leyenda" class="browser-default validate select2" style="width: 100%;">
                            <option value="SEMESTRE">SEMESTRE</option>
                            <option value="GRADO">GRADO</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="perNumero">Número de periodo*</label>
                    <select name="perNumero" id="perNumero" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      <option value="1">1</option>
                      <option value="3">3</option>
                    </select>                
                    
                  </div>

                  <div class="col s12 m6 l4">
                    <label for="perAnio">Año*</label>
                    <select name="perAnio" id="perAnio" class="browser-default validate select2" style="width:100%;" required>
                      @for($i = $anioActual; $i > 1996; $i--)
                        <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>

                  {{--  <div class="col s12 m6 l4">
                    <label for="tipoVacacion">Periodo vacacional *</label>
                    <select name="tipoVacacion" id="tipoVacacion" class="browser-default validate select2" style="width:100%;" required>
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="P">Primavera</option>
                      <option value="V">Verano</option>
                      <option value="I">Invierno</option>
                    </select>
                  </div>  --}}
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <p class="center-align">Filtrar alumno por: *</p>
                        <div class="col s12 m6 l6">
                            <br>
                            <select name="buscar_por" id="buscar_por" class="browser-default validate select2" style="width:100%;">
                                <option value="clave">Clave de pago</option>
                                <option value="matricula">Matrícula</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="text" id="clave_matricula" name="clave_matricula" class="validate" placeholder="Escribe aquí*" required>
                        </div>
                    </div>
                </div>

                
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection


@section('footer_scripts')


<script type="text/javascript">
    $(document).ready(function() {
        $('#ubicaciones').on('change',function(){
            var ubicacion_id = $(this).val();
            if (ubicacion_id) {
                $.ajax({
                    processing : 'true',
                    serverSide : 'true',
                    url:"buscar/"+ubicacion_id,
                    method:"POST",
                    data : {ubicacion_id:ubicacion_id,"_token":"{{ csrf_token() }}"},
                    dataType:"json",
                    success:function(data){
                        console.log(data);
                        $('#firmante').empty();
                        $.each(data,function(key,value){
                            $('#firmante').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#firmante').empty();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        let select_buscar_por = $('#buscar_por');
    });
</script>

@endsection