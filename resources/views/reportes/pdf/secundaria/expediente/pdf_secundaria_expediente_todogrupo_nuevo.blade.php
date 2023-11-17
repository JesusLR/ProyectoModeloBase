<!DOCTYPE html>
<html>

<head>
    <title>Expediente de alumno</title>
    <!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <style type="text/css">
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        /* Document
        ========================================================================== */
        /**
      * 1. Correct the line height in all browsers.
      * 2. Prevent adjustments of font size after orientation changes in iOS.
      */
        html {
            line-height: 1.6;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        /* Sections
        ========================================================================== */
        /**
      * Remove the margin in all browsers.
      */
        body {
            margin: 0;
        }

        /**
      * Render the `main` element consistently in IE.
      */
        main {
            display: block;
        }

        /**
      * Correct the font size and margin on `h1` elements within `section` and
      * `article` contexts in Chrome, Firefox, and Safari.
      */
        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        /* Grouping content
        ========================================================================== */
        /**
      * 1. Add the correct box sizing in Firefox.
      * 2. Show the overflow in Edge and IE.
      */
        hr {
            box-sizing: content-box;
            /* 1 */
            height: 0;
            /* 1 */
            overflow: visible;
            /* 2 */
        }

        /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
        pre {
            font-family: monospace, monospace;
            /* 1 */
            font-size: 1em;
            /* 2 */
        }

        /* Text-level semantics
        ========================================================================== */
        /**
      * Remove the gray background on active links in IE 10.
      */
        a {
            background-color: transparent;
        }

        /**
      * 1. Remove the bottom border in Chrome 57-
      * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
      */
        abbr[title] {
            border-bottom: none;
            /* 1 */
            text-decoration: underline;
            /* 2 */
            text-decoration: underline dotted;
            /* 2 */
        }

        /**
      * Add the correct font weight in Chrome, Edge, and Safari.
      */
        b,
        strong {
            font-weight: bolder;
        }

        /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
        code,
        kbd,
        samp {
            font-family: monospace, monospace;
            /* 1 */
            font-size: 1em;
            /* 2 */
        }

        /**
      * Add the correct font size in all browsers.
      */
        small {
            font-size: 80%;
        }

        /**
      * Prevent `sub` and `sup` elements from affecting the line height in
      * all browsers.
      */
        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        /* Embedded content
        ========================================================================== */
        /**
      * Remove the border on images inside links in IE 10.
      */
        img {
            border-style: none;
        }

        /* Forms
        ========================================================================== */
        /**
      * 1. Change the font styles in all browsers.
      * 2. Remove the margin in Firefox and Safari.
      */
        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            /* 1 */
            font-size: 100%;
            /* 1 */
            line-height: 1.15;
            /* 1 */
            margin: 0;
            /* 2 */
        }

        /**
      * Show the overflow in IE.
      * 1. Show the overflow in Edge.
      */
        button,
        input {
            /* 1 */
            overflow: visible;
        }

        /**
      * Remove the inheritance of text transform in Edge, Firefox, and IE.
      * 1. Remove the inheritance of text transform in Firefox.
      */
        button,
        select {
            /* 1 */
            text-transform: none;
        }

        /**
      * Correct the inability to style clickable types in iOS and Safari.
      */
        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
            -webkit-appearance: button;
        }

        /**
      * Remove the inner border and padding in Firefox.
      */
        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        /**
      * Restore the focus styles unset by the previous rule.
      */
        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
            outline: 1px dotted ButtonText;
        }

        /**
      * Correct the padding in Firefox.
      */
        fieldset {
            padding: 0.35em 0.75em 0.625em;
        }

        /**
      * 1. Correct the text wrapping in Edge and IE.
      * 2. Correct the color inheritance from `fieldset` elements in IE.
      * 3. Remove the padding so developers are not caught out when they zero out
      *    `fieldset` elements in all browsers.
      */
        legend {
            box-sizing: border-box;
            /* 1 */
            color: inherit;
            /* 2 */
            display: table;
            /* 1 */
            max-width: 100%;
            /* 1 */
            padding: 0;
            /* 3 */
            white-space: normal;
            /* 1 */
        }

        /**
      * Add the correct vertical alignment in Chrome, Firefox, and Opera.
      */
        progress {
            vertical-align: baseline;
        }

        /**
      * Remove the default vertical scrollbar in IE 10+.
      */
        textarea {
            overflow: auto;
        }

        /**
      * 1. Add the correct box sizing in IE 10.
      * 2. Remove the padding in IE 10.
      */
        [type="checkbox"],
        [type="radio"] {
            box-sizing: border-box;
            /* 1 */
            padding: 0;
            /* 2 */
        }

        /**
      * Correct the cursor style of increment and decrement buttons in Chrome.
      */
        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
            height: auto;
        }

        /**
      * 1. Correct the odd appearance in Chrome and Safari.
      * 2. Correct the outline style in Safari.
      */
        [type="search"] {
            -webkit-appearance: textfield;
            /* 1 */
            outline-offset: -2px;
            /* 2 */
        }

        /**
      * Remove the inner padding in Chrome and Safari on macOS.
      */
        [type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /**
      * 1. Correct the inability to style clickable types in iOS and Safari.
      * 2. Change font properties to `inherit` in Safari.
      */
        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            /* 1 */
            font: inherit;
            /* 2 */
        }

        /* Interactive
        ========================================================================== */
        /*
      * Add the correct display in Edge, IE 10+, and Firefox.
      */
        details {
            display: block;
        }

        /*
      * Add the correct display in all browsers.
      */
        summary {
            display: list-item;
        }

        /* Misc
        ========================================================================== */
        /**
      * Add the correct display in IE 10+.
      */
        template {
            display: none;
        }

        /**
      * Add the correct display in IE 10.
      */
        [hidden] {
            display: none;
        }

        body {
            font-family: 'times sans-serif';
            font-size: 10px;
            margin-top: 30px;
            /* ALTURA HEADER */
            margin-left: 5px;
            margin-right: 5px;
        }

        .row {
            width: 100%;
            display: block;
            position: relative;
            margin-left: -30px;
            margin-right: -30px;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .column,
        .columns {
            width: 100%;
            float: left;
            box-sizing: border-box !important;
        }

        .medium-1 {
            width: 8.33333333333%;
        }

        .medium-4 {
            width: 16.6666666667%;
        }

        .medium-3 {
            width: 25%;
        }

        .medium-4 {
            width: 33.3333333333%;
        }

        .medium-5 {
            width: 41.6666666667%;
        }

        .medium-6 {
            width: 50%;
        }

        .medium-7 {
            width: 58.3333333333%;
        }

        .medium-8 {
            width: 66.6666666667%;
        }

        .medium-9 {
            width: 75%;
        }

        .medium-10 {
            width: 83.3333333333%;
        }

        .medium-11 {
            width: 91.6666666667%;
        }

        .medium-12 {
            width: 100%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        span {
            font-weight: bold;
        }

        p {
            margin: 0;
        }

        .left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .logo {
            width: 100%;
        }

        .box-solicitud {
            border: 1px solid #000;
            padding: 5px;
            border-radius: 2px;
        }

        .estilos-tabla {
            width: 100%;
        }

        .estilos-tabla tr th {
            font-size: 12px;
            background-color: #000;
            color: #fff;
            height: 30px;
            padding-left: 5px;
            padding-right: 5px;
            box-sizing: border-box;
            text-align: center;
        }

        .estilos-tabla tr td {
            font-size: 12px;
            padding-left: 2px;
            padding-right: 2px;
            box-sizing: border-box;
            color: #000;
        }

        .page_break {
            page-break-before: always;

        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0px;
            left: 0cm;
            right: 0cm;
            /** Extra personal styles **/
            color: #000;
            text-align: center;
        }

        header {
            position: fixed;
            top: -70px;
            right: 0px;
            height: 3px;
            /** Extra personal styles **/

            margin-left: 5px;
            margin-right: 5px;
        }

        #watermark {
            position: fixed;
            top: 15%;
            left: 0;
            width: 700px;
            height: 700px;
            opacity: .3;
        }

        .img-header {
            height: 80px;
            float: left;
        }

        .img-header2 {
            height: 80px;
            float: right;
        }
        .img-foto {
            height: 80px;
            float: right;
        }

        .inicio-pagina {
            margin-top: 0;
            display: block;
        }

        @page {
            margin-top: 80px;
            margin-bottom: 40px;
        }

        .listas-info {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .listas-info li {
            display: inline;
            list-style-type: none;
            margin-left: 40px;

        }

        .listas-info li:first-child {
            margin-left: 0px;
        }

        .listas-asistencia {
            margin-top: 0px;
            margin-bottom: 0px;
            margin-left: 0px !important;
            padding-left: 0 !important;
        }

        .listas-asistencia li {
            display: inline;
            list-style-type: none;
        }

        .table {
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table th {
            border: 1px solid #000;
        }

        .table td,
        .table th {
            padding-top: 0px;
            padding-bottom: 0px;
            padding-right: 5px;
            border: 0px solid #000;
        }

        .page-number:before {
            content: "Pág "counter(page);
        }

        .page-break {
            page-break-after: always;
        }

        
    </style>
</head>
@if ($tipoReporte == 1)
    
<body>

    <header>
        <div class="row" style="margin-top: 0px;">
            <div class="columns medium-12">
                <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

                <div class="cuadrado img-header2">
            
                </div>
                <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO, S.C.P.</h1>
                <h3 style="margin-top:0px; margin-bottom: 0px; text-align: center;">HOJA DE DATOS GENERALES</h3>
            </div>
        </div>
    </header>
    @for ($i = 0; $i < count($alumnogrupo_collection); $i++)
        
        @php
            $grupoAlumnos = DB::select("call procSecundariaDatosHistoria(". $alumno_id[$i] . ")");

            $alumnogrupo_collectiosn = collect($grupoAlumnos);

            $unicoAlumnoTutores =  DB::select("call procSecundariaDatosTutores(".$alumno_id[$i].")");
            $alumnoTutor_collection = collect($unicoAlumnoTutores);
        @endphp

        @foreach ($alumnogrupo_collectiosn as $alumno)
            @foreach ($alumnogrupo_collection as $itemGrupo)
                @if ($alumno->alumno_id == $itemGrupo->alumno_id)
                
                   
                
                    <style>
                        .cuadrado {
                            width: 70px;
                            height: 90px;
                            border: solid;
                            border-style: dotted;
                            border-width: 1px;
                            border-color: 660033;
                            background-color: cc3366;
                            font-family: verdana, arial;
                            font-size: 10pt;
                        }
                    </style>
                
                
                    <div class="row">
                        <div class="columns medium-4">              
                        </div>
                        <div class="columns medium-4">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><b>Clave: </b>{{$alumno->aluClave}}</label>  <label><b>Curp: </b>{{$alumno->perCurp}}</label>  
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label style="margin-top:0px; margin-bottom: 10px;"><strong>Alumno: </strong>{{$alumno->perApellido1}}
                                {{$alumno->perApellido2}} {{$alumno->perNombre}}</label>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label style="margin-top:0px; margin-bottom: 10px;"><strong>Grado: </strong>{{$itemGrupo->grado}}°
                            {{$itemGrupo->grupo}} DE {{$itemGrupo->progNombre}}</label>
                        </div>
                        <div class="columns medium-4">            
                        </div>             
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="columns medium-12">
                            <p style="width:100%; text-align: left; border: 1px solid;"><i></i></p>
                            <br>
                        </div>
                    </div>
                
                    {{-- valida el genero para titulo correspondiente  --}}
                    @if ($alumno->sexo == "Masculino")
                    <h2 style="text-align: center">DATOS DEL ALUMNO</h2>
                    @else
                    <h2 style="text-align: center">DATOS DE LA ALUMNA</h2>
                    @endif
                
                    <div class="row">
                        <div class="columns medium-12">
                        <table class="table">
                            <tr>
                            <th><label><b>Nombre(s): </b></label></th>
                            <th><label><b>Apellido paterno: </b></label></th>
                            <th><label><b>Apellido materno: </b></label></th>         
                            <th><label><b>Fecha de nacimiento:</b></label></th>  
                            <th><label><b>Edad: </b></label></th>        
                            <th><label><b>Grado al que se inscribe: </b></label></th> 
                            </tr>                      
                            
                            <tr>            
                                
                                <td><label>{{$alumno->perNombre}}</label></td>
                                
                                <td><label>{{$alumno->perApellido1}}</label></td>
                                
                                <td><label>{{$alumno->perApellido2}}</label></td>
                
                                <td><label>{{ \Carbon\Carbon::parse($alumno->perFechaNac)->format('d/m/Y')}}</label></td>
                
                                <td><label>{{$alumno->hisEdadActualMeses}}</label></td>
                
                                <td><label>{{$alumno->hisIngresoSecundaria}}°</label></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                
                
                
                
                    {{-- valida el genero para titulo correspondiente  --}}
                    @if ($alumno->sexo == "Masculino")
                    <h2 style="text-align: center">TUTORES DEL ALUMNO</h2>
                    @else
                    <h2 style="text-align: center">TUTORES DE LA ALUMNA</h2>
                    @endif
                
                    @forelse ($alumnoTutor_collection as $key => $tutor)
                    <div class="row">
                        <div class="columns medium-12">
                            <table class="table">
                                <tr>
                                    <th><label><b>Nombre completo del tutor {{$key+1}}:</b></label></th>
                                    <th><label><b>Calle:</b></label></th>
                                    <th><label><b>CP:</b></label></th>         
                                    <th><label><b>Población:</b></label></th>  
                                    <th><label><b>Colonia:</b></label></th>        
                                    <th><label><b>Estado: </b></label></th> 
                                </tr>                      
                                
                                <tr> 
                                    <td><label>{{$tutor->tutNombre}}</label></td>
                                    
                                    <td><label>{{$tutor->tutCalle}}</label></td>
                                    
                                    <td><label>{{$tutor->tutCodigoPostal}}</label></td>
                
                                    <td><label>{{$tutor->tutPoblacion}}</label></td>
                
                                    <td><label>{{$tutor->tutColonia}}</label></td>
                
                                    <td><label>{{$tutor->tutEstado}}</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @empty
                    <div class="row">
                        <div class="columns medium-12">
                            <table class="table">
                                <tr>
                                    <th><label><b>Nombre completo del tutor:</b></label></th>
                                    <th><label><b>Calle:</b></label></th>
                                    <th><label><b>CP:</b></label></th>         
                                    <th><label><b>Población:</b></label></th>  
                                    <th><label><b>Colonia:</b></label></th>        
                                    <th><label><b>Estado:</b></label></th> 
                                </tr>                      
                                
                                <tr>            
                                    
                                    <td><label></label></td>
                                    
                                    <td><label></label></td>
                                    
                                    <td><label></label></td>
                
                                    <td><label></label></td>
                
                                    <td><label></label></td>
                
                                    <td><label></label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endforelse
                
                
                
                    {{-- datos generales familiares  --}}
                    <h2 style="text-align: center">DATOS FAMILIARES</h2>
                    {{-- <div class="row">
                        <div class="columns medium-12">
                            <label><b>Si proviene de otra cuidad ¿Cuánto tiempo tiene de residir en Mérida:</b></label>
                            <br>
                            <label>{{$alumno->tiempoResidencia}}</label>
                        </div>
                    </div> --}}
                
                    {{-- datos del padre  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <h2>Datos del padre:</h2>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-12">
                        <table class="table">
                            <tr>
                            <th><label><b>Nombre(s): </b></label></th>
                            <th><label><b>Apellido paterno:</b></label></th>
                            <th><label><b>Apellido materno:</b></label></th>         
                            <th><label><b>Celular:</b></label></th>  
                            {{-- <th><label><b>Edad:</b></label></th>         --}}
                            <th><label><b>Ocupación:</b></label></th> 
                            </tr>                      
                            
                            <tr>            
                                
                                <td><label>{{$alumno->famNombresPadre}}</label></td>
                                
                                <td><label>{{$alumno->famApellido1Padre}}</label></td>
                                
                                <td><label>{{$alumno->famApellido2Padre}}</label></td>
                
                                <td><label>{{$alumno->famCelularPadre}}</label></td>
                
                                {{-- <td><label>{{$alumno->edadPadre}}</label></td> --}}
                
                                <td><label>{{$alumno->famOcupacionPadre}}</label></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                
                
                
                    {{-- datos de la madre  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <h2>Datos de la madre:</h2>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-12">
                        <table class="table">
                            <tr>
                            <th><label><b>Nombre(s): </b></label></th>
                            <th><label><b>Apellido paterno:</b></label></th>
                            <th><label><b>Apellido materno:</b></label></th>         
                            <th><label><b>Celular:</b></label></th>  
                            {{-- <th><label><b>Edad:</b></label></th>         --}}
                            <th><label><b>Ocupación:</b></label></th> 
                            </tr>                      
                            
                            <tr>            
                                
                                <td><label>{{$alumno->famNombresMadre}}</label></td>
                                
                                <td><label>{{$alumno->famApellido1Madre}}</label></td>
                                
                                <td><label>{{$alumno->famApellido2Madre}}</label></td>
                
                                <td><label>{{$alumno->famCelularMadre}}</label></td>
                
                                {{-- <td><label>{{$alumno->edadMadre}}</label></td> --}}
                
                                <td><label>{{$alumno->famOcupacionMadre}}</label></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                
                    <br>
                    {{-- datos generales de la familia  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <h2>Datos generales:</h2>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Estado civil de los padres: </b></label>
                            <br>
                            <label>{{$alumno->famEstadoCivilPadres}}</label>
                        </div>
                
                        {{-- <div class="columns medium-4">
                            <label><b>Observaciones: </b></label>
                            <br>
                            <label>{{$alumno->observacionePadres}}</label>
                        </div> --}}
                
                        <div class="columns medium-4">
                            <label><b>Religión: </b></label>
                            <br>
                            <label>{{$alumno->famReligion}}</label>
                        </div>
                    </div>
                
                
                    {{-- Breve descripción de su familia (integrantes, relacion, edad, ocupacion) --}}
                    <div class="row">
                        <div class="columns medium-12">
                            <h2>Breve descripción de su familia (integrantes, relacion, edad, ocupacion):</h2>
                        </div>
                    </div>
                
                    {{-- integrante 1 --}}
                    <div class="row" >
                        <div class="columns medium-3">
                            <label><b>Integrante 1:</b></label>
                            <br>
                            <label>{{$alumno->famIntegrante1}}</label>
                        </div>
                
                        <div class="columns medium-3">
                            <label><b>Relación integrante 1: </b></label>
                            <br>
                            <label>{{$alumno->famParentesco1}}</label>
                        </div>
                        <div class="columns medium-3">
                            <label><b>Edad integrante 1: </b></label>
                            <br>
                            <label>{{$alumno->famEdadIntegrante1}}</label>
                        </div>
                        {{-- <div class="columns medium-3">
                            <label><b>Ocupación integrante 1: </b></label>
                            <br>
                            <label>{{$alumno->ocupacionIntegrante1}}</label>
                        </div> --}}
                    </div>
                    <br>
                    {{-- integrante 2 --}}
                    <div class="row">
                        <div class="columns medium-3">
                            <label><b>Integrante 2:</b></label>
                            <br>
                            <label>{{$alumno->famIntegrante2}}</label>
                        </div>
                
                        <div class="columns medium-3">
                            <label><b>Relación integrante 2: </b></label>
                            <br>
                            <label>{{$alumno->famParentesco2}}</label>
                        </div>
                        <div class="columns medium-3">
                            <label><b>Edad integrante 2: </b></label>
                            <br>
                            <label>{{$alumno->famEdadIntegrante2}}</label>
                        </div>
                        {{-- <div class="columns medium-3">
                            <label><b>Ocupación integrante 2: </b></label>
                            <br>
                            <label>{{$alumno->ocupacionIntegrante2}}</label>
                        </div> --}}
                    </div>
                
                    <br>
                
                    {{-- integrante 3 --}}
                    <div class="row">
                        <div class="columns medium-3">
                            <label><b>Integrante 3:</b></label>
                            <br>
                            <label>{{$alumno->famIntregrante3}}</label>
                        </div>
                
                        <div class="columns medium-3">
                            <label><b>Relación integrante 3: </b></label>
                            <br>
                            <label>{{$alumno->famParentesco3}}</label>
                        </div>
                        <div class="columns medium-3">
                            <label><b>Edad integrante 3: </b></label>
                            <br>
                            <label>{{$alumno->famEdadIntregrante3}}</label>
                        </div>
                        {{-- <div class="columns medium-3">
                            <label><b>Ocupación integrante 3: </b></label>
                            <br>
                            <label>{{$alumno->ocupacionIntegrante3}}</label>
                        </div> --}}
                    </div>
                
                    <br>
                
                    {{-- integrante 4 --}}
                    {{-- <div class="row" >
                        <div class="columns medium-3">
                            <label><b>Integrante 4:</b></label>
                            <br>
                            <label>{{$alumno->famIntegrante4}}</label>
                        </div>
                
                        <div class="columns medium-3">
                            <label><b>Relación integrante 4: </b></label>
                            <br>
                            <label>{{$alumno->famParentesco3}}</label>
                        </div>
                        <div class="columns medium-3">
                            <label><b>Edad integrante 4: </b></label>
                            <br>
                            <label>{{$alumno->famEdadIntegrante3}}</label>
                        </div>
                        <div class="columns medium-3">
                            <label><b>Ocupación integrante 4: </b></label>
                            <br>
                            <label>{{$alumno->ocupacionIntegrante4}}</label>
                        </div>
                    </div> --}}
                
                
                    <br>
                    
                    <div class="row">
                        <div class="columns medium-6">
                            {{-- valida el genero para titulo correspondiente  --}}
                            @if ($alumno->sexo == "Masculino")
                            <label><b>¿Quién apoya a su hijo en las tareas en casa?:</b></label>
                            @else
                            <label><b>¿Quién apoya a su hija en las tareas en casa?</b></label>
                            @endif
                            <br>
                            <label>{{$alumno->actApoyoTarea}}</label>
                        </div>
                        {{-- <div class="row">
                            <div class="columns medium-6">
                                <label><b>Deporte(s) o actividad cultural que practica:</b></label>
                                <br>
                                <label>{{$alumno->deporteActividad}}</label>
                            </div>
                        </div> --}}
                    </div>
                
                    
                
                
                    <h2 style="text-align: center">DATOS ESCOLARES</h2>
                
                    <div class="row">
                        {{-- <div class="columns medium-4">
                            <label><b>Nombre la escuela donde cursó:</b></label>
                            <br>
                            <label>{{$alumno->escuelaProcedencia}}</label>
                        </div> --}}
                        {{-- <div class="columns medium-4">
                            <label><b>Años estudiados en la escuela anterior:</b></label>
                            <br>
                            <label>{{$alumno->aniosEstudios}}</label>
                        </div> --}}
                        {{-- <div class="columns medium-4">
                            <label><b>Motivos del cambio de escuela:</b></label>
                            <br>
                            <label>{{$alumno->motivosCambio}}</label>
                        </div> --}}
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Kinder:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->kinder}}</label> --}}
                        </div>
                        <div class="columns medium-8">
                            <label><b>Observaciones:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->observacionesEscolar}}</label> --}}
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-12">
                            <label><b>Primaria:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->primaria}}</label> --}}
                        </div>        
                    </div>
                
                    <br>
                
                    <div class="row">
                        <div class="columns medium-12">
                        <table class="table">
                            <tr>
                            <th><label><b>Promedio en 1°:</b></label></th>
                            <th><label><b>Promedio en 2°:</b></label></th>
                            <th><label><b>Promedio en 3°:</b></label></th>         
                            <th><label><b>Promedio en 4°:</b></label></th>  
                            <th><label><b>Promedio en 5°:</b></label></th>        
                            <th><label><b>Promedio en 6°:</b></label></th> 
                            </tr>                      
                            
                            <tr>            
{{--                                 
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado1}}</label></td>
                                
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado2}}</label></td>
                                
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado3}}</label></td>
                
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado4}}</label></td>
                
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado5}}</label></td>
                
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado6}}</label></td> --}}
                            </tr>
                        </table>
                        </div>
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Repetición de algún grado:</b></label>
                            <br>           
                            {{-- <label style="text-align: center">{{$alumno->gradoRepetido}}</label> --}}
                        </div>      
                        <div class="columns medium-4">
                            <label><b>Promedio:</b></label>
                            <br> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                            {{-- <label style="text-align: center">{{$alumno->promedioRepetido}}</label> --}}
                        </div>        
                    </div>
                
                    
                    <br>
                    <div class="row">
                        <div class="columns medium-5">
                            {{-- valida el genero para titulo correspondiente --}}
                            @if ($alumno->sexo == "Masculino")
                            <label><b>¿Ha recibido su hijo apoyo pedagógico en algún grado escolar?:</b></label>
                            @else
                            <label><b>¿Ha recibido su hija apoyo pedagógico en algún grado escolar?:</b></label>
                            @endif   
                            <br>     
                            {{-- <label style="text-align: center">{{$alumno->apoyoPedagogico}}</label> --}}
                        </div>      
                        <div class="columns medium-8">
                            <label><b>Observaciones:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->observacionesApoyo}}</label> --}}
                        </div>        
                    </div>
                
                
                    <div class="row">
                        <div class="columns medium-4">
                            {{-- valida el genero para titulo correspondiente --}}
                            @if ($alumno->sexo == "Masculino")
                            <h4>¿Ha recibido su hijo algún tratamiento?:</h4>
                            @else
                            <h4>¿Ha recibido su hija algún tratamiento?:</h4>
                            @endif 
                        </div>
                    </div>
                
                    {{-- medicco  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Médico:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->medico}}</label> --}}
                        </div>      
                        <div class="columns medium-8">
                            <label><b>Observaciones:</b></label>
                            <br> 
                            {{-- <label style="text-align: center">{{$alumno->observacionesMedico}}</label> --}}
                        </div>        
                    </div>
                
                    {{-- Neurológico  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Neurológico:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->neurologico}}</label> --}}
                        </div>      
                        <div class="columns medium-8">
                            <label><b>Observaciones:</b></label>
                            <br> 
                            {{-- <label style="text-align: center">{{$alumno->observacionesNerologico}}</label> --}}
                        </div>        
                    </div>
                    
                    {{-- Psicologico  --}}
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Psicologico:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->psicologico}}</label> --}}
                        </div>      
                        <div class="columns medium-8">
                            <label><b>Observaciones:</b></label>
                            <br> 
                            {{-- <label style="text-align: center">{{$alumno->observacionesPsicologico}}</label> --}}
                        </div>        
                    </div>
                
                
                    <br>
                    <div class="row">
                        <div class="columns medium-12">
                            <label><b>Motivo por el que se solicita la inscripción en la Escuela Modelo:</b></label>
                            <br>
                            {{-- <label>{{$alumno->motivoInscripcion}}</label> --}}
                        </div>
                    </div>
                
                
                    <div class="row">
                        <div class="columns medium-12">
                            <h4>Nombre de familiares o conocidos que estudien o trabajen en esta escuela:</h4>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Familiar 1:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->familiar1}}</label> --}}
                        </div>      
                        <div class="columns medium-4">
                            <label><b>Familiar 2:</b></label>
                            <br> 
                            {{-- <label style="text-align: center">{{$alumno->familiar2}}</label> --}}
                        </div>     
                        <div class="columns medium-4">
                            <label><b>Familiar 3:</b></label>
                            <br> 
                            {{-- <label style="text-align: center">{{$alumno->familiar3}}</label> --}}
                        </div>    
                    </div>
                
                
                    <div class="row">
                        <div class="columns medium-12">
                            <h4>Nombre de familiares o conocidos a quien se le pueda pedir referencia:</h4>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Referencia 1:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->referencia1}}</label> --}}
                        </div>      
                        <div class="columns medium-4">
                            <label><b>Celular referencia 1:</b></label>
                            <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{-- <label style="text-align: center">{{$alumno->celularReferencia1}}</label> --}}
                        </div>         
                    </div>
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Referencia 2:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->referencia2}}</label> --}}
                        </div>      
                        <div class="columns medium-4">
                            <label><b>Celular referencia 2:</b></label>
                            <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{-- <label style="text-align: center">{{$alumno->celularReferencia2}}</label> --}}
                        </div>         
                    </div>
                    <br>
                
                    <div class="row">
                        <div class="columns medium-12">
                            <label><b>Observaciones generales:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->observacionesGenerales}}</label> --}}
                        </div>              
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="columns medium-4">
                            <label><b>Entrevisto:</b></label>
                            <br>
                            {{-- <label style="text-decoration: underline;">{{$alumno->entrevisto}}</label> --}}
                        </div>         
                        <div class="columns medium-4">
                            <label><b>Ubicación:</b></label>
                            <br>
                            {{-- <label style="text-align: center">{{$alumno->ubicacion}}</label> --}}
                        </div>       
                    </div>
                    
                    @if ($loop->first)
                    <footer id="footer">
                        <div class="page-number"></div>
                    </footer>
                    @endif
                    @if (!$loop->last)
                    <div class="page_break"></div>
                    @endif
                @endif
            @endforeach
        @endforeach
       
    @endfor
    

