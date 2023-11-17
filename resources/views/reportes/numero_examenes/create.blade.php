@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Número de exámenes ordinarios y extraordinarios</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/numero_examenes/imprimir', 'method' => 'POST', 'id' => 'numero_examenes']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Número de exámenes ordinarios y extraordinarios</span>
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
              <div class="col s12 m6 l6">
                <div class="input-field">
                  {!! Form::text('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','required')) !!}
                  {!! Form::label('perNumero', 'Número del período *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l6">
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 1, 'required')) !!}
                  {!! Form::label('perAnio', 'Año del período *', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m12 l12">
                <div id="table-ordinarios" class="col s4"></div>
                <div id="table-extraordinarios" class="col s4"></div>
                <div id="table-inscritos" class="col s4"></div>
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

@endsection


@section('footer_scripts')

<script>
$(document).ready(function(){

$('#numero_examenes').on('submit',function(e){
e.preventDefault();

var perNumero = $('#perNumero').val();
var perAnio = $('#perAnio').val();

var tableOrdinarios = "";
var tableExtraordinarios = "";
var tableInscritos = "";

  $.ajax({
    processing : 'true',
    serverSide : 'true',
    method:"POST",
    url:"numero_examenes/imprimir",
    data:{perNumero:perNumero,perAnio:perAnio,"_token":"{{ csrf_token() }}"},
    dataType:"json",
    success:function(data){
      var ordinarios = data['ordinarios'];
      var extraordinarios = data['extraordinarios'];
      var inscritos = data['inscritos'];

      // Tabla de Número de exámenes ordinarios
      tableOrdinarios+='<table class="striped responsive-table display" cellspacing="0" width="100%">';
      tableOrdinarios+='<p style="font-size:18px; text-align:center;">Número de exámenes ordinarios</p>'
      tableOrdinarios+='<tr><th>Ubi</th><th>Dep</th><th>Num Ord</th></tr>'
      for(i = 0;i < ordinarios.length;i++){
      tableOrdinarios+='<tr>';
      tableOrdinarios+='<td>'+ordinarios[i]['Ubi']+'</td><td>'+ordinarios[i]['Dep']+'</td><td>'+ordinarios[i]['Num Ord']+'</td></tr>'
      }
      tableOrdinarios+='</table>'
      $('#table-ordinarios').html(tableOrdinarios);

      // Tabla de Número de exámenes extraordinarios
      tableExtraordinarios+='<table class="striped responsive-table display" cellspacing="0" width="100%">';
      tableExtraordinarios+='<p style="font-size:18px; text-align:center;">Número de exámenes extraordinarios</p>'
      tableExtraordinarios+='<tr><th>Ubi</th><th>Niv</th><th>Num Ext</th></tr>'
      for(i = 0;i < extraordinarios.length;i++){
      tableExtraordinarios+='<tr>';
      tableExtraordinarios+='<td>'+extraordinarios[i]['Ubi']+'</td><td>'+extraordinarios[i]['Niv']+'</td><td>'+extraordinarios[i]['Num Ext']+'</td></tr>'
      }
      tableExtraordinarios+='</table>'
      $('#table-extraordinarios').html(tableExtraordinarios);

      // Tabla de Número de inscritos
      tableInscritos+='<table class="striped responsive-table display" cellspacing="0" width="100%">';
      tableInscritos+='<p style="font-size:18px; text-align:center;">Número de total de inscritos</p>'
      tableInscritos+='<tr><th>Ubi</th><th>Dep</th><th>Tipo</th><th>Num Insc</th></tr>'
      for(i = 0;i < inscritos.length;i++){
      tableInscritos+='<tr>';
      tableInscritos+='<td>'+inscritos[i]['Ubi']+'</td><td>'+inscritos[i]['Dep']+'</td><td>'+inscritos[i]['Tipo']+'</td><td>'+inscritos[i]['Num Insc']+'</td></tr>'
      }
      tableInscritos+='</table>'
      $('#table-inscritos').html(tableInscritos);

      console.log(ordinarios,extraordinarios,inscritos);
    },
    error:function(){
      console.log("Ha ocurrido un error")
      tableOrdinarios="";
      tableExtraordinarios="";
      tableInscritos="";
      $('#table-ordinarios').html(tableOrdinarios);
      $('#table-extraordinarios').html(tableExtraordinarios);
      $('#table-inscritos').html(tableInscritos);
    }
  });
});

});

</script>

@endsection