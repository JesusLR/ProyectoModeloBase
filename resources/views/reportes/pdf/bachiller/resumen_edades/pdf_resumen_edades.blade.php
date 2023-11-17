<!DOCTYPE html>
<html>

<head>
  <title>Resumen de edades</title>
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
      font-size: 14px;
      margin-top: 60px;
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

    .medium-1-2 {
      width: 16.999%;
    }

    .medium-4 {
      width: 16.6666666667%;
    }

    .medium-2 {
      width: 21%;
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
      top: -50px;
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

    .img-foto {
      height: 80px;
      float: right;
      margin-top: -100px;

      padding: 2px;
      background-color: #f5f5f5;
      border: 1px solid #999999;


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



    .table td,
    .table th {
      padding-top: 0px;
      padding-bottom: 0px;
      padding-right: 5px;
      //border: 1px solid #000;
    }

    .page-number:before {
      content: "Pág "counter(page);
    }

    .page-break {
      page-break-after: always;
    }
   

    .punteado{
      border-top: 1px dotted; 
      border-right: 1px dotted; 
      border-bottom: 1px dotted; 
      border-left: 1px;
       //border-color: 660033;
      //background-color: cc3366;
    }

    .punteado2{
      border-top: 1px dotted; 
      border-right: 0px dotted; 
      border-bottom: 1px dotted; 
      border-left: 0px;
       //border-color: 660033;
      //background-color: cc3366;
    }

    .punteado3{
      border-top: 1px dotted; 
      border-right: 0px dotted; 
      //border-bottom: 1px dotted; 
      border-left: 0px;
       //border-color: 660033;
      //background-color: cc3366;
    }

    .punteado4 {
      border-top: 0px dotted; 
      border-right: 0px dotted; 
      //border-bottom: 0px dotted; 
      border-left: 0px;
       //border-color: 660033;
      //background-color: cc3366;
    }
  </style>
</head>

<body>

  <header>
    <div class="row" style="margin-top: 0px;">
      <div class="columns medium-6">

        <p>Preparatoria "ESCUELA MODELO"</p>
        <p>Resumen de alumnos por edades</p>
        <p>Curso escolar: {{$ciclo[0]->perAnio}}-{{$ciclo[1]->perAnio}}</p>
        <p>Ubicación: {{$ubicacion->ubiClave}}</p>
        <p>Inscritos, Pre-inscritos, Condicionados</p>
      
        
      </div>

      <div class="columns medium-6" style="text-align: right;">
        <p>{{$fechaActual}}</p>
        <p>{{$hora}}</p>
        <p>resumen_edades.pdf</p>
      </div>
    </div>
  </header>

  <div class="row">
    {{--  <div class="columns medium-3">
      <p><b>Clave:</b> {{$alumno[0]->aluClave}}</p>
      <p><b>Alumno:</b> {{$alumno[0]->nombre_completo_alumno}}</p>
    </div>
    <div class="columns medium-2">
      
    </div>
    <div class="columns medium-3">
      <p><b>Clav.Plan:</b> {{$alumno[0]->planClave}}</p>
      <p><b>Ubicación:</b> {{$alumno[0]->ubiClave}}</p>
    </div>
    <div class="columns medium-1-2">
      
    </div>
    <div class="columns medium-3">
      <p><b>Fecha:</b> {{$fechaActual}}</p>
      <p><b>Grupo:</b> {{$alumno[0]->semestre.' '.$alumno[0]->grupo}}</p>
    </div>  --}}
  </div>

  <br>

  @php
    #primeros
    $sumaPrimeroHombres14 = 0;
    $sumaPrimeroMujeres14 = 0;

    $sumaPrimeroHombres15 = 0;
    $sumaPrimeroMujeres15 = 0;

    $sumaPrimeroHombres16 = 0;
    $sumaPrimeroMujeres16 = 0;

    $sumaPrimeroHombres17 = 0;
    $sumaPrimeroMujeres17 = 0;

    $sumaPrimeroHombres18 = 0;
    $sumaPrimeroMujeres18 = 0;

    $sumaPrimeroHombres19 = 0;
    $sumaPrimeroMujeres19 = 0;

    $sumaPrimeroHombres20 = 0;
    $sumaPrimeroMujeres20 = 0;

    $sumaPrimeroHombres21 = 0;
    $sumaPrimeroMujeres21 = 0;

    $sumaPrimeroHombres22 = 0;
    $sumaPrimeroMujeres22 = 0;

    $sumaPrimeroHombres23 = 0;
    $sumaPrimeroMujeres23 = 0;

    $sumaPrimeroHombres24 = 0;
    $sumaPrimeroMujeres24 = 0;

    $sumaPrimeroHombres25 = 0;
    $sumaPrimeroMujeres25 = 0;

    $sumaPrimeroHombresExistentes = 0;
    $sumaPrimeroMujeresExistentes = 0;

    $sumaPrimeroHombresBajas = 0;
    $sumaPrimeroMujeresBajas = 0;

    $sumaPrimeroHombresInscritos = 0;
    $sumaPrimeroMujeresInscritos = 0;

    #segundos
    $sumaSegundoHombres14 = 0;
    $sumaSegundoMujeres14 = 0;

    $sumaSegundoHombres15 = 0;
    $sumaSegundoMujeres15 = 0;

    $sumaSegundoHombres16 = 0;
    $sumaSegundoMujeres16 = 0;

    $sumaSegundoHombres17 = 0;
    $sumaSegundoMujeres17 = 0;

    $sumaSegundoHombres18 = 0;
    $sumaSegundoMujeres18 = 0;

    $sumaSegundoHombres19 = 0;
    $sumaSegundoMujeres19 = 0;

    $sumaSegundoHombres20 = 0;
    $sumaSegundoMujeres20 = 0;

    $sumaSegundoHombres21 = 0;
    $sumaSegundoMujeres21 = 0;

    $sumaSegundoHombres22 = 0;
    $sumaSegundoMujeres22 = 0;

    $sumaSegundoHombres23 = 0;
    $sumaSegundoMujeres23 = 0;

    $sumaSegundoHombres24 = 0;
    $sumaSegundoMujeres24 = 0;

    $sumaSegundoHombres25 = 0;
    $sumaSegundoMujeres25 = 0;

    $sumaSegundoHombresExistentes = 0;
    $sumaSegundoMujeresExistentes = 0;

    $sumaSegundoHombresBajas = 0;
    $sumaSegundoMujeresBajas = 0;

    $sumaSegundoHombresInscritos = 0;
    $sumaSegundoMujeresInscritos = 0;

    #segundos
    $sumaTerceroHombres14 = 0;
    $sumaTerceroMujeres14 = 0;

    $sumaTerceroHombres15 = 0;
    $sumaTerceroMujeres15 = 0;

    $sumaTerceroHombres16 = 0;
    $sumaTerceroMujeres16 = 0;

    $sumaTerceroHombres17 = 0;
    $sumaTerceroMujeres17 = 0;

    $sumaTerceroHombres18 = 0;
    $sumaTerceroMujeres18 = 0;

    $sumaTerceroHombres19 = 0;
    $sumaTerceroMujeres19 = 0;

    $sumaTerceroHombres20 = 0;
    $sumaTerceroMujeres20 = 0;

    $sumaTerceroHombres21 = 0;
    $sumaTerceroMujeres21 = 0;
    
    $sumaTerceroHombres22 = 0;
    $sumaTerceroMujeres22 = 0;

    $sumaTerceroHombres23 = 0;
    $sumaTerceroMujeres23 = 0;

    $sumaTerceroHombres24 = 0;
    $sumaTerceroMujeres24 = 0;

    $sumaTerceroHombres25 = 0;
    $sumaTerceroMujeres25 = 0;

    $sumaTerceroHombresExistentes = 0;
    $sumaTerceroMujeresExistentes = 0;

    $sumaTerceroHombresBajas = 0;
    $sumaTerceroMujeresBajas = 0;

    $sumaTerceroHombresInscritos = 0;
    $sumaTerceroMujeresInscritos = 0;


    $totalExistentes = 0;
    $totalBajas = 0;
    $totalInscritos = 0;
  @endphp


  @if ($numeroPerido == 3 || $numeroPerido == 1)
    <div class="row">
      <div class="columns medium-12">
        <p>Primeros</p>

      </div>
    </div>
    <div class="row">
      <div class="columns medium-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 0px;" class="punteado2">Edades</th>
              <th class="punteado2" align="center">14</th>
              <th class="punteado2" align="center">15</th>
              <th class="punteado2" align="center">16</th>
              <th class="punteado2" align="center">17</th>
              <th class="punteado2" align="center">18</th>
              <th class="punteado2" align="center">19</th>
              <th class="punteado2" align="center">20</th>
              <th class="punteado2" align="center">21</th>
              <th class="punteado2" align="center">22</th>
              <th class="punteado2" align="center">23</th>
              <th class="punteado2" align="center">24</th>
              <th class="punteado2" align="center">25</th>
              <th class="punteado2" align="center">Exist</th>
              <th class="punteado2" align="center">Bajas</th>
              <th class="punteado2" align="center">Inscr</th>
            </tr>          
          </thead>
          <tbody>
            <tr>
              <td>Hombres:</td>
            @foreach ($conteo_edades as $primeros)               
              @if ($primeros->grado == "Primeros" && $primeros->sexo == "M")        

              <td align="center">
                @isset($primeros->edad14)
                {{$primeros->edad14}}
                @endisset                
              </td>    


              @isset($primeros->edad14)
                @php
                  $sumaPrimeroHombres14 = $primeros->edad14;
                @endphp  
              @endisset 
              

              <td align="center">
                @isset($primeros->edad15)
                {{$primeros->edad15}}
                @endisset  
              </td>    

              @isset($primeros->edad15)
                @php
                  $sumaPrimeroHombres15 = $primeros->edad15;
                @endphp
              @endisset
                     

              <td align="center">
                @isset($primeros->edad16)
                {{$primeros->edad16}}
                @endisset  
              </td>    

              @isset($primeros->edad16)
                @php
                  $sumaPrimeroHombres16 = $primeros->edad16;
                @endphp
              @endisset

              <td align="center">
                @isset($primeros->edad17)
                {{$primeros->edad17}}
                @endisset  
              </td>    

              @isset($primeros->edad17)
                @php
                  $sumaPrimeroHombres17 = $primeros->edad17;
                @endphp
              @endisset

              <td align="center">
                @isset($primeros->edad18)
                {{$primeros->edad18}}
                @endisset  
              </td>    

              @isset($primeros->edad18)
                @php
                  $sumaPrimeroHombres18 = $primeros->edad18;
                @endphp
              @endisset

              {{--  19  --}}
              <td align="center">
                @isset($primeros->edad19)
                {{$primeros->edad19}}
                @endisset  
              </td>    

              @isset($primeros->edad19)
                @php
                  $sumaPrimeroHombres19 = $primeros->edad19;
                @endphp
              @endisset

              {{--  20  --}}
              <td align="center">
                @isset($primeros->edad20)
                {{$primeros->edad20}}
                @endisset  
              </td>    

              @isset($primeros->edad20)
                @php
                  $sumaPrimeroHombres20 = $primeros->edad20;
                @endphp
              @endisset

              {{--  21  --}}
              <td align="center">
                @isset($primeros->edad21)
                {{$primeros->edad21}}
                @endisset  
              </td>    

              @isset($primeros->edad21)
                @php
                  $sumaPrimeroHombres21 = $primeros->edad21;
                @endphp
              @endisset

              {{--  22   --}}
              <td align="center">
                @isset($primeros->edad22)
                {{$primeros->edad22}}
                @endisset  
              </td>    

              @isset($primeros->edad22)
                @php
                  $sumaPrimeroHombres22 = $primeros->edad22;
                @endphp
              @endisset

              {{--  23   --}}
              <td align="center">
                @isset($primeros->edad23)
                {{$primeros->edad23}}
                @endisset  
              </td>    

              @isset($primeros->edad23)
                @php
                  $sumaPrimeroHombres23 = $primeros->edad23;
                @endphp
              @endisset


              {{--  24   --}}
              <td align="center">
                @isset($primeros->edad24)
                {{$primeros->edad24}}
                @endisset  
              </td>    

              @isset($primeros->edad24)
                @php
                  $sumaPrimeroHombres24 = $primeros->edad24;
                @endphp
              @endisset

              {{--  25   --}}
              <td align="center">
                @isset($primeros->edad25)
                {{$primeros->edad25}}
                @endisset  
              </td>    

              @isset($primeros->edad25)
                @php
                  $sumaPrimeroHombres25 = $primeros->edad25;
                @endphp
              @endisset

              <td align="center">{{$primeros->existencia}}</td>  
              @php
                  $sumaPrimeroHombresExistentes = $primeros->existencia;
              @endphp

              <td align="center">{{$primeros->bajas}}</td> 
              @php
                  $sumaPrimeroHombresBajas = $primeros->bajas;
              @endphp

              <td align="center">{{$primeros->inscritos}}</td> 
              @php
                  $sumaPrimeroHombresInscritos = $primeros->inscritos;
              @endphp
              @endif              
            @endforeach
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Mujeres:</td>
              @foreach ($conteo_edades as $primeros)               
                @if ($primeros->grado == "Primeros" && $primeros->sexo == "F")
                
                <td align="center">
                  @isset($primeros->edad14)
                    {{$primeros->edad14}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad14)
                  @php
                    $sumaPrimeroMujeres14 = $primeros->edad14;
                  @endphp
                @endisset 


                {{--  15   --}}
                <td align="center">
                  @isset($primeros->edad15)
                    {{$primeros->edad15}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad15)
                  @php
                    $sumaPrimeroMujeres15 = $primeros->edad15;
                  @endphp
                @endisset 

                {{--  16   --}}
                <td align="center">
                  @isset($primeros->edad16)
                    {{$primeros->edad16}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad16)
                  @php
                    $sumaPrimeroMujeres16 = $primeros->edad16;
                  @endphp
                @endisset 


                {{--  17   --}}
                <td align="center">
                  @isset($primeros->edad17)
                    {{$primeros->edad17}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad17)
                  @php
                    $sumaPrimeroMujeres17 = $primeros->edad17;
                  @endphp
                @endisset 

                {{--  18   --}}
                <td align="center">
                  @isset($primeros->edad18)
                    {{$primeros->edad18}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad18)
                  @php
                    $sumaPrimeroMujeres18 = $primeros->edad18;
                  @endphp
                @endisset                 

                {{--  19   --}}
                <td align="center">
                  @isset($primeros->edad19)
                    {{$primeros->edad19}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad19)
                  @php
                    $sumaPrimeroMujeres19 = $primeros->edad19;
                  @endphp
                @endisset 

                {{--  20   --}}
                <td align="center">
                  @isset($primeros->edad20)
                    {{$primeros->edad20}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad20)
                  @php
                    $sumaPrimeroMujeres20 = $primeros->edad20;
                  @endphp
                @endisset 

                {{--  21   --}}
                <td align="center">
                  @isset($primeros->edad21)
                    {{$primeros->edad21}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad21)
                  @php
                    $sumaPrimeroMujeres21 = $primeros->edad21;
                  @endphp
                @endisset 

                {{--  22   --}}
                <td align="center">
                  @isset($primeros->eda22)
                    {{$primeros->eda22}}
                  @endisset 
                </td>    
                
                @isset($primeros->eda22)
                  @php
                    $sumaPrimeroMujeres20 = $primeros->eda22;
                  @endphp
                @endisset 

                {{--  23   --}}
                <td align="center">
                  @isset($primeros->edad23)
                    {{$primeros->edad23}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad23)
                  @php
                    $sumaPrimeroMujeres23 = $primeros->edad23;
                  @endphp
                @endisset 

                {{--  24   --}}
                <td align="center">
                  @isset($primeros->edad24)
                    {{$primeros->edad24}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad24)
                  @php
                    $sumaPrimeroMujeres24 = $primeros->edad24;
                  @endphp
                @endisset 

                {{--  25   --}}
                <td align="center">
                  @isset($primeros->edad25)
                    {{$primeros->edad25}}
                  @endisset 
                </td>    
                
                @isset($primeros->edad25)
                  @php
                    $sumaPrimeroMujeres25 = $primeros->edad25;
                  @endphp
                @endisset 
             

                <td align="center">{{$primeros->existencia}}</td>  
                @php
                  $sumaPrimeroMujeresExistentes = $primeros->existencia;
                @endphp

                <td align="center">{{$primeros->bajas}}</td> 
                @php
                  $sumaPrimeroMujeresBajas = $primeros->bajas;
                @endphp

                <td align="center">{{$primeros->inscritos}}</td> 
                @php
                  $sumaPrimeroMujeresInscritos = $primeros->inscritos;
                @endphp
                @endif              
              @endforeach
            </tr>
          </tbody>


          <tbody>
            <tr>
              <td></td>
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres14 + $sumaPrimeroMujeres14 != 0) {{$sumaPrimeroHombres14 + $sumaPrimeroMujeres14}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres15 + $sumaPrimeroMujeres15 != 0) {{$sumaPrimeroHombres15 + $sumaPrimeroMujeres15}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres16 + $sumaPrimeroMujeres16 != 0) {{$sumaPrimeroHombres16 + $sumaPrimeroMujeres16}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres17 + $sumaPrimeroMujeres17 != 0) {{$sumaPrimeroHombres17 + $sumaPrimeroMujeres17}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres18 + $sumaPrimeroMujeres18 != 0) {{$sumaPrimeroHombres18 + $sumaPrimeroMujeres18}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres19 + $sumaPrimeroMujeres19 != 0) {{$sumaPrimeroHombres19 + $sumaPrimeroMujeres19}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres20 + $sumaPrimeroMujeres20 != 0) {{$sumaPrimeroHombres20 + $sumaPrimeroMujeres20}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres21 + $sumaPrimeroMujeres21 != 0) {{$sumaPrimeroHombres21 + $sumaPrimeroMujeres21}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres22 + $sumaPrimeroMujeres22 != 0) {{$sumaPrimeroHombres22 + $sumaPrimeroMujeres22}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres23 + $sumaPrimeroMujeres23 != 0) {{$sumaPrimeroHombres23 + $sumaPrimeroMujeres23}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres24 + $sumaPrimeroMujeres24 != 0) {{$sumaPrimeroHombres24 + $sumaPrimeroMujeres24}} @endif</td>       
              <td align="center" class="punteado3">@if ($sumaPrimeroHombres25 + $sumaPrimeroMujeres25 != 0) {{$sumaPrimeroHombres25 + $sumaPrimeroMujeres25}} @endif</td>       


              <td align="center" class="punteado3"><b>{{$sumaPrimeroHombresExistentes + $sumaPrimeroMujeresExistentes}}</b></td>  
              @php
                $totalExistentes = $totalExistentes + $sumaPrimeroHombresExistentes + $sumaPrimeroMujeresExistentes;
              @endphp

              <td align="center" class="punteado3"><b>{{$sumaPrimeroHombresBajas + $sumaPrimeroMujeresBajas}}</b></td> 
              @php
                $totalBajas = $totalBajas + $sumaPrimeroHombresBajas + $sumaPrimeroMujeresBajas;
              @endphp

              <td align="center" class="punteado3"><b>{{$sumaPrimeroHombresInscritos + $sumaPrimeroMujeresInscritos}}</b></td> 
              @php
                $totalInscritos = $totalInscritos + $sumaPrimeroHombresInscritos + $sumaPrimeroMujeresInscritos;
              @endphp
            </tr>
          </tbody>
        </table>

      </div>
    </div>


    <br>
    <br>
    {{--  segundos   --}}
    <div class="row">
      <div class="columns medium-12">
        <p>Segundos</p>

      </div>
    </div>
    <div class="row">
      <div class="columns medium-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 0px;" class="punteado2">Edades</th>
              <th class="punteado2" align="center">14</th>
              <th class="punteado2" align="center">15</th>
              <th class="punteado2" align="center">16</th>
              <th class="punteado2" align="center">17</th>
              <th class="punteado2" align="center">18</th>
              <th class="punteado2" align="center">19</th>
              <th class="punteado2" align="center">20</th>
              <th class="punteado2" align="center">21</th>
              <th class="punteado2" align="center">22</th>
              <th class="punteado2" align="center">23</th>
              <th class="punteado2" align="center">24</th>
              <th class="punteado2" align="center">25</th>
              <th class="punteado2" align="center">Exist</th>
              <th class="punteado2" align="center">Bajas</th>
              <th class="punteado2" align="center">Inscr</th>
            </tr>          
          </thead>
          <tbody>
            <tr>
              <td>Hombres:</td>
            @foreach ($conteo_edades as $segundos)               
              @if ($segundos->grado == "Segundos" && $segundos->sexo == "M")        

              {{--  14   --}}
              <td align="center">
                @isset($segundos->edad14)
                  {{$segundos->edad14}}
                @endisset 
              </td>    

              @isset($segundos->edad14)
                @php
                  $sumaSegundoHombres14 = $segundos->edad14;
                @endphp   
              @endisset 
              

              {{--  15   --}}
              <td align="center">
                @isset($segundos->edad15)
                  {{$segundos->edad15}}
                @endisset 
              </td>    

              @isset($segundos->edad15)
                @php
                  $sumaSegundoHombres15 = $segundos->edad15;
                @endphp   
              @endisset 


              {{--  16   --}}
              <td align="center">
                @isset($segundos->edad16)
                  {{$segundos->edad16}}
                @endisset 
              </td>    

              @isset($segundos->edad16)
                @php
                  $sumaSegundoHombres16 = $segundos->edad16;
                @endphp   
              @endisset 


              {{--  17   --}}
              <td align="center">
                @isset($segundos->edad17)
                  {{$segundos->edad17}}
                @endisset 
              </td>    

              @isset($segundos->edad17)
                @php
                  $sumaSegundoHombres17 = $segundos->edad17;
                @endphp   
              @endisset 


              {{--  18   --}}
              <td align="center">
                @isset($segundos->edad18)
                  {{$segundos->edad18}}
                @endisset 
              </td>    

              @isset($segundos->edad18)
                @php
                  $sumaSegundoHombres18 = $segundos->edad18;
                @endphp   
              @endisset 


              {{--  19   --}}
              <td align="center">
                @isset($segundos->edad19)
                  {{$segundos->edad19}}
                @endisset 
              </td>    

              @isset($segundos->edad19)
                @php
                  $sumaSegundoHombres19 = $segundos->edad19;
                @endphp   
              @endisset 


              {{--  20   --}}
              <td align="center">
                @isset($segundos->edad20)
                  {{$segundos->edad20}}
                @endisset 
              </td>    

              @isset($segundos->edad20)
                @php
                  $sumaSegundoHombres20 = $segundos->edad20;
                @endphp   
              @endisset 


              {{--  21   --}}
              <td align="center">
                @isset($segundos->edad21)
                  {{$segundos->edad21}}
                @endisset 
              </td>    

              @isset($segundos->edad21)
                @php
                  $sumaSegundoHombres21 = $segundos->edad21;
                @endphp   
              @endisset 


              {{--  22   --}}
              <td align="center">
                @isset($segundos->edad22)
                  {{$segundos->edad22}}
                @endisset 
              </td>    

              @isset($segundos->edad22)
                @php
                  $sumaSegundoHombres22 = $segundos->edad22;
                @endphp   
              @endisset 


              {{--  23   --}}
              <td align="center">
                @isset($segundos->edad23)
                  {{$segundos->edad23}}
                @endisset 
              </td>    

              @isset($segundos->edad23)
                @php
                  $sumaSegundoHombres23 = $segundos->edad23;
                @endphp   
              @endisset 

              {{--  24   --}}
              <td align="center">
                @isset($segundos->edad24)
                  {{$segundos->edad24}}
                @endisset 
              </td>    

              @isset($segundos->edad24)
                @php
                  $sumaSegundoHombres24 = $segundos->edad24;
                @endphp   
              @endisset 


              {{--  25   --}}
              <td align="center">
                @isset($segundos->edad25)
                  {{$segundos->edad25}}
                @endisset 
              </td>    

              @isset($segundos->edad25)
                @php
                  $sumaSegundoHombres25 = $segundos->edad25;
                @endphp   
              @endisset 

               
              <td align="center">{{$segundos->existencia}}</td>  
              @php
                  $sumaSegundoHombresExistentes = $segundos->existencia;
              @endphp

              <td align="center">{{$segundos->bajas}}</td> 
              @php
                  $sumaSegundoHombresBajas = $segundos->bajas;
              @endphp

              <td align="center">{{$segundos->inscritos}}</td> 
              @php
                  $sumaSegundoHombresInscritos = $segundos->inscritos;
              @endphp
              @endif              
            @endforeach
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Mujeres:</td>
              @foreach ($conteo_edades as $segundos)               
                @if ($segundos->grado == "Segundos" && $segundos->sexo == "F")
                
                {{--  14   --}}
                <td align="center">
                  @isset($segundos->edad14)
                    {{$segundos->edad14}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad14)
                  @php
                    $sumaSegundoMujeres14 = $segundos->edad14;
                  @endphp
                @endisset 

                {{--  15   --}}
                <td align="center">
                  @isset($segundos->edad15)
                    {{$segundos->edad15}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad15)
                  @php
                    $sumaSegundoMujeres15 = $segundos->edad15;
                  @endphp
                @endisset 


                {{--  16   --}}
                <td align="center">
                  @isset($segundos->edad16)
                    {{$segundos->edad16}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad16)
                  @php
                    $sumaSegundoMujeres16 = $segundos->edad16;
                  @endphp
                @endisset 


                {{--  17   --}}
                <td align="center">
                  @isset($segundos->edad17)
                    {{$segundos->edad17}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad17)
                  @php
                    $sumaSegundoMujeres17 = $segundos->edad17;
                  @endphp
                @endisset 

                {{--  18   --}}
                <td align="center">
                  @isset($segundos->edad18)
                    {{$segundos->edad18}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad18)
                  @php
                    $sumaSegundoMujeres18 = $segundos->edad18;
                  @endphp
                @endisset 

                {{--  19  --}}
                <td align="center">
                  @isset($segundos->edad19)
                    {{$segundos->edad19}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad19)
                  @php
                    $sumaSegundoMujeres19 = $segundos->edad19;
                  @endphp
                @endisset 

                {{--  20   --}}
                <td align="center">
                  @isset($segundos->edad20)
                    {{$segundos->edad20}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad20)
                  @php
                    $sumaSegundoMujeres20 = $segundos->edad20;
                  @endphp
                @endisset 

                {{--  21  --}}
                <td align="center">
                  @isset($segundos->edad21)
                    {{$segundos->edad21}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad21)
                  @php
                    $sumaSegundoMujeres21 = $segundos->edad21;
                  @endphp
                @endisset 


                {{--  22  --}}
                <td align="center">
                  @isset($segundos->edad22)
                    {{$segundos->edad22}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad22)
                  @php
                    $sumaSegundoMujeres22 = $segundos->edad22;
                  @endphp
                @endisset 

                {{--  23  --}}
                <td align="center">
                  @isset($segundos->edad23)
                    {{$segundos->edad23}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad23)
                  @php
                    $sumaSegundoMujeres23 = $segundos->edad23;
                  @endphp
                @endisset 

                {{--  24  --}}
                <td align="center">
                  @isset($segundos->edad24)
                    {{$segundos->edad24}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad24)
                  @php
                    $sumaSegundoMujeres24 = $segundos->edad24;
                  @endphp
                @endisset 

                {{--  25  --}}
                <td align="center">
                  @isset($segundos->edad25)
                    {{$segundos->edad25}}
                  @endisset 
                </td>   
                
                @isset($segundos->edad25)
                  @php
                    $sumaSegundoMujeres25 = $segundos->edad25;
                  @endphp
                @endisset 
                

                  

                <td align="center">{{$segundos->existencia}}</td>  
                @php
                  $sumaSegundoMujeresExistentes = $segundos->existencia;
                @endphp

                <td align="center">{{$segundos->bajas}}</td> 
                @php
                  $sumaSegundoMujeresBajas = $segundos->bajas;
                @endphp

                <td align="center">{{$segundos->inscritos}}</td> 
                @php
                  $sumaSegundoMujeresInscritos = $segundos->inscritos;
                @endphp
                @endif              
              @endforeach
            </tr>
          </tbody>


          <tbody>
            <tr>
              <td></td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres14 + $sumaSegundoMujeres14 != 0) {{$sumaSegundoHombres14 + $sumaSegundoMujeres14}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres15 + $sumaSegundoMujeres15 != 0) {{$sumaSegundoHombres15 + $sumaSegundoMujeres15}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres16 + $sumaSegundoMujeres16 != 0) {{$sumaSegundoHombres16 + $sumaSegundoMujeres16}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres17 + $sumaSegundoMujeres17 != 0) {{$sumaSegundoHombres17 + $sumaSegundoMujeres17}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres18 + $sumaSegundoMujeres18 != 0) {{$sumaSegundoHombres18 + $sumaSegundoMujeres18}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres19 + $sumaSegundoMujeres19 != 0) {{$sumaSegundoHombres19 + $sumaSegundoMujeres19}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres20 + $sumaSegundoMujeres20 != 0) {{$sumaSegundoHombres20 + $sumaSegundoMujeres20}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres21 + $sumaSegundoMujeres21 != 0) {{$sumaSegundoHombres21 + $sumaSegundoMujeres21}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres22 + $sumaSegundoMujeres22 != 0) {{$sumaSegundoHombres22 + $sumaSegundoMujeres22}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres23 + $sumaSegundoMujeres23 != 0) {{$sumaSegundoHombres23 + $sumaSegundoMujeres23}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres24 + $sumaSegundoMujeres24 != 0) {{$sumaSegundoHombres24 + $sumaSegundoMujeres24}} @endif</td>
              <td align="center" class="punteado3">@if($sumaSegundoHombres25 + $sumaSegundoMujeres25 != 0) {{$sumaSegundoHombres25 + $sumaSegundoMujeres25}} @endif</td>

              <td align="center" class="punteado3"><b>{{$sumaSegundoHombresExistentes + $sumaSegundoMujeresExistentes}}</b></td>  
              @php
                $totalExistentes = $totalExistentes + $sumaSegundoHombresExistentes + $sumaSegundoMujeresExistentes;
              @endphp

              <td align="center" class="punteado3"><b>{{$sumaSegundoHombresBajas + $sumaSegundoMujeresBajas}}</b></td> 
              @php
                $totalBajas = $totalBajas + $sumaSegundoHombresBajas + $sumaSegundoMujeresBajas;
              @endphp

              <td align="center" class="punteado3"><b>{{$sumaSegundoHombresInscritos + $sumaSegundoMujeresInscritos}}</b></td> 
              @php
                $totalInscritos = $totalInscritos + $sumaSegundoHombresInscritos + $sumaSegundoMujeresInscritos;
              @endphp
            </tr>
          </tbody>
        </table>

      </div>
    </div>


    <br>
    <br>
    {{--  terceros   --}}
    <div class="row">
      <div class="columns medium-12">
        <p>Terceros</p>

      </div>
    </div>
    <div class="row">
      <div class="columns medium-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 0px;" class="punteado2">Edades</th>
              <th class="punteado2" align="center">14</th>
              <th class="punteado2" align="center">15</th>
              <th class="punteado2" align="center">16</th>
              <th class="punteado2" align="center">17</th>
              <th class="punteado2" align="center">18</th>
              <th class="punteado2" align="center">19</th>
              <th class="punteado2" align="center">20</th>
              <th class="punteado2" align="center">21</th>
              <th class="punteado2" align="center">22</th>
              <th class="punteado2" align="center">23</th>
              <th class="punteado2" align="center">24</th>
              <th class="punteado2" align="center">25</th>
              <th class="punteado2" align="center">Exist</th>
              <th class="punteado2" align="center">Bajas</th>
              <th class="punteado2" align="center">Inscr</th>
            </tr>          
          </thead>
          <tbody>
            <tr>
              <td>Hombres:</td>
            @foreach ($conteo_edades as $terceros)               
              @if ($terceros->grado == "Terceros" && $terceros->sexo == "M")        

              {{--  14   --}}
              <td align="center">
                @isset($terceros->edad14)
                  {{$terceros->edad14}}
                @endisset 
              </td>    

              @isset($terceros->edad14)
                @php
                  $sumaTerceroHombres14 = $terceros->edad14;
                @endphp  
              @endisset 


              {{--  15  --}}
              <td align="center">
                @isset($terceros->edad15)
                  {{$terceros->edad15}}
                @endisset 
              </td>    

              @isset($terceros->edad15)
                @php
                  $sumaTerceroHombres15 = $terceros->edad15;
                @endphp  
              @endisset 

              {{--  16  --}}
              <td align="center">
                @isset($terceros->edad16)
                  {{$terceros->edad16}}
                @endisset 
              </td>    

              @isset($terceros->edad16)
                @php
                  $sumaTerceroHombres16 = $terceros->edad16;
                @endphp  
              @endisset 

              {{--  17  --}}
              <td align="center">
                @isset($terceros->edad17)
                  {{$terceros->edad17}}
                @endisset 
              </td>    

              @isset($terceros->edad17)
                @php
                  $sumaTerceroHombres17 = $terceros->edad17;
                @endphp  
              @endisset 

              {{--  18  --}}
              <td align="center">
                @isset($terceros->edad18)
                  {{$terceros->edad18}}
                @endisset 
              </td>    

              @isset($terceros->edad18)
                @php
                  $sumaTerceroHombres18 = $terceros->edad18;
                @endphp  
              @endisset 

              {{--  19  --}}
              <td align="center">
                @isset($terceros->edad19)
                  {{$terceros->edad19}}
                @endisset 
              </td>    

              @isset($terceros->edad19)
                @php
                  $sumaTerceroHombres19 = $terceros->edad19;
                @endphp  
              @endisset 

              {{--  20  --}}
              <td align="center">
                @isset($terceros->edad20)
                  {{$terceros->edad20}}
                @endisset 
              </td>    

              @isset($terceros->edad20)
                @php
                  $sumaTerceroHombres20 = $terceros->edad20;
                @endphp  
              @endisset 

              {{--  21  --}}
              <td align="center">
                @isset($terceros->edad21)
                  {{$terceros->edad21}}
                @endisset 
              </td>    

              @isset($terceros->edad21)
                @php
                  $sumaTerceroHombres21 = $terceros->edad21;
                @endphp  
              @endisset 

              {{--  22  --}}
              <td align="center">
                @isset($terceros->edad22)
                  {{$terceros->edad22}}
                @endisset 
              </td>    

              @isset($terceros->edad22)
                @php
                  $sumaTerceroHombres22 = $terceros->edad22;
                @endphp  
              @endisset 

              {{--  23  --}}
              <td align="center">
                @isset($terceros->edad23)
                  {{$terceros->edad23}}
                @endisset 
              </td>    

              @isset($terceros->edad23)
                @php
                  $sumaTerceroHombres23 = $terceros->edad23;
                @endphp  
              @endisset 

              {{--  24  --}}
              <td align="center">
                @isset($terceros->edad24)
                  {{$terceros->edad24}}
                @endisset 
              </td>    

              @isset($terceros->edad24)
                @php
                  $sumaTerceroHombres24 = $terceros->edad24;
                @endphp  
              @endisset 

              {{--  25  --}}
              <td align="center">
                @isset($terceros->edad25)
                  {{$terceros->edad25}}
                @endisset 
              </td>    

              @isset($terceros->edad25)
                @php
                  $sumaTerceroHombres25 = $terceros->edad25;
                @endphp  
              @endisset 
               

                
              <td align="center">{{$terceros->existencia}}</td>  
              @php
                  $sumaTerceroHombresExistentes = $terceros->existencia;
              @endphp

              <td align="center">{{$terceros->bajas}}</td> 
              @php
                  $sumaTerceroHombresBajas = $terceros->bajas;
              @endphp

              <td align="center">{{$terceros->inscritos}}</td> 
              @php
                  $sumaTerceroHombresInscritos = $terceros->inscritos;
              @endphp
              @endif              
            @endforeach
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Mujeres:</td>
              @foreach ($conteo_edades as $terceros)               
                @if ($terceros->grado == "Terceros" && $terceros->sexo == "F")
                
                {{--  14   --}}
                <td align="center">
                  @isset($terceros->edad14)
                    {{$terceros->edad14}}
                  @endisset 
                </td>      

                @isset($terceros->edad14)
                  @php
                    $sumaTerceroMujeres14 = $terceros->edad14;
                  @endphp
                @endisset 
                

                {{--  15  --}}
                <td align="center">
                  @isset($terceros->edad15)
                    {{$terceros->edad15}}
                  @endisset 
                </td>      

                @isset($terceros->edad15)
                  @php
                    $sumaTerceroMujeres15 = $terceros->edad15;
                  @endphp
                @endisset 

                {{--  16  --}}
                <td align="center">
                  @isset($terceros->edad16)
                    {{$terceros->edad16}}
                  @endisset 
                </td>      

                @isset($terceros->edad16)
                  @php
                    $sumaTerceroMujeres16 = $terceros->edad16;
                  @endphp
                @endisset 

                {{--  17  --}}
                <td align="center">
                  @isset($terceros->edad17)
                    {{$terceros->edad17}}
                  @endisset 
                </td>      

                @isset($terceros->edad17)
                  @php
                    $sumaTerceroMujeres17 = $terceros->edad17;
                  @endphp
                @endisset 

                {{--  18  --}}
                <td align="center">
                  @isset($terceros->edad18)
                    {{$terceros->edad18}}
                  @endisset 
                </td>      

                @isset($terceros->edad18)
                  @php
                    $sumaTerceroMujeres18 = $terceros->edad18;
                  @endphp
                @endisset 

                {{--  19  --}}
                <td align="center">
                  @isset($terceros->edad19)
                    {{$terceros->edad19}}
                  @endisset 
                </td>      

                @isset($terceros->edad19)
                  @php
                    $sumaTerceroMujeres19 = $terceros->edad19;
                  @endphp
                @endisset 

                {{--  20  --}}
                <td align="center">
                  @isset($terceros->edad20)
                    {{$terceros->edad20}}
                  @endisset 
                </td>      

                @isset($terceros->edad20)
                  @php
                    $sumaTerceroMujeres20 = $terceros->edad20;
                  @endphp
                @endisset 

                {{--  21  --}}
                <td align="center">
                  @isset($terceros->edad21)
                    {{$terceros->edad21}}
                  @endisset 
                </td>      

                @isset($terceros->edad21)
                  @php
                    $sumaTerceroMujeres21 = $terceros->edad21;
                  @endphp
                @endisset 

                {{--  22  --}}
                <td align="center">
                  @isset($terceros->edad22)
                    {{$terceros->edad22}}
                  @endisset 
                </td>      

                @isset($terceros->edad22)
                  @php
                    $sumaTerceroMujeres22 = $terceros->edad22;
                  @endphp
                @endisset 

                {{--  23  --}}
                <td align="center">
                  @isset($terceros->edad23)
                    {{$terceros->edad23}}
                  @endisset 
                </td>      

                @isset($terceros->edad23)
                  @php
                    $sumaTerceroMujeres23 = $terceros->edad23;
                  @endphp
                @endisset 

                {{--  24  --}}
                <td align="center">
                  @isset($terceros->edad24)
                    {{$terceros->edad24}}
                  @endisset 
                </td>      

                @isset($terceros->edad24)
                  @php
                    $sumaTerceroMujeres24 = $terceros->edad24;
                  @endphp
                @endisset 

                {{--  25  --}}
                <td align="center">
                  @isset($terceros->edad25)
                    {{$terceros->edad25}}
                  @endisset 
                </td>      

                @isset($terceros->edad25)
                  @php
                    $sumaTerceroMujeres25 = $terceros->edad25;
                  @endphp
                @endisset 


                <td align="center">{{$terceros->existencia}}</td>  
                @php
                  $sumaTerceroMujeresExistentes = $terceros->existencia;
                @endphp

                <td align="center">{{$terceros->bajas}}</td> 
                @php
                  $sumaTerceroMujeresBajas = $terceros->bajas;
                @endphp

                <td align="center">{{$terceros->inscritos}}</td> 
                @php
                  $sumaTerceroMujeresInscritos = $terceros->inscritos;
                @endphp
                @endif              
              @endforeach
            </tr>
          </tbody>


          <tbody>
            <tr>
              <td></td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres14 + $sumaTerceroMujeres14 != 0) {{$sumaTerceroHombres14 + $sumaTerceroMujeres14}} @endif</td>     
              <td align="center" class="punteado3">@if($sumaTerceroHombres14 + $sumaTerceroMujeres15 != 0) {{$sumaTerceroHombres15 + $sumaTerceroMujeres15}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres16 + $sumaTerceroMujeres16 != 0) {{$sumaTerceroHombres16 + $sumaTerceroMujeres16}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres17 + $sumaTerceroMujeres17 != 0) {{$sumaTerceroHombres17 + $sumaTerceroMujeres17}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres18 + $sumaTerceroMujeres18 != 0) {{$sumaTerceroHombres18 + $sumaTerceroMujeres18}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres19 + $sumaTerceroMujeres19 != 0) {{$sumaTerceroHombres19 + $sumaTerceroMujeres19}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres20 + $sumaTerceroMujeres20 != 0) {{$sumaTerceroHombres20 + $sumaTerceroMujeres20}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres21 + $sumaTerceroMujeres21 != 0) {{$sumaTerceroHombres21 + $sumaTerceroMujeres21}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres22 + $sumaTerceroMujeres22 != 0) {{$sumaTerceroHombres22 + $sumaTerceroMujeres22}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres23 + $sumaTerceroMujeres23 != 0) {{$sumaTerceroHombres23 + $sumaTerceroMujeres23}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres24 + $sumaTerceroMujeres24 != 0) {{$sumaTerceroHombres24 + $sumaTerceroMujeres24}} @endif</td>
              <td align="center" class="punteado3">@if($sumaTerceroHombres25 + $sumaTerceroMujeres25 != 0) {{$sumaTerceroHombres25 + $sumaTerceroMujeres25}} @endif</td>
 
              <td align="center" class="punteado3"><b>{{$sumaTerceroHombresExistentes + $sumaTerceroMujeresExistentes}}</b></td> 
              @php
                $totalExistentes = $totalExistentes + $sumaTerceroHombresExistentes + $sumaTerceroMujeresExistentes;
              @endphp 

              <td align="center" class="punteado3"><b>{{$sumaTerceroHombresBajas + $sumaTerceroMujeresBajas}}</b></td> 
              @php
                $totalBajas = $totalBajas + $sumaTerceroHombresBajas + $sumaTerceroMujeresBajas;
              @endphp

              <td align="center" class="punteado3"><b>{{$sumaTerceroHombresInscritos + $sumaTerceroMujeresInscritos}}</b></td> 
              @php
                $totalInscritos = $totalInscritos + $sumaTerceroHombresInscritos + $sumaTerceroMujeresInscritos;
              @endphp
            </tr>
          </tbody>
        </table>

      </div>
    </div>


    <br>
    {{--  totales   --}}
    <div class="row">
      <div class="columns medium-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 0px;" class="punteado4"><label style="opacity: 0.1; color: #ffffff">Edades</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">14</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">15</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">16</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">17</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">18</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">19</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">20</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">21</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">22</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">23</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">24</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">25</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">Exist</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">Bajas</label></th>
              <th class="punteado4"><label style="opacity: 0.1; color: #ffffff">Inscr</label></th>
            </tr>          
          </thead>
          <tbody>
            <tr>
              <td>Total<label style="opacity: 0.1; color: #ffffff">Hombres:</label></td>
              <td align="center" class="punteado4"><label style="opacity: 0.1; color: #ffffff">0</label></td>       
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td>
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td>
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td> 
              <td><label style="opacity: 0.1; color: #ffffff">0</label></td>    
              <td align="center" class="punteado4"><b>{{$totalExistentes}}</b></td> 
              <td align="center" class="punteado4"><b>{{$totalBajas}}</b></td> 
              <td align="center" class="punteado4"><b>{{$totalInscritos}}</b></td> 
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  @endif
  

</body>

</html>