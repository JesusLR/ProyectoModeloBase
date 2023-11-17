@extends('layouts.dashboard')

@section('template_title')
    Tutor
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tutores')}}" class="breadcrumb">Lista de Tutores</a>
    <a href="{{url('tutores/create')}}" class="breadcrumb">Agregar Tutor</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutores.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR TUTOR</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#alumnos">Alumnos</a></li>
                  {{-- <li class="tab"><a href="#tutores">Tutor</a></li> --}}
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutNombre', NULL, array('id' => 'tutNombre', 'class' => 'validate','required')) !!}
                        {!! Form::label('tutNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCalle', NULL, array('id' => 'tutCalle', 'class' => 'validate','required')) !!}
                        {!! Form::label('tutCalle', 'Calle', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutColonia', NULL, array('id' => 'tutColonia', 'class' => 'validate'))!!}
                        {!! Form::label('tutColonia', 'Colonia', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCodigoPostal', NULL, array('id' => 'tutCodigoPostal', 'class' => 'validate'))!!}
                        {!! Form::label('tutCodigoPostal', 'Código Postal', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutPoblacion', NULL, array('id' => 'tutPoblacion', 'class' => 'validate'))!!}
                        {!! Form::label('tutPoblacion', 'Población', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutEstado', NULL, array('id' => 'tutEstado', 'class' => 'validate'))!!}
                        {!! Form::label('tutEstado', 'Estado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutTelefono', NULL, array('id' => 'tutTelefono', 'class' => 'validate','required'))!!}
                        {!! Form::label('tutTelefono', 'Teléfono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCorreo', NULL, array('id' => 'tutCorreo', 'class' => 'validate'))!!}
                        {!! Form::label('tutCorreo', 'Correo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

            </div>

            {{-- ALUMNOS BAR--}}
            <div id="alumnos">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                        {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate'))!!}
                        {!! Form::label('aluClave', 'Clave del alumno', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                          <a name="buscarAlumno" id="buscarAlumno" class="waves-effect btn-large tooltipped" data-position="right" data-tooltip="Buscar alumno por su clave">
                            <i class=material-icons>search</i>
                          </a>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('nombreAlumno', NULL, array('id' => 'nombreAlumno', 'class' => 'validate'))!!}
                        {!! Form::label('nombreAlumno', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            <a name="vincularAlumno" id="vincularAlumno" class="waves-effect btn-large tooltipped #2e7d32 green darken-3" 
                            data-position="right" data-tooltip="Vincular alumno a este tutor">
                                <i class=material-icons>add</i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <table id="tbl-alumnos" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Clave del Alumno</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class=" material-icons left validar-campos">save</i> Guardar', ['class' => 'btn-guardar btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

    <script type="text/javascript">
        $(document).ready(function() {

            var aluClaves = null;

            $('#buscarAlumno').on('click', function () {
                var aluClave = $('#aluClave').val();
                if(aluClave){
                    buscarAlumno(aluClave);
                }else{
                    swal('Por favor introduzca la clave del alumno.');
                }
            });

            $('#vincularAlumno').on('click', function () {
                var aluClave = $('#aluClave').val();
                var nombreCompleto = $('#nombreAlumno').val();
                if(aluClave && nombreCompleto){
                    var alumno_row = '<tr>'+
                                        '<td><input type="hidden" name="aluClaves[]" value="'+aluClave+'"/>'+aluClave+'</td>'+
                                        '<td>'+nombreCompleto+'</td>'+
                                        '<td><a class="desvincular" style="cursor:pointer;" title="Desvincular">'+
                                            '<i class="material-icons">sync_disabled</i>'+
                                        '</a></td>'+
                                     '</tr>';
                    $('#tbl-alumnos tbody').append(alumno_row);
                    aluClaves = getColumnData('tbl-alumnos',0);//TEST
                }else{
                    swal('favor de introducir la clave del alumno y buscar de nuevo.');
                }
            });

            $('#tbl-alumnos').on('click','.desvincular', function () {
                $(this).closest('tr').remove();
                aluClaves = getColumnData('tbl-alumnos',0);//TEST
            });



            
        });

        /* ----------------------------------------------------------------------------- */

        function buscarAlumno(aluClave){
            $.ajax({
                url: base_url + '/api/tutores/buscarAlumno/' + aluClave,
                data: {aluClave: aluClave},
                success: function(data) {
                    if(data){
                        console.log(data);
                        var nombre = data.persona.perNombre;
                        var apellidos = data.persona.perApellido1 +' '+ data.persona.perApellido2;
                        $('#nombreAlumno').val(nombre +' '+ apellidos);
                        Materialize.updateTextFields();
                    }else{
                        swal({
                            title: 'Sin coincidencias...',
                            text: 'No se encontró alumno con esa clave.'
                                  + '\n Favor de verificar.',
                            icon: 'warning',
                        });
                    }
                }//success.
            });
        }//buscarAlumno.

        function getColumnData(table, column) {
            var columnData = new Array();
            $('#'+table+' tbody tr').each(function(row, tr) {
                var itemData = $(tr).find('td:eq('+column+')').text();
                columnData.push(itemData);
            });
            return columnData;
        }//getColumnData.

    </script>

@endsection