</body>
    
@endif


@if ($tipoReporte == 2)
    
<body>

    <header>
        <div class="row" style="margin-top: 0px;">
            <div class="columns medium-12">
                <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

                {{-- <img class="img-header2" src="{{base_path('resources/assets/img/logo.jpg')}}" alt=""> --}}
                <div class="cuadrado img-header2">
            
                </div>

                <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO, S.C.P.</h1>
                <h3 style="margin-top:0px; margin-bottom: 0px; text-align: center;">HOJA DE DATOS GENERALES</h3>
            </div>
        </div>
    </header>
    @for ($i = 0; $i < count($alumnogrupo_collection); $i++)
        
        @php
            $grupoAlumnos = DB::select("call procPrimariaDatosHistoria(". $alumno_id[$i] . ")");

            $alumnogrupo_collectiosn = collect($grupoAlumnos);

            $unicoAlumnoTutores =  DB::select("call procPrimariaDatosTutores(".$alumno_id[$i].")");
            $alumnoTutor_collection = collect($unicoAlumnoTutores);
        @endphp

        @foreach ($alumnogrupo_collectiosn as $alumno)
            @foreach ($alumnogrupo_collection as $itemGrupo)
                @if ($alumno->alumno_id == $itemGrupo->alumno_id)
                
                {{-- <div style="text-align: right; margin-top: -100px;">
                    
                </div> --}}
            
                <style>
                    .cuadrado {
                        width: 70px;
                        height: 90px;
                        border: solid;
                        border-style: dotted;
                        border-width: 1px;
                        border-color: 660033;
                        background-color: cc3366;
                        font-family: verdana, arial;
                        font-size: 10pt;
                    }
                </style>
            
            
                <div class="row">
                    <div class="columns medium-4">              
                    </div>
                    <div class="columns medium-4">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><b>Clave: </b>{{$alumno->aluClave}}</label>  <label><b>Curp: </b>{{$alumno->perCurp}}</label>  
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label style="margin-top:0px; margin-bottom: 10px;"><strong>Alumno: </strong>{{$alumno->perApellido1}}
                            {{$alumno->perApellido2}} {{$alumno->perNombre}}</label>
                       <br>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <label style="margin-top:0px; margin-bottom: 10px;"><strong>Grado: </strong>{{$itemGrupo->grado}}°
                        {{$itemGrupo->grupo}} DE {{$itemGrupo->progNombre}}</label>
                    </div>
                    <div class="columns medium-4">            
                    </div>             
                </div>
            
                <br>
                <div class="row">
                    <div class="columns medium-12">
                        <p style="width:100%; text-align: left; border: 1px solid;"><i></i></p>
                        <br>
                    </div>
                </div>
            
                {{-- valida el genero para titulo correspondiente  --}}
                @if ($alumno->sexo == "Masculino")
                <h2 style="text-align: center">DATOS DEL ALUMNO</h2>
                @else
                <h2 style="text-align: center">DATOS DE LA ALUMNA</h2>
                @endif
            
                <div class="row">
                    <div class="columns medium-12">
                    <table class="table">
                        <tr>
                        <th><label><b>Nombre(s): </b></label></th>
                        <th><label><b>Apellido paterno: </b></label></th>
                        <th><label><b>Apellido materno: </b></label></th>         
                        <th><label><b>Fecha de nacimiento:</b></label></th>  
                        <th><label><b>Edad: </b></label></th>        
                        <th><label><b>Grado al que se inscribe: </b></label></th> 
                        </tr>                      
                        
                        <tr>            
                            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{$alumno->perNombre}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{$alumno->perApellido1}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{$alumno->perApellido2}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{ \Carbon\Carbon::parse($alumno->perFechaNac)->format('d/m/Y')}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{$alumno->edadAlumno}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                <br>
                                <label>{{$alumno->gradoInscrito}}°</label>
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            
            
            
             
                {{-- valida el genero para titulo correspondiente  --}}
                @if ($alumno->sexo == "Masculino")
                <h2 style="text-align: center">TUTORES DEL ALUMNO</h2>
                @else
                <h2 style="text-align: center">TUTORES DE LA ALUMNA</h2>
                @endif
            
                @forelse ($alumnoTutor_collection as $key => $tutor)
                <div class="row">
                    <div class="columns medium-12">
                        <table class="table">
                            <tr>
                                <th><label><b>Nombre completo del tutor {{$key+1}}:</b></label></th>
                                <th><label><b>Calle:</b></label></th>
                                <th><label><b>CP:</b></label></th>         
                                <th><label><b>Población:</b></label></th>  
                                <th><label><b>Colonia:</b></label></th>        
                                <th><label><b>Estado: </b></label></th> 
                            </tr>                      
                            
                            <tr> 
                                <td>
                                    <label><b>____________________________</b></label>
                                    <br>
                                    <label>{{$tutor->tutNombre}}</label>
                                </td>
                                
                                <td>
                                    <label><b>______________________</b></label>
                                    <br>
                                    <label>{{$tutor->tutCalle}}</label>
                                </td>
                                
                                <td>
                                    <label><b>______________</b></label>
                                    <br>
                                    <label>{{$tutor->tutCodigoPostal}}</label>
                                </td>
            
                                <td>
                                    <label><b>______________________</b></label>
                                    <br>
                                    <label>{{$tutor->tutPoblacion}}</label>
                                </td>
            
                                <td>
                                    <label><b>______________________</b></label>
                                    <br>
                                    <label>{{$tutor->tutColonia}}</label>
                                </td>
            
                                <td>
                                    <label><b>______________________</b></label>
                                    <br>
                                    <label>{{$tutor->tutEstado}}</label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @empty
                <div class="row">
                    <div class="columns medium-12">
                        <table class="table">
                            <tr>
                                <th><label><b>Nombre completo del tutor:</b></label></th>
                                <th><label><b>Calle:</b></label></th>
                                <th><label><b>CP:</b></label></th>         
                                <th><label><b>Población:</b></label></th>  
                                <th><label><b>Colonia:</b></label></th>        
                                <th><label><b>Estado:</b></label></th> 
                            </tr>                      
                            
                            <tr>            
                                
                                <td><label><b>______________________</b></label></td>
                                
                                <td><label><b>______________________</b></label></td>
                                
                                <td><label><b>______________________</b></label></td>
            
                                <td><label><b>______________________</b></label></td>
            
                                <td><label><b>______________________</b></label></td>
            
                                <td><label><b>______________________</b></label></td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endforelse
            
            
            
                {{-- datos generales familiares  --}}
                <h2 style="text-align: center">DATOS FAMILIARES</h2>
                <div class="row">
                    <div class="columns medium-12">
                        <label><b>Si proviene de otra cuidad ¿Cuánto tiempo tiene de residir en Mérida:</b></label>
                        <br>
                        <label><b>____________________________________________________________</b></label>
                        <br>
                        <label>{{$alumno->tiempoResidencia}}</label>
                    </div>
                </div>
            
                {{-- datos del padre  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <h2>Datos del padre:</h2>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-12">
                    <table class="table">
                        <tr>
                        <th><label><b>Nombre(s): </b></label></th>
                        <th><label><b>Apellido paterno:</b></label></th>
                        <th><label><b>Apellido materno:</b></label></th>         
                        <th><label><b>Celular:</b></label></th>  
                        <th><label><b>Edad:</b></label></th>        
                        <th><label><b>Ocupación:</b></label></th> 
                        </tr>                      
                        
                        <tr>            
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->nombresPadre}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->apellido1Padre}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->apellido2Padre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->celularPadre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->edadPadre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->ocupacioPadre}}</label>
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            
            
            
                {{-- datos de la madre  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <h2>Datos de la madre:</h2>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-12">
                    <table class="table">
                        <tr>
                        <th><label><b>Nombre(s): </b></label></th>
                        <th><label><b>Apellido paterno:</b></label></th>
                        <th><label><b>Apellido materno:</b></label></th>         
                        <th><label><b>Celular:</b></label></th>  
                        <th><label><b>Edad:</b></label></th>        
                        <th><label><b>Ocupación:</b></label></th> 
                        </tr>                      
                        
                        <tr>            
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->nombresMadre}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->apellido1Madre}}</label>
                            </td>
                            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->apellido2Madre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->celularMadre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->edadMadre}}</label>
                            </td>
            
                            <td>
                                <label><b>______________________</b></label>
                                    <br>
                                <label>{{$alumno->ocupacionMadre}}</label>
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
            
                <br>
                {{-- datos generales de la familia  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <h2>Datos generales:</h2>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Estado civil de los padres: </b></label>
                        <br>
                        <label><b>______________________</b></label>
                                    <br>
                        <label>{{$alumno->estadoCilvilPadres}}</label>
                    </div>
            
                    <div class="columns medium-4">
                        <label><b>Observaciones: </b></label>
                        <br>
                        <label><b>______________________</b></label>
                                    <br>
                        <label>{{$alumno->observacionePadres}}</label>
                    </div>
            
                    <div class="columns medium-4">
                        <label><b>Religión: </b></label>
                        <br>
                        <label><b>______________________</b></label>
                                    <br>
                        <label>{{$alumno->religion}}</label>
                    </div>
                </div>
            
            
                {{-- Breve descripción de su familia (integrantes, relacion, edad, ocupacion) --}}
                <div class="row">
                    <div class="columns medium-12">
                        <h2>Breve descripción de su familia (integrantes, relacion, edad, ocupacion):</h2>
                    </div>
                </div>
            
                {{-- integrante 1 --}}
                <div class="row" >
                    <div class="columns medium-3">
                        <label><b>Integrante 1:</b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->integrante1}}</label>
                    </div>
            
                    <div class="columns medium-3">
                        <label><b>Relación integrante 1: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->relacionIntegrante1}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Edad integrante 1: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->edadIntegrante1}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Ocupación integrante 1: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->ocupacionIntegrante1}}</label>
                    </div>
                </div>
                <br>
                {{-- integrante 2 --}}
                <div class="row">
                    <div class="columns medium-3">
                        <label><b>Integrante 2:</b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->integrante2}}</label>
                    </div>
            
                    <div class="columns medium-3">
                        <label><b>Relación integrante 2: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->relacionIntegrante2}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Edad integrante 2: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->edadIntegrante2}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Ocupación integrante 2: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->ocupacionIntegrante2}}</label>
                    </div>
                </div>
            
                <br>
            
                {{-- integrante 3 --}}
                <div class="row">
                    <div class="columns medium-3">
                        <label><b>Integrante 3:</b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->integrante3}}</label>
                    </div>
            
                    <div class="columns medium-3">
                        <label><b>Relación integrante 3: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->relacionIntegrante3}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Edad integrante 3: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->edadIntegrante3}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Ocupación integrante 3: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->ocupacionIntegrante3}}</label>
                    </div>
                </div>
            
                <br>
            
                {{-- integrante 4 --}}
                <div class="row" >
                    <div class="columns medium-3">
                        <label><b>Integrante 4:</b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->integrante4}}</label>
                    </div>
            
                    <div class="columns medium-3">
                        <label><b>Relación integrante 4: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->relacionIntegrante4}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Edad integrante 4: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->edadIntegrante4}}</label>
                    </div>
                    <div class="columns medium-3">
                        <label><b>Ocupación integrante 4: </b></label>
                        <br>
                        <label><b>_____________________________</b></label>
                                    <br>
                        <label>{{$alumno->ocupacionIntegrante4}}</label>
                    </div>
                </div>
            
            
                <br>
                
                <div class="row">
                    <div class="columns medium-6">
                        {{-- valida el genero para titulo correspondiente  --}}
                        @if ($alumno->sexo == "Masculino")
                        <label><b>¿Quién apoya a su hijo en las tareas en casa?:</b></label>
                        @else
                        <label><b>¿Quién apoya a su hija en las tareas en casa?</b></label>
                        @endif
                        <br>
                        <label><b>____________________________________________</b></label>
                                    <br>
                        <label>{{$alumno->actApoyoTarea}}</label>
                    </div>
                    <div class="row">
                        <div class="columns medium-6">
                            <label><b>Deporte(s) o actividad cultural que practica:</b></label>
                            <br>
                            <b>____________________________________________</b></label>
                                    <br>
                            <label>{{$alumno->deporteActividad}}</label>
                        </div>
                    </div>
                </div>
            
                
            
            
                <h2 style="text-align: center">DATOS ESCOLARES</h2>
            
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Nombre la escuela donde cursó:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label>{{$alumno->escuelaProcedencia}}</label>
                    </div>
                    <div class="columns medium-4">
                        <label><b>Años estudiados en la escuela anterior:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label>{{$alumno->aniosEstudios}}</label>
                    </div>
                    <div class="columns medium-4">
                        <label><b>Motivos del cambio de escuela:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label>{{$alumno->motivosCambio}}</label>
                    </div>
                </div>
            
                <br>
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Kinder:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label style="text-align: center">{{$alumno->kinder}}</label>
                    </div>
                    <div class="columns medium-8">
                        <label><b>Observaciones:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label style="text-align: center">{{$alumno->observacionesEscolar}}</label>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-12">
                        <label><b>Primaria:</b></label>
                        <br>
                        <b>_____________________________________</b></label>
                                    <br>
                        <label style="text-align: center">{{$alumno->primaria}}</label>
                    </div>        
                </div>
            
                <br>
            
                <div class="row">
                    <div class="columns medium-12">
                    <table class="table">
                        <tr>
                        <th><label><b>Promedio en 1°:</b></label></th>
                        <th><label><b>Promedio en 2°:</b></label></th>
                        <th><label><b>Promedio en 3°:</b></label></th>         
                        <th><label><b>Promedio en 4°:</b></label></th>  
                        <th><label><b>Promedio en 5°:</b></label></th>        
                        <th><label><b>Promedio en 6°:</b></label></th> 
                        </tr>                      
                        
                        <tr>            
                            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado1}}</label></td>
                            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado2}}</label></td>
                            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado3}}</label></td>
            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado4}}</label></td>
            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado5}}</label></td>
            
                            <td>
                                <label>
                                <b>________________</b></label>
                                    <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>{{$alumno->promedioGrado6}}</label></td>
                        </tr>
                    </table>
                    </div>
                </div>
            
                <br>
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Repetición de algún grado:</b></label>
                        <br>    
                        <label><b>_________________________</b></label>
                                <br>       
                        <label style="text-align: center">{{$alumno->gradoRepetido}}</label>
                    </div>      
                    <div class="columns medium-4">
                        <label><b>Promedio:</b></label>
                        <br>
                        <label><b>_________</b></label>
                                <br>
                                 &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                        <label style="text-align: center">{{$alumno->promedioRepetido}}</label>
                    </div>        
                </div>
            
                
                <br>
                <div class="row">
                    <div class="columns medium-5">
                        {{-- valida el genero para titulo correspondiente --}}
                        @if ($alumno->sexo == "Masculino")
                        <label><b>¿Ha recibido su hijo apoyo pedagógico en algún grado escolar?:</b></label>
                        @else
                        <label><b>¿Ha recibido su hija apoyo pedagógico en algún grado escolar?:</b></label>
                        @endif   
                        <br> 
                        <label><b>________________</b></label>
                                <br>    
                        <label style="text-align: center">{{$alumno->apoyoPedagogico}}</label>
                    </div>      
                    <div class="columns medium-8">
                        <label><b>Observaciones:</b></label>
                        <br>
                        <label><b>___________________________________________________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->observacionesApoyo}}</label>
                    </div>        
                </div>
            
            
                <div class="row">
                    <div class="columns medium-4">
                        {{-- valida el genero para titulo correspondiente --}}
                        @if ($alumno->sexo == "Masculino")
                        <h4>¿Ha recibido su hijo algún tratamiento?:</h4>
                        @else
                        <h4>¿Ha recibido su hija algún tratamiento?:</h4>
                        @endif 
                    </div>
                </div>
            
                {{-- medicco  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Médico:</b></label>
                        <br>
                        <label><b>________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->medico}}</label>
                    </div>      
                    <div class="columns medium-8">
                        <label><b>Observaciones:</b></label>
                        <br> 
                        <label><b>___________________________________________________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->observacionesMedico}}</label>
                    </div>        
                </div>
            
                {{-- Neurológico  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Neurológico:</b></label>
                        <br>
                        <label><b>________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->neurologico}}</label>
                    </div>      
                    <div class="columns medium-8">
                        <label><b>Observaciones:</b></label>
                        <br> 
                        <label><b>___________________________________________________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->observacionesNerologico}}</label>
                    </div>        
                </div>
                
                {{-- Psicologico  --}}
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Psicologico:</b></label>
                        <br>
                        <label><b>________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->psicologico}}</label>
                    </div>      
                    <div class="columns medium-8">
                        <label><b>Observaciones:</b></label>
                        <br> 
                        <label><b>___________________________________________________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->observacionesPsicologico}}</label>
                    </div>        
                </div>
            
            
                <br>
                <div class="row">
                    <div class="columns medium-12">
                        <label><b>Motivo por el que se solicita la inscripción en la Escuela Modelo:</b></label>
                        <br>
                        <label><b>_________________________________________________________________________________________________________________________________________</b></label>
                                <br>   
                        <label>{{$alumno->motivoInscripcion}}</label>
                    </div>
                </div>
            
            
                <div class="row">
                    <div class="columns medium-12">
                        <h4>Nombre de familiares o conocidos que estudien o trabajen en esta escuela:</h4>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Familiar 1:</b></label>
                        <br>
                        <label><b>_______________________________________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->familiar1}}</label>
                    </div>      
                    <div class="columns medium-4">
                        <label><b>Familiar 2:</b></label>
                        <br> 
                        <label><b>_______________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->familiar2}}</label>
                    </div>     
                    <div class="columns medium-4">
                        <label><b>Familiar 3:</b></label>
                        <br> 
                        <label><b>_______________________________________________</b></label>
                                <br>
                        <label style="text-align: center">{{$alumno->familiar3}}</label>
                    </div>    
                </div>
            
            
                <div class="row">
                    <div class="columns medium-12">
                        <h4>Nombre de familiares o conocidos a quien se le pueda pedir referencia:</h4>
                    </div>
                </div>
            
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Referencia 1:</b></label>
                        <br>
                        <label><b>_______________________________________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->referencia1}}</label>
                    </div>      
                    <div class="columns medium-4">
                        <label><b>Celular referencia 1:</b></label>
                        <br>
                        <label><b>_________________</b></label>
                                <br>  
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label style="text-align: center">{{$alumno->celularReferencia1}}</label>
                    </div>         
                </div>
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Referencia 2:</b></label>
                        <br>
                        <label><b>_______________________________________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->referencia2}}</label>
                    </div>      
                    <div class="columns medium-4">
                        <label><b>Celular referencia 2:</b></label>
                        <br>
                        <label><b>_________________</b></label>
                                <br>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label style="text-align: center">{{$alumno->celularReferencia2}}</label>
                    </div>         
                </div>
                <br>
            
                <div class="row">
                    <div class="columns medium-12">
                        <label><b>Observaciones generales:</b></label>
                        <br>
                        <label><b>______________________________________________________________________________________________________________________________________________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->observacionesGenerales}}</label>
                    </div>              
                </div>
            
                <br>
                <div class="row">
                    <div class="columns medium-4">
                        <label><b>Entrevisto:</b></label>
                        <br>
                        <label><b>______________________________________________</b></label>
                                <br>   
                        <label style="text-decoration: underline;">{{$alumno->entrevisto}}</label>
                    </div>         
                    <div class="columns medium-4">
                        <label><b>Ubicación:</b></label>
                        <br>
                        <label><b>______________________________________________</b></label>
                                <br>   
                        <label style="text-align: center">{{$alumno->ubicacion}}</label>
                    </div>       
                </div>
                    
                    @if ($loop->first)
                    <footer id="footer">
                        <div class="page-number">
                            
                        </div>
                    </footer>
                    @endif
                
                    @if (!$loop->last)
                        <div class="page_break"></div>
                    @endif
                @endif
            @endforeach
        @endforeach
       
    @endfor
    

</body>
    
@endif


</html>