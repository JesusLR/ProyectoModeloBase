@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Total de egresados y titulados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/total_egresados_tit/imprimir', 'method' => 'POST', 'id' => 'total_egresados_titulados']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Total de egresados y titulados por año escolar</span>
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
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 1, 'required')) !!}
                  {!! Form::label('perAnio', 'Año de inicio del ciclo anual *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('escClave', 'Clave de la escuela *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave de la carrera', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m12 l12">
                <div id="table-total-egresados" class="col s6"></div>
                <div id="table-total-titulados" class="col s6"></div>
              </div>
            </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">remove_red_eye</i> GENERAR ', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
{{-- Modal para mostrar los datos --}}
<div id="modalTotalEgresadosTitulados" class="modal">
  <div class="modal-content">
      <div class="row">
          <div class="col s12">
              <h4>Historial de pagos</h4>
              <p class="modalNombres"></p>
          </div>
      </div>


      <div class="row">
          <div class="col s12">
              <nav class="nav-extended">
                  <div class="nav-content">
                      <ul class="tabs tabs-transparent">
                          <li class="tab col s3"><a href="#tab1">Egresados</a></li>
                          <li class="tab col s3"><a href="#tab2">Titulados</a></li>
                      </ul>
                  </div>
              </nav>
          </div>
          
      </div>

      {{-- <div class="preloader-modal">
          <div id="preloader-modal"></div>
      </div> --}}
  </div>
  <div class="modal-footer">
      <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
  </div>
</div>
@endsection


@section('footer_scripts')

<script>
$(document).ready(function(){

$('#total_egresados_titulados').on('submit',function(e){
e.preventDefault();

var perAnio = $('#perAnio').val();
var escClave = $('#escClave').val();
var progClave = $('#progClave').val();

var table1 = "";
var table2 = "";

  $.ajax({
    processing : 'true',
    serverSide : 'true',
    method:"POST",
    url:"total_egresados_tit/imprimir",
    data:{perAnio:perAnio,escClave:escClave,progClave:progClave,"_token":"{{ csrf_token() }}"},
    dataType:"json",
    success:function(data){
      var egresados = data['egresados'];
      var titulados = data['titulados'];
      // Tabla de total de egresados
      table1+='<table class="striped responsive-table display" cellspacing="0" width="100%">';
      table1+='<h5 align="center">Total de Egresados</h5>'
      table1+='<tr><th>Periodo</th><th>Año</th><th>Carrera</th><th>Total</th></tr>'
      for(i = 0;i < egresados.length;i++){
      table1+='<tr>';
      table1+='<td>'+egresados[i]['Per']+'</td><td>'+egresados[i]['Año']+'</td><td>'+egresados[i]['Car']+'</td><td>'+egresados[i]['Total']+'</td></tr>'
      }
      table1+='</table>'
      $('#table-total-egresados').html(table1);
      // Tabla de total de titulados
      table2+='<table class="striped responsive-table display" cellspacing="0" width="100%">';
      table2+='<h5 align="center">Total de Titulados</h5>'
      table2+='<tr><th>Periodo</th><th>Año</th><th>Carrera</th><th>Total</th></tr>'
      for(i = 0;i < titulados.length;i++){
      table2+='<tr>';
      table2+='<td>'+titulados[i]['Per']+'</td><td>'+titulados[i]['Año']+'</td><td>'+titulados[i]['Car']+'</td><td>'+titulados[i]['Total']+'</td></tr>'
      }
      table2+='</table>'
      $('#table-total-titulados').html(table2);

      console.log(egresados,titulados);
    },
    error:function(){
      console.log("Ha ocurrido un error")
      table1="";
      table2="";
      $('#table-total-egresados').html(table1);
      $('#table-total-titulados').html(table2);

    }
  });
});

});

</script>

@endsection