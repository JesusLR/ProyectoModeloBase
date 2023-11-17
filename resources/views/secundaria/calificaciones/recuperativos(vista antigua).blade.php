@extends('layouts.dashboard')

@section('template_title')
Secundaria calificaciones
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_grupo')}}" class="breadcrumb">Inicio</a>
<a href="{{route('secundaria.secundaria_grupo.index')}}" class="breadcrumb">Lista de Grupo</a>
<a href="{{route('secundaria.secundaria_grupo.calificaciones.recuperativos', [$secundaria_inscritos[0]->grupo_id])}}" class="breadcrumb">Calificar recuperativo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CALIFICAR RECUPERATIVOS #{{$secundaria_inscritos[0]->grupo_id}}</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">Recuperativos</a></li>
                        </ul>
                    </div>
                </nav>

                <br>

                    <p style="font-size:  18px;"><b>Período: </b>{{\Carbon\Carbon::parse($secundaria_inscritos[0]->perFechaInicial)->format('Y')}}-{{\Carbon\Carbon::parse($secundaria_inscritos[0]->perFechaFinal)->format('Y')}}</p>

                    <p style="font-size:  18px;"><b>Grado y grupo: </b>{{$secundaria_inscritos[0]->gpoGrado}}-{{$secundaria_inscritos[0]->gpoClave}}</p>

                    <p style="font-size:  18px;"><b>Materia: </b>{{$secundaria_inscritos[0]->matClave.'-'.$secundaria_inscritos[0]->matNombre}}</p>

                    @if ($secundaria_inscritos[0]->gpoMatComplementaria != "")
                    <p style="font-size:  18px;"><b>Materia ACD: </b>{{$secundaria_inscritos[0]->gpoMatComplementaria}}</p>
                    @endif                   
                    
                    <p style="font-size:  18px;"><b>Docente: </b>{{$secundaria_inscritos[0]->empApellido1.' '.$secundaria_inscritos[0]->empApellido2.' '.$secundaria_inscritos[0]->empNombre}}</p>
                {{-- GENERAL BAR--}}
                <div id="general">
                    {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_calificacion.guardarCalificacionRecuperativo', 'method' => 'POST']) !!}
                        <br>
                
                        <div class="row" id="Tabla">
                            <div class="col s12">
                                <table class="responsive-table display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">ID</th>
                                            <th>#</th>
                                            <th align="center">Clave Pago</th>
                                            <th align="center">Nombre Completo</th>

                                            @if ($secundaria_inscritos[0]->gpoMatComplementaria != "")
                                            <th id="claveGrupo" align="center">Clave Grupo</th>
                                            @endif
                                           
        
                                            <th class="classEvi1" align="center">Calificación Trimestre 1</th>
                                            <th class="classEvi2" align="center">Calificación Trimestre 2</th>
                                            <th class="classEvi2" align="center">Calificación Trimestre 3</th>

                                            
        
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @php
                                            $total = 1;
                                        @endphp
                                        @foreach ($secundaria_inscritos as $inscrito)
        
                                            @if ($inscrito->inscTrimestre1 != "" && $inscrito->inscTrimestre1 < 6 || $inscrito->inscTrimestre2 != "" && $inscrito->inscTrimestre2 < 6 || $inscrito->inscTrimestre3 != "" && $inscrito->inscTrimestre3 < 6)
                                            <tr>
                                                <td style="display: none;"><input type="text" name="secundaria_inscrito_id[]" value="{{$inscrito->id}}"></td>
                                                <td align="center">{{$total++}}</td>
                                                <td align="center">{{$inscrito->aluClave}}</td>
                                                <td align="center">{{$inscrito->perApellido1.' '.$inscrito->perApellido2.' '.$inscrito->perNombre}}</td>

                                                @if ($secundaria_inscritos[0]->gpoMatComplementaria != "")
                                                <td align="center">{{$inscrito->cgtGrupo}}</td>
                                                @endif
        
                                                @if ($inscrito->inscTrimestre1 != "")
                                                    @if ($inscrito->inscTrimestre1 < 6)
                                                        <td align="center"><div class='form-check checkbox-warning-filled'>
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per1{{$inscrito->id}}" id="NP1_{{$inscrito->id}}"><label style="color: #000" for="NP1_{{$inscrito->id}}">NP</label>
                                                            <br>    
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per1{{$inscrito->id}}" id="NA1_{{$inscrito->id}}"><label style="color: #000" for="NA1_{{$inscrito->id}}">NA</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input tabindex="1" style="border-color:#01579B; width : 130px;" id='recuperativo1_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='{{$inscrito->inscRecuperativoTrimestre1}}' lang="en" name='inscRecuperativoTrimestre1[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'>
                                                            <input style="width: 130px; display:none;" type="text" value="" id='no_presento_recupe1{{$inscrito->id}}'></div>
                                                        </td>
                                                        <script>

                                                            //para cuando NO PRESENTA
                                                            $('#NP1_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo1_{{$inscrito->id}}").val("-1");
                                                                    $('#recuperativo1_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo1_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").val("NO PRESENTO");

                                                                } else {
                                                                    $("#recuperativo1_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo1_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo1_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").hide();
                                                                }
                                                            });

                                                            //para cuando NO APRUEBA
                                                            $('#NA1_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo1_{{$inscrito->id}}").val("-2");
                                                                    $('#recuperativo1_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo1_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").val("NO APROBO");

                                                                } else {
                                                                    $("#recuperativo1_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo1_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo1_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").hide();
                                                                }
                                                            });




                                                            if("{{$inscrito->inscRecuperativoTrimestre1}}" == -1){
                                                                $("#NP1_{{$inscrito->id}}").prop('checked', true);
                                                                $('#recuperativo1_{{$inscrito->id}}').prop('readonly', true);
                                                                $('#recuperativo1_{{$inscrito->id}}').hide();
                                                                $("#no_presento_recupe1{{$inscrito->id}}").show();
                                                                $('#no_presento_recupe1{{$inscrito->id}}').prop('readonly', true);
                                                                $("#no_presento_recupe1{{$inscrito->id}}").val("NO PRESENTO");
                                                                $('#recuperativo1_{{$inscrito->id}}').val(-1);

                                                            }else{
                                                                if("{{$inscrito->inscRecuperativoTrimestre1}}" == -2){
                                                                    $("#NA1_{{$inscrito->id}}").prop('checked', true);
                                                                    $('#recuperativo1_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo1_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").show();
                                                                    $('#no_presento_recupe1{{$inscrito->id}}').prop('readonly', true);
                                                                    $("#no_presento_recupe1{{$inscrito->id}}").val("NO APROBO");
                                                                    $('#recuperativo1_{{$inscrito->id}}').val(-2);
    
                                                                }
                                                            }

                                                            
                                                        </script>
                                                    @else
                                                        <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo1_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre1[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                    @endif
                                                @else
                                                    <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo1_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre1[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                @endif
        
                                                @if ($inscrito->inscTrimestre2 != "")
                                                    @if ($inscrito->inscTrimestre2 < 6)
                                                        <td align="center"><div class='form-check checkbox-warning-filled'>
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per2{{$inscrito->id}}" id="NP2_{{$inscrito->id}}"><label style="color: #000" for="NP2_{{$inscrito->id}}">NP</label>
                                                            <br>    
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per2{{$inscrito->id}}" id="NA2_{{$inscrito->id}}"><label style="color: #000" for="NA2_{{$inscrito->id}}">NA</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input tabindex="2" style="border-color:#01579B; width : 130px;" id='recuperativo2_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='{{$inscrito->inscRecuperativoTrimestre2}}' lang="en" name='inscRecuperativoTrimestre2[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'>
                                                            <input style="width: 130px; display:none;" type="text" value="" id='no_presento_recupe2{{$inscrito->id}}'></div>
                                                        </td>
                                                        <script>

                                                            //para cuando NO PRESENTA
                                                            $('#NP2_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo2_{{$inscrito->id}}").val("-1");
                                                                    $('#recuperativo2_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo2_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").val("NO PRESENTO");

                                                                } else {
                                                                    $("#recuperativo2_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo2_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo2_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").hide();
                                                                }
                                                            });

                                                            //para cuando NO APRUEBA
                                                            $('#NA2_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo2_{{$inscrito->id}}").val("-2");
                                                                    $('#recuperativo2_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo2_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").val("NO APROBO");

                                                                } else {
                                                                    $("#recuperativo2_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo2_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo2_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").hide();
                                                                }
                                                            });




                                                            if("{{$inscrito->inscRecuperativoTrimestre2}}" == -1){
                                                                $("#NP2_{{$inscrito->id}}").prop('checked', true);
                                                                $('#recuperativo2_{{$inscrito->id}}').prop('readonly', true);
                                                                $('#recuperativo2_{{$inscrito->id}}').hide();
                                                                $("#no_presento_recupe2{{$inscrito->id}}").show();
                                                                $('#no_presento_recupe2{{$inscrito->id}}').prop('readonly', true);
                                                                $("#no_presento_recupe2{{$inscrito->id}}").val("NO PRESENTO");
                                                                $('#recuperativo2_{{$inscrito->id}}').val(-1);

                                                            }else{
                                                                if("{{$inscrito->inscRecuperativoTrimestre2}}" == -2){
                                                                    $("#NA2_{{$inscrito->id}}").prop('checked', true);
                                                                    $('#recuperativo2_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo2_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").show();
                                                                    $('#no_presento_recupe2{{$inscrito->id}}').prop('readonly', true);
                                                                    $("#no_presento_recupe2{{$inscrito->id}}").val("NO APROBO");
                                                                    $('#recuperativo2_{{$inscrito->id}}').val(-2);

                                                                }
                                                            }

                                                            
                                                        </script>
                                                    @else
                                                        <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo2_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre2[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                    @endif
                                                @else
                                                    <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo2_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre2[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                @endif

                                                @if ($inscrito->inscTrimestre3 != "")
                                                    @if ($inscrito->inscTrimestre3 < 6)
                                                        <td align="center"><div class='form-check checkbox-warning-filled'>
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per3{{$inscrito->id}}" id="NP3_{{$inscrito->id}}"><label style="color: #000" for="NP3_{{$inscrito->id}}">NP</label>
                                                            <br>    
                                                            <input type="checkbox" class="form-check-input filled-in" name="que_le_paso_al_alumno_per3{{$inscrito->id}}" id="NA3_{{$inscrito->id}}"><label style="color: #000" for="NA3_{{$inscrito->id}}">NA</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input tabindex="3" style="border-color:#01579B; width : 130px;" id='recuperativo3_{{$inscrito->id}}' onKeyUp="if(this.value>7){this.value='';}else if(this.value<0){this.value='';}" value='{{$inscrito->inscRecuperativoTrimestre3}}' lang="en" name='inscRecuperativoTrimestre3[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'>
                                                            <input style="width: 130px; display:none;" type="text" value="" id='no_presento_recupe3{{$inscrito->id}}'></div>
                                                        </td>
                                                        <script>

                                                            //para cuando NO PRESENTA
                                                            $('#NP3_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo3_{{$inscrito->id}}").val("-1");
                                                                    $('#recuperativo3_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo3_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").val("NO PRESENTO");

                                                                } else {
                                                                    $("#recuperativo3_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo3_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo3_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").hide();
                                                                }
                                                            });

                                                            //para cuando NO APRUEBA
                                                            $('#NA3_{{$inscrito->id}}').on( 'click', function() {
                                                                if( $(this).is(':checked') ){
                                                                    $("#recuperativo3_{{$inscrito->id}}").val("-2");
                                                                    $('#recuperativo3_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo3_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").show();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").val("NO APROBO");

                                                                } else {
                                                                    $("#recuperativo3_{{$inscrito->id}}").val("");
                                                                    $('#recuperativo3_{{$inscrito->id}}').prop('readonly', false);
                                                                    $('#recuperativo3_{{$inscrito->id}}').show();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").hide();
                                                                }
                                                            });




                                                            if("{{$inscrito->inscRecuperativoTrimestre3}}" == -1){
                                                                $("#NP3_{{$inscrito->id}}").prop('checked', true);
                                                                $('#recuperativo3_{{$inscrito->id}}').prop('readonly', true);
                                                                $('#recuperativo3_{{$inscrito->id}}').hide();
                                                                $("#no_presento_recupe3{{$inscrito->id}}").show();
                                                                $('#no_presento_recupe3{{$inscrito->id}}').prop('readonly', true);
                                                                $("#no_presento_recupe3{{$inscrito->id}}").val("NO PRESENTO");
                                                                $('#recuperativo3_{{$inscrito->id}}').val(-1);

                                                            }else{
                                                                if("{{$inscrito->inscRecuperativoTrimestre3}}" == -2){
                                                                    $("#NA3_{{$inscrito->id}}").prop('checked', true);
                                                                    $('#recuperativo3_{{$inscrito->id}}').prop('readonly', true);
                                                                    $('#recuperativo3_{{$inscrito->id}}').hide();
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").show();
                                                                    $('#no_presento_recupe3{{$inscrito->id}}').prop('readonly', true);
                                                                    $("#no_presento_recupe3{{$inscrito->id}}").val("NO APROBO");
                                                                    $('#recuperativo3_{{$inscrito->id}}').val(-2);

                                                                }
                                                            }

                                                            
                                                        </script>
                                                    @else
                                                        <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo3_{{$inscrito->id}}' onKeyUp="if(this.value>6){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre3[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                    @endif
                                                @else
                                                    <td align="center"><input readonly style='background: transparent; border: none;' id='recuperativo3_{{$inscrito->id}}' onKeyUp="if(this.value>6){this.value='';}else if(this.value<0){this.value='';}" value='' lang="en" name='inscRecuperativoTrimestre3[]' step="0.1" type='number' min="0" max="10" class='noUpperCase'></td>
                                                @endif

                                                
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="card-action">
                            {!! Form::button('<i class="material-icons left">save</i> Guardar',
                            ['onclick'=>'this.disabled=true;this.innerText="Guardando datos...";this.form.submit(); mostrarAlerta();','class' =>
                            'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                

            </div>

            
        </div>

    </div>
    
</div>



<style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table th {
      background: #01579B;
      color: #fff;

    }
    table {
      border-collapse: collapse;
      width: 100%;
    }

    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
        border-color: #01579B;
        background-color: #01579B;
      } 
</style>

@endsection

@section('footer_scripts')

<script>
  
    function mostrarAlerta(){

        //$("#submit-button").prop('disabled', true);
        var html = "";
        html += "<div class='preloader-wrapper big active'>"+
            "<div class='spinner-layer spinner-blue-only'>"+
              "<div class='circle-clipper left'>"+
                "<div class='circle'></div>"+
              "</div><div class='gap-patch'>"+
                "<div class='circle'></div>"+
              "</div><div class='circle-clipper right'>"+
                "<div class='circle'></div>"+
              "</div>"+
            "</div>"+
          "</div>";

        html += "<p>" + "</p>"

        swal({
            html:true,
            title: "Guardando...",
            text: html,
            showConfirmButton: false
            //confirmButtonText: "Ok",
        })

       
    }

</script>

<script>
    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $box.prop("checked", false);
        }
      });
</script>

@endsection



