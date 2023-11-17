@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de Titulados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_titulados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de Titulados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>


            <hr>
            <div class="row">
              <div class="col s12 m4 14">
                <div class="input-field">
                  <p style="text-align:center;">Seleccione el tipo de Reporte</p>
                  <br>
                  <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;" required>
                    <option value="P" title="Solo alumnos titulados en el periodo que solicite" selected>Por Periodo</option>
                    <option value="E" title="Todos los titulados sin importar el periodo">Por Escuela</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <p id="periodoToolTip" style="text-align:center;">Periodo de Titulación</p>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número *', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$fechaActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año *', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Ubicaciones</p>
                <div class="input-field">
                  <select class="browser-default validate select2" name="ubiClave" id="ubiClave" style="width:100%;" required>
                    <option value="">Selecciona una Ubicación</option>
                    @foreach($ubicaciones as $key => $ubicacion)
                      <option value="{{$key}}">{{$ubicacion}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Departamentos</p>
                <div class="input-field">
                  <select class="browser-default validate select2" name="depClave" id="depClave" style="width:100%;" required>
                    @foreach($departamentos as $key => $departamento)
                      @if($key == 'T')
                        <option value="{{$key}}" selected>{{$departamento}}</option>
                      @else
                        <option value="{{$key}}">{{$departamento}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave','Clave de programa', array('class' => '')); !!}
                </div>
              </div>
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
  $(document).ready(function(){

    $('#tipoReporte').on('change',function(){
      
      var tipo = $(this).val();

      if(tipo == 'P'){
        $('#perAnio').attr({required:true,disabled:false});
        $('#perNumero').attr({required:true,disabled:false});
        $('#periodoToolTip').text('Indique el Periodo');
      }else if(tipo == 'E'){
        $('#perAnio').val('')
                     .attr({required:false,disabled:true});
        $('#perNumero').val('')
                       .attr({required:false,disabled:true});
        $('#periodoToolTip').text('No requiere Periodo');
      }

    });

  });
</script>
@endsection