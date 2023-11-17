@extends('layouts.dashboard')

@section('template_title')
Bachiller pago recuperativo
@endsection

@section('breadcrumbs')
<a href="{{ url('bachiller_curso') }}" class="breadcrumb">Inicio</a>
<a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativo</a>
<a href="{{url('solicitudes/bachiller_recuperativos')}}" class="breadcrumb">Lista de solicitudes</a>
<a href="" class="breadcrumb">Pago de recuperativos</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open([
        'onKeypress' => 'return disableEnterKey(event)',
        'route' => 'bachiller_recuperativos.cambio_estado_pago',
        'method' => 'POST'
        ]) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">PAGO DE RECUPERATIVOS</span>

                {{-- NAVIGATION BAR --}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR --}}
                <div id="filtros">

                    @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                    @endphp



                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('curEstado', 'Ubicación*', ['class' => '']) !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($ubicaciones as $ubicacion)
                                @php
                                $selected = '';

                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if ($ubicacion->id == $ubicacion_id && !old('ubicacion_id')) {
                                echo '<option value="' . $ubicacion->id . '" selected>' . $ubicacion->ubiClave . '-' .
                                    $ubicacion->ubiNombre . '</option>';
                                } else {
                                if ($ubicacion->id == old('ubicacion_id')) {
                                $selected = 'selected';
                                }

                                echo '<option value="' . $ubicacion->id . '" ' . $selected . '>' . $ubicacion->ubiClave
                                    . '-' . $ubicacion->ubiNombre . '</option>';
                                }
                                @endphp
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="departamento_id">Departamento*</label>
                            <select name="departamento_id" id="departamento_id"
                                data-departamento-id="{{ old('departamento_id') }}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="escuela_id">Escuela *</label>
                            <select name="escuela_id" id="escuela_id" data-escuela-id="{{ old('escuela_id') }}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="periodo_id">Período *</label>
                            <select name="periodo_id" id="periodo_id" data-escuela-id="{{ old('periodo_id') }}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="programa_id">Programa *</label>
                            <select name="programa_id" id="programa_id" data-programa-id="{{ old('programa_id') }}"
                                class="browser-default validate select2" style="width:100%;">
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="plan_id">Plan *</label>
                            <select name="plan_id" id="plan_id" data-plan-id="{{ old('plan_id') }}"
                                class="browser-default validate select2" style="width:100%;">
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="alumno_id">Alumno *</label>
                            <select name="alumno_id" id="alumno_id" data-alumno-id="{{ old('alumno_id') }}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA ALUMNO</option>
                            </select>
                        </div>



                    </div>

                    <br>
                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                        </div>
                        <div class="col s12 m6 l4">
                        </div>
                        <div class="col s12 m6 l4" style="text-align: center;">
                            <label style="color: #000000; font-size: 20px; display: none;" id="monto_costo"></label>
                        </div>
                    </div>


                </div>
                <div class="card-action">
                    <button style="display: none;" class="btn-large waves-effect darken-3 boton-guardar">GUARDAR <i
                            class="material-icons left">save</i></button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if (\Session::has('success'))
    <input type="hidden" value="{!! Session::has('msg') ? Session::get(" msg") : '' !!}" name="nuevo_id" id="nuevo_id">

    <script>
        var nuevo_id = $("#nuevo_id").val();
                
            

                $.ajax({
                    url: "{{route('bachiller.bachiller_pago_certificado.imprimir')}}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "_token": $("meta[name=csrf-token]").attr("content"),
                        nuevo_id: nuevo_id                            
                    },
                        
                    success: function(data){

                        console.log('si llega aqui ' +data.res)

                        var id = data.res;
                        window.open("/bachiller_pago_certificado/imprimir/"+id,"_blank");
                                
                    
                    }
                });
    </script>
    @endif
    @endsection




    @section('footer_scripts')
    @include('bachiller.scripts.preferencias')
    @include('bachiller.scripts.departamentos')
    @include('bachiller.scripts.escuelas')
    @include('bachiller.scripts.programas')
    @include('bachiller.scripts.planes-espesificos')
    <script>
        function recuperarFecha() {

                $("#fechaFin").val($("#fechaInicio").val());
                $('#fechaFin').attr('min', $("#fechaInicio").val());
            }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

                $("#periodo_id").change(event => {

                    var plan_id = $("#plan_id").val();
                    var alumnoOld = $("#alumno_id").data("alumno-id")

                    $("#alumno_id").empty();
                    $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


                    $.get(base_url +
                        `/bachiller_recuperativos/getAlumnosCursoRecu/${event.target.value}/${plan_id}`,
                        function(res,
                            sta) {

                            var alumnos = res.alumnos;

                           
                            res.forEach(element => {
                                var selected = "";
                                if (element.alumno_id === alumnoOld) {
                                    selected = "selected";
                                }

                                $("#alumno_id").append(
                                    `<option value='${element.alumno_id}' ${selected}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`
                                );
                            });
                        });
                });

                $("#plan_id").change(event => {

                    var periodo_id = $("#periodo_id").val();
                    var alumnoOld = $("#alumno_id").data("alumno-id")

                    $("#alumno_id").empty();
                    $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


                    $.get(base_url +
                        `/bachiller_recuperativos/getAlumnosCursoRecu/${periodo_id}/${event.target.value}`,
                        function(
                            res, sta) {
                            
                            var alumnos = res.alumnos;
                            
                            res.alumnos.forEach(element => {
                                var selected = "";
                                if (element.alumno_id === alumnoOld) {
                                    selected = "selected";
                                }

                                $("#alumno_id").append(
                                    `<option value='${element.alumno_id}' ${selected}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`
                                );
                            });
                        });
                });

            });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

        //por periodo
        $("#periodo_id").change(event => {
            var plan_id = $("#plan_id").val();
            var alumno_id = $("#alumno_id").val();
    
    
            $.get(base_url + `/bachiller_recuperativos/pago_recuperativo/extras_cargadas/${event.target.value}/${plan_id}/${alumno_id}`, function(res, sta) {
    
                var materiaCargadas = res.materiaCargadas;
                if (materiaCargadas.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr>";                  
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Costo</strong></td>";
                        myTable += "</tr>";

                        var suma = 0;
                        let costo = 0;
                        var arr = [];
    
                        for (let i = 0; i < materiaCargadas.length; i++) {
    
                            let num = [i + 1];
                            
    
                            
    
                            myTable += `<tr><td> ${num}</td>`;

                            myTable += `<td style="display: none;"><input type="checkbox" checked name="inscrito_extra_id[]" id="inscrito_extra_id_${materiaCargadas[i].id}" value="${materiaCargadas[i].id}"><label for="inscrito_extra_id_${materiaCargadas[i].id}">${materiaCargadas[i].id}</label></td>`;

                            myTable += `<td> ${materiaCargadas[i].matClave}-${materiaCargadas[i].matNombre} </td>`;

                            
                            if(materiaCargadas[i].extTipo == "RECURSAMIENTO"){
                                costo = materiaCargadas[i].frImporteRecursamiento;
                                
                            }

                            if(materiaCargadas[i].extTipo == "ACOMPAÑAMIENTO"){
                                costo = materiaCargadas[i].frImporteAcomp;
                                
                            }

                            

                            myTable += "<td>" + costo + "</td>";    


                            arr.push(Number(costo));
                           
                            myTable += "</tr>";  

                            
    
    
                        }

                        

    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        let total=0,numeros = arr;
                        numeros.forEach(function(a){total += a;});
                        console.log(total);

                        $("#monto_costo").show();
                        $("#monto_costo").text("Total: $" + total);
    
                        $(".boton-guardar").show();
    
                        //muestra el boton guardar
                        //$(".boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#monto_costo").hide();
                    $("#monto_costo").text("");

                    $(".boton-guardar").hide();
    
    
                }
    
            });
        });    

        //por plan
        $("#plan_id").change(event => {
            var alumno_id = $("#alumno_id").val();
            var periodo_id = $("#periodo_id").val();

    
    
            $.get(base_url + `/bachiller_recuperativos/pago_recuperativo/extras_cargadas/${periodo_id}/${event.target.value}/${alumno_id}`, function(res, sta) {
    
                var materiaCargadas = res.materiaCargadas;
                if (materiaCargadas.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr>";                  
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Costo</strong></td>";
                        myTable += "</tr>";

                        var suma = 0;
                        let costo = 0;
                        var arr = [];
    
                        for (let i = 0; i < materiaCargadas.length; i++) {
    
                            let num = [i + 1];
                            
    
                            
    
                            myTable += `<tr><td> ${num}</td>`;

                                myTable += `<td style="display: none;"><input type="checkbox" checked name="inscrito_extra_id[]" id="inscrito_extra_id_${materiaCargadas[i].id}" value="${materiaCargadas[i].id}"><label for="inscrito_extra_id_${materiaCargadas[i].id}">${materiaCargadas[i].id}</label></td>`;

                                myTable += `<td> ${materiaCargadas[i].matClave}-${materiaCargadas[i].matNombre} </td>`;

                            
                            if(materiaCargadas[i].extTipo == "RECURSAMIENTO"){
                                costo = materiaCargadas[i].frImporteRecursamiento;
                                
                            }

                            if(materiaCargadas[i].extTipo == "ACOMPAÑAMIENTO"){
                                costo = materiaCargadas[i].frImporteAcomp;
                                
                            }

                            

                            myTable += "<td>" + costo + "</td>";    


                            arr.push(Number(costo));
                           
                            myTable += "</tr>";  

                            
    
    
                        }

                        

                        

                       

                        console.log(arr)
    
                        

    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        let total=0,numeros = arr;
                        numeros.forEach(function(a){total += a;});
                        console.log(total);

                        $("#monto_costo").show();
                        $("#monto_costo").text("Total: $" + total);
    
                        $(".boton-guardar").show();
    
                        //muestra el boton guardar
                        //$(".boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#monto_costo").hide();
                    $("#monto_costo").text("");

                    $(".boton-guardar").hide();
    
    
                }
    
            });
        }); 

        //por alumno 
        $("#alumno_id").change(event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();

    
    
            $.get(base_url + `/bachiller_recuperativos/pago_recuperativo/extras_cargadas/${periodo_id}/${plan_id}/${event.target.value}`, function(res, sta) {
    
                var materiaCargadas = res.materiaCargadas;
                if (materiaCargadas.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr>";                  
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Costo</strong></td>";
                        myTable += "</tr>";

                        var suma = 0;
                        let costo = 0;
                        var arr = [];
    
                        for (let i = 0; i < materiaCargadas.length; i++) {
    
                            let num = [i + 1];
                            
    
                            
    
                            myTable += `<tr><td> ${num}</td>`;

                            myTable += `<td style="display: none;"><input type="checkbox" checked name="inscrito_extra_id[]" id="inscrito_extra_id_${materiaCargadas[i].id}" value="${materiaCargadas[i].id}"><label for="inscrito_extra_id_${materiaCargadas[i].id}">${materiaCargadas[i].id}</label></td>`;


                            myTable += `<td> ${materiaCargadas[i].matClave}-${materiaCargadas[i].matNombre} </td>`;

                            
                            if(materiaCargadas[i].extTipo == "RECURSAMIENTO"){
                                costo = materiaCargadas[i].frImporteRecursamiento;
                                
                            }

                            if(materiaCargadas[i].extTipo == "ACOMPAÑAMIENTO"){
                                costo = materiaCargadas[i].frImporteAcomp;
                                
                            }

                            

                            myTable += "<td>" + costo + "</td>";    


                            arr.push(Number(costo));
                           
                            myTable += "</tr>";  

                            
    
    
                        }

                        

                        

                       

                        console.log(arr)
    
                        

    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        let total=0,numeros = arr;
                        numeros.forEach(function(a){total += a;});
                        console.log(total);

                        $("#monto_costo").show();
                        $("#monto_costo").text("Total: $" + total);
    
                        $(".boton-guardar").show();
    
                        //muestra el boton guardar
                        //$(".boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#monto_costo").hide();
                    $("#monto_costo").text("");

                    $(".boton-guardar").hide();
    
    
                }
    
            });
        }); 
    
    });
    </script>


    <script>
        $(document).ready(function() {

        
        $(document).on("click", ".boton-guardar", function(e) {            
            

            var inscrito_extra_id =  $("input[name='inscrito_extra_id[]']:checked").map(function () {
                return this.value;
            }).get();

            // $("#alumno_id").change(function() {
            //     var valor = $(this).val(); // Capturamos el valor del select
            //     var texto = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado

            // });

            // alert(texto)

            var alumno = $(":selected", $("#alumno_id")).text();

            if($("#alumno_id").val() == ""){
                swal("Escuela Modelo", "No se ha seleccionado ningun alumno", "warning");
            }


            e.preventDefault();

            

            swal({
                title: "Cambiar Estado",
                text: "¿Desea cambiar el estado de pago del alumno " + alumno + " ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    
                    $.ajax({
                        url: "{{route('bachiller_recuperativos.cambio_estado_pago')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            inscrito_extra_id: inscrito_extra_id
                        },
                        beforeSend: function () {
                                              
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
                                title: "Guardando datos...",
                                text: html,
                                showConfirmButton: false
                                //confirmButtonText: "Ok",
                            })

                        },
                        success: function(data){

                            if(data.res){
                                swal("Escuela Modelo", "Se ha actualizado el estado de pago con éxito", "success");
                                document.getElementById('tablePrint').innerHTML = "";
                                $("#alumno_id").val("").trigger( "change" );
                                $("#monto_costo").hide();
                                $("#monto_costo").text("");
                                $(".boton-guardar").hide();


                                //data.inscrito_extra_id
                                
                                window.open("/bachiller_recuperativos/imprimirComprobante/"+data.inscrito_extra_id,"_blank");


                            } else{
                                swal("Escuela Modelo", "No se ha actualizado el estado de pago", "error");

                            }
                       
                 
                        }
                      });
                      
                } else {
                    swal.close()
                }
            });
        });
    });
    </script>

    @endsection