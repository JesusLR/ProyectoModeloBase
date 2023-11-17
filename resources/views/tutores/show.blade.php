@extends('layouts.dashboard')

@section('template_title')
    Tutor
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tutores')}}" class="breadcrumb">Lista de tutores</a>
    <a href="{{url('tutores/'.$tutor->id)}}" class="breadcrumb">Ver tutor</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Tutor #{{$tutor->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#alumnos">Alumnos</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutNombre', $tutor->tutNombre, array('id' => 'tutNombre', 'class' => 'validate','required','readonly'=>'true')) !!}
                        {!! Form::label('tutNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCalle', $tutor->tutCalle, array('id' => 'tutCalle', 'class' => 'validate','required','readonly'=>'true')) !!}
                        {!! Form::label('tutCalle', 'Calle', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutColonia', $tutor->tutColonia, array('id' => 'tutColonia', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutColonia', 'Colonia', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCodigoPostal', $tutor->tutCodigoPostal, array('id' => 'tutCodigoPostal', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutCodigoPostal', 'Código Postal', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutPoblacion', $tutor->tutPoblacion, array('id' => 'tutPoblacion', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutPoblacion', 'Población', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutEstado', $tutor->tutEstado, array('id' => 'tutEstado', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutEstado', 'Estado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutTelefono', $tutor->tutTelefono, array('id' => 'tutTelefono', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutTelefono', 'Teléfono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('tutCorreo', $tutor->tutCorreo, array('id' => 'tutCorreo', 'class' => 'validate','readonly'=>'true'))!!}
                        {!! Form::label('tutCorreo', 'Correo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

            </div>

            {{-- PERSONAL BAR--}}
            <div id="alumnos">

                <br><br>

                <div class="row">
                    <div class="col s12">
                        <table id="tbl-alumnos" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Clave del Alumno</th>
                                <th>Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection

@section('footer_scripts')

<script type="text/javascript">
    $(document).ready(function () {

        var tutor_id = {!! json_encode($tutor->id) !!};

        alumnos_tutor(tutor_id);

    });

    /* ---------------------------------------------------------------------------------- */
    function alumnos_tutor(tutor_id){

        $.ajax({
            url: base_url+'/api/tutores/alumnos/'+tutor_id,
            dataType: 'json',
            data: {tutor_id: tutor_id},
            success: function (data) {
                if(data) {
                    $.each(data, function (key, value) {
                        console.log(value);
                        var persona = value.persona;
                        var aluClave = value.aluClave;
                        var nombreCompleto = persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2;
                        var alumno_row = '<tr>'+
                                            '<td><input type="hidden" name="aluClaves[]" value="'+aluClave+'"/>'+aluClave+'</td>'+
                                            '<td>'+nombreCompleto+'</td>'+
                                         '</tr>';
                        $('#tbl-alumnos tbody').append(alumno_row);
                    });
                }
            }
        });

    }// alumnos_tutor.
</script>

@endsection
