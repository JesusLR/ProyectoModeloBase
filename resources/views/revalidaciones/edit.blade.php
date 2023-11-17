@extends('layouts.dashboard')

@section('template_title')
    Revalidaciones
@endsection

@section('head')
  {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!} 
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('revalidaciones')}}" class="breadcrumb">Lista de alumnos</a>
    <label class="breadcrumb">Revalidación</label>
@endsection

@section('content')

@php
  $programa = $plan->programa;
  $escuela = $programa->escuela;
  $departamento = $escuela->departamento;
@endphp

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REVALIDACIÓN</span>

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
                    <label for="ubicacion_id">Ubicacion</label>
                    <select class="browser-default validate select2" data-ubicacion-id="{{$departamento->ubicacion_id}}" name="ubicacion_id" id="ubicacion_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                        <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="departamento_id">Departamento</label>
                    <select class="browser-default validate select2" data-departamento-id="{{$departamento->id}}" name="departamento_id" id="departamento_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <label for="escuela_id">Escuela</label>
                    <select class="browser-default validate select2" data-escuela-id="{{$escuela->id}}" name="escuela_id" id="escuela_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
              </div>

              <div class="row"> 
                  <div class="col s12 m6 l4">
                    <label for="programa_id">Programa</label>
                    <select class="browser-default validate select2" data-programa-id="{{$programa->id}}" name="programa_id" id="programa_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    <div class="col s12 m6 l6">
                      <label for="plan_id">Plan</label>
                      <select class="browser-default validate select2" data-plan-id="{{$plan->id}}" name="plan_id" id="plan_id" style="width:100%;" required>
                        <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                    </div>
                  </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    <input type="number" name="aluClave" id="aluClave" class="validate" value="{{$alumno->aluClave}}">
                    <label for="aluClave">Clave de pago</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input type="text" name="aluMatricula" id="aluMatricula" class="validate" value="{{$alumno->aluMatricula}}">
                    <label for="aluMatricula">Matrícula</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="text" name="nombreCompleto" id="nombreCompleto" class="validate" value="{{$alumno->persona->nombreCompleto()}}">
                    <label for="nombreCompleto">Nombre del alumno</label>
                  </div>
                </div>
              </div>

              <div class="row">
                  <div class="col s12">
                      <table id="tbl-materias" class="responsive-table display" cellspacing="0" width="100%">
                          <thead>
                          <tr>
                              <th>Folio</th>
                              <th>Clave <br> Materia</th>
                              <th>Nombre</th>
                              <th>Tipo <br> Acred.</th>
                              <th>Semestre</th>
                              <th>Plan</th>
                              <th>Acciones</th>
                          </tr>
                          </thead>
                          <tfoot>
                          <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th class="non_searchable"></th>
                          </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>

              <div class="preloader">
                  <div id="preloader"></div>
              </div>
                
          </div>
        </div>
    </div>
  </div>

  <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}


<script type="text/javascript">
  $(document).ready(function() {
    let ubicacion = $('#ubicacion_id');
    let departamento = $('#departamento_id');
    let escuela = $('#escuela_id');
    let programa = $('#programa_id');
    let plan = $('#plan_id');

    apply_data_to_select('ubicacion_id', 'ubicacion-id');

    ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
    ubicacion.on('change', function() {
      this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
    });

    departamento.on('change', function() {
      this.value ? getEscuelas(this.value) : resetSelect('escuela_id');
    });

    escuela.on('change', function() {
      this.value ? getProgramas(this.value) : resetSelect('programa_id');
    });

    programa.on('change', function() {
      this.value ? getPlanes(this.value) : resetSelect('plan_id');
    });

  });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        let resumen_id = {!!json_decode($resumen->id)!!};
        $('#tbl-materias').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/revalidaciones/" + resumen_id + "/materias_faltantes",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "id", data: "id"},
                {data: "matClave", name:'matClave'},
                {data: "matNombre", name: "matNombre"},
                {data: "matTipoAcreditacion", name:"matTipoAcreditacion"},
                {data: "matSemestre", name:"matSemestre"},
                {data: "plan.planClave", name:"plan.planClave"},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))


                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");
                        

                        var columnDataOld = searchFill.columns[index].search.search
                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    index ++
                });
            },
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }
        });
    });
</script>
@endsection