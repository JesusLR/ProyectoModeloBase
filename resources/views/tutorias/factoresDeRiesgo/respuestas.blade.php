@extends('layouts.dashboard')

@section('template_title')
Respuestas
@endsection


@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_factores_riesgo')}}" class="breadcrumb">Lista de alumnos</a>
<label class="breadcrumb">Detalle de resultado</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">DETALLE DE RESULTADO - {{$respuestas_datos_alumno->NombreFormulario}}</span>

                <div class="row personalizado" style="border-radius: 2px;">                    
                    <div class="col s12 m6 l6 personalizado">
                        <p><strong>Alumno(a):</strong> {{$respuestas_datos_alumno->Nombre}} {{$respuestas_datos_alumno->ApellidoPaterno}} {{$respuestas_datos_alumno->ApellidoMaterno}}</p>
                        <p><strong>Carrera:</strong> {{$respuestas_datos_alumno->Carrera}}</p>
                        <p><strong>Fecha inicio de vigencia:</strong> {{ \Carbon\Carbon::parse($respuestas_datos_alumno->FechaInicioVigencia)->format('d/m/Y')}}</p>
                    </div>
                    <div class="col s12 m6 l6 personalizado">
                        <p><strong>Matricula:</strong> {{$respuestas_datos_alumno->Nombre}} {{$respuestas_datos_alumno->ApellidoPaterno}} {{$respuestas_datos_alumno->ApellidoMaterno}}</p>
                        <p><strong>Universidad:</strong> {{$respuestas_datos_alumno->Universidad}}</p>
                        <p><strong>Fecha fin de vigencia:</strong> {{ \Carbon\Carbon::parse($respuestas_datos_alumno->FechaFinVigencia)->format('d/m/Y')}}</p>
                    </div>
                </div>

                <br>
                
                <div class="row">
                    <div class="col l6">
                        <div class="row">
                            <div class="col l6 verde">
                                <h5>{{$totalVerde}} Bien</h5>
                            </div>
                            <div class="col l6 rojo">
                                <h5>{{$totalRojo}} Mal</h5>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col l6 amarillo">
                                <h5>{{$totalAmarillo}} Regular</h5>
                            </div>
                            <div class="col l6 noaplica">
                                <h5>{{$totalNoAplica}} NA</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col l4 total" style="margin: 6px">
                        <h2>Total {{$totalRespuestas}}</h2>
                    </div>
                </div>


                {{-- GENERAL BAR--}}
                <div id="general">
                    <div class="row">
                        <ul class="collapsible popout" data-collapsible="accordion">
                            @foreach ($categoria_respuestas as $categoriaRespuesta)
                            <li>
                                <div class="active collapsible-header" id="{{$categoriaRespuesta->CategoriaID}}">
                                    <i class="material-icons">question_answer</i>CATEGORÍA - {{$categoriaRespuesta->NombreCategoria}}</div>
                                <div class="collapsible-body">
                                    <div class="row">
                                      @foreach ($respuestas_alumno as $respuestas)
                                        @if ($categoriaRespuesta->CategoriaID == $respuestas->CategoriaID)
                                            <p>{{$respuestas->Nombre}}<i class="material-icons right">help_outline</i></p>
                                            
                                            @if ($respuestas->Tipo == 0)

                                                @if ($respuestas->Semaforizacion == 0)
                                                    <div class="btn" style="border-radius: 15px; background-color: #e0e0e0; text-aling:center; color:black">
                                                        <p>{{$respuestas->Respuesta}}</p>
                                                    </div>
                                                @endif    
                                                
                                                @if ($respuestas->Semaforizacion == 1)
                                                    <div class="btn" style="border-radius: 15px; background-color: #009688  ; text-aling:center">
                                                        <p>{{$respuestas->Respuesta}}</p>
                                                    </div>
                                                @endif

                                                @if ($respuestas->Semaforizacion == 2)
                                                    <div class="btn" style="border-radius: 15px; background-color: #ffe082; text-aling:center; color:black">
                                                        <p>{{$respuestas->Respuesta}}</p>
                                                    </div>
                                                @endif

                                                @if ($respuestas->Semaforizacion == 3)
                                                    <div class="btn" style="border-radius: 15px; background-color: #ef5350 ; text-aling:center;">
                                                        <p>{{$respuestas->Respuesta}}</p>
                                                    </div>
                                                @endif
                                                
                                            @endif
                                              @if ($respuestas->Tipo == 2)                                               
                                                
                                                  <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                                                  <input type="text" value="{{$respuestas->Respuesta}}" name="" id="" readonly="true">
                                                  <input type="hidden" value="{{$respuestas->PreguntaRespuestaID}}" name="PreguntaRespuestaID">

                                                  <br><br>

                                                  @if ($respuestas->Semaforizacion == 0)
                                                  <span class="material-icons left">traffic</span><p style="font-size: 17px"><strong>Semaforización</strong></p> 
                                                    <div class="col s12 m6 l4">                                                      
                                                      <label style="color: #000" for="semaforizacion">Usted puede cambiar la semaforización para esta respuesta, seleccione una opción</label> 
                                                      <select name="semaforizacion" id="{{$respuestas->PreguntaRespuestaID}}" required class="browser-default validate" style="width: 100%;">
                                                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                                          <option value="0" {{ 0 == $respuestas->Semaforizacion ? 'selected' : '' }}>NA</option>
                                                          <option value="1" {{ 1 == $respuestas->Semaforizacion ? 'selected' : '' }}>Bien</option>          
                                                          <option value="2" {{ 2 == $respuestas->Semaforizacion ? 'selected' : '' }}>Regular</option>                                                   
                                                          <option value="3" {{ 3 == $respuestas->Semaforizacion ? 'selected' : '' }}>Mal</option>                                   
                                                      </select> 
                                                    </div>

                                                  @else
                                                      <label style="color: red">Ya se ha actualizado la Semaforización en esta respuesta</label>
                                                  @endif
                                                 
                                                  <script>                                                   

                                                    $(document).ready(function(){
                                                      
                                                      $("select[id={{$respuestas->PreguntaRespuestaID}}]").change(function(){
                                                              //alert($('select[id={{$respuestas->PreguntaRespuestaID}}]').val());
                                                        let Semaforizacion = $('select[id={{$respuestas->PreguntaRespuestaID}}]').val()
                                                        let PreguntaRespuestaID = "{{$respuestas->PreguntaRespuestaID}}";
                                                        let token = $("#token").val();
                                                        swal({
                                                          title: "¿Estás seguro?",
                                                          text: "¿Estás seguro que deseas realizar cambio de semaforización?",
                                                          type: "info",
                                                          confirmButtonText: "Si",
                                                          confirmButtonColor: '#3085d6',
                                                          cancelButtonText: "No",
                                                          showCancelButton: true
                                                        },
                                                          function() {
                                                                
                                                            $.ajax({
                                                              url: "{{url('tutorias_factores_riesgo/edit')}}" + "/" + PreguntaRespuestaID,
                                                              headers: {"X-CSRF-TOKEN": token},
                                                              type: "PUT",
                                                              dataType: "json",
                                                              data: {Semaforizacion: Semaforizacion},
                                                              success: function(){
                                                                swal("Escuela Modelo", "La semaforización se actualizo con éxito", "success");
                                                                location.reload();
                                                              }
                                                            });
                                                            
                                                          });
                                                        });                                                                                        
                                                    });
                                                  </script>
                                              
                                                <br>
                                                <br>
                                                <br>
                                              @endif
                                              <br><br>
                                              {{-- en este apartado se muestra las opciones que podia elegir al responder la pregunta  --}}
                                              @foreach ($respuestasTable as $ResTable)
                                                @if ($respuestas->Tipo == 0)
                                                  @if ($ResTable->PreguntaID == $respuestas->PreguntaID)
                                                    <div class="col s4 m6 l4">
                                                      <input type="checkbox" id="{{$ResTable->RespuestaID}}"><label>{{$ResTable->Nombre}}</label>

                                                    </div>                                                      
                                                    @if ($ResTable->Nombre == $respuestas->Respuesta)
                                                      <script>
                                                        $("#{{$ResTable->RespuestaID}}").prop("checked", true);
                                                      </script>                                                   
                                                    @endif  
                                                  @endif
                                                @endif
                                              @endforeach
                                              <br><br>                                
                                            <br>
                                        @endif                                        
                                    @endforeach
                                    </div>
                                </div>
                            </li>
                            @endforeach                   
                        </ul>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <style>

      
      .personalizado{
        background-color: #01579B;
        color:#fff;
    }
    .verde{
        background-color: #009688;
        color:#000;
       
    }
    .rojo{
        background-color: #ef5350;
        color:#000;
        
    }
    .amarillo{
        background-color: #ffe082;
        color:#000;
        
    }
    .noaplica{
        background-color: #e0e0e0;
        color:#000;
       
    }
    .total{
        background-color: #00263A;
        color:#fff;
    }
 
          input[type="checkbox"][readonly] {
              pointer-events: none !important;
            }                             
    
            input:checked ~ .na {
              background-color: #e0e0e0;
            }
            input:checked ~ .verdee {
              background-color: #009688;
            }
            input:checked ~ .amarilloo {
              background-color: #ffe082;
            }
            input:checked ~ .rojoo {
              background-color: #ef5350;
            }
    </style>

    @endsection

    @section('footer_scripts')

    <script>
        (function ($) {
            $.fn.collapsible = function(options, methodParam) {
              var defaults = {
                accordion: undefined,
                onOpen: undefined,
                onClose: undefined
              };
          
              var methodName = options;
              options = $.extend(defaults, options);
          
          
              return this.each(function() {
          
                var $this = $(this);
          
                var $panel_headers = $(this).find('> li > .collapsible-header');
          
                var collapsible_type = $this.data("collapsible");
          
                /****************
                Helper Functions
                ****************/
          
                // Accordion Open
                function accordionOpen(object) {
                  $panel_headers = $this.find('> li > .collapsible-header');
                  if (object.hasClass('active')) {
                    object.parent().addClass('active');
                  }
                  else {
                    object.parent().removeClass('active');
                  }
                  if (object.parent().hasClass('active')){
                    object.siblings('.collapsible-body').stop(true,false).slideDown({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
                  }
                  else{
                    object.siblings('.collapsible-body').stop(true,false).slideUp({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
                  }
          
                  {{--  $panel_headers.not(object).removeClass('active').parent().removeClass('active');  --}}
          
          
                  // Cerrar elementos de acordeón previamente abiertos.
                  /*$panel_headers.not(object).parent().children('.collapsible-body').stop(true,false).each(function() {
                    if ($(this).is(':visible')) {
                      $(this).slideUp({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: false,
                        complete:
                          function() {
                            $(this).css('height', '');
                            execCallbacks($(this).siblings('.collapsible-header'));
                          }
                      });
                    }
                  });*/
                }
          
                // Expandable Open
                function expandableOpen(object) {
                  if (object.hasClass('active')) {
                    object.parent().addClass('active');
                  }
                  else {
                    object.parent().removeClass('active');
                  }
                  if (object.parent().hasClass('active')){
                    object.siblings('.collapsible-body').stop(true,false).slideDown({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
                  }
                  else {
                    object.siblings('.collapsible-body').stop(true,false).slideUp({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
                  }
                }
          
                // Open collapsible. object: .collapsible-header
                function collapsibleOpen(object, noToggle) {
                  if (!noToggle) {
                    object.toggleClass('active');
                  }
          
                  if (options.accordion || collapsible_type === "accordion" || collapsible_type === undefined) { // Handle Accordion
                    accordionOpen(object);
                  } else { // Handle Expandables
                    expandableOpen(object);
                  }
          
                  execCallbacks(object);
                }
          
                // Handle callbacks
                function execCallbacks(object) {
                  if (object.hasClass('active')) {
                    if (typeof(options.onOpen) === "function") {
                      options.onOpen.call(this, object.parent());
                    }
                  } else {
                    if (typeof(options.onClose) === "function") {
                      options.onClose.call(this, object.parent());
                    }
                  }
                }
          
                /**
                 * Check if object is children of panel header
                 * @param  {Object}  object Jquery object
                 * @return {Boolean} true if it is children
                 */
                function isChildrenOfPanelHeader(object) {
          
                  var panelHeader = getPanelHeader(object);
          
                  return panelHeader.length > 0;
                }
          
                /**
                 * Get panel header from a children element
                 * @param  {Object} object Jquery object
                 * @return {Object} panel header object
                 */
                function getPanelHeader(object) {
          
                  return object.closest('li > .collapsible-header');
                }
          
                /*****  End Helper Functions  *****/
          
          
                // Methods
                if (methodParam >= 0 &&
                    methodParam < $panel_headers.length) {
                  var $curr_header = $panel_headers.eq(methodParam);
                  if ($curr_header.length &&
                      (methodName === 'open' ||
                      (methodName === 'close' &&
                      $curr_header.hasClass('active')))) {
                    collapsibleOpen($curr_header);
                  }
                  return;
                }
          
          
                // Turn off any existing event handlers
                $this.off('click.collapse', '> li > .collapsible-header');
                $panel_headers.off('click.collapse');
          
          
                // Add click handler to only direct collapsible header children
                $this.on('click.collapse', '> li > .collapsible-header', function(e) {
                  var element = $(e.target);
          
                  if (isChildrenOfPanelHeader(element)) {
                    element = getPanelHeader(element);
                  }
          
                  collapsibleOpen(element);
                });
          
          
                // Open first active
                if (options.accordion || collapsible_type === "accordion" || collapsible_type === undefined) { // Handle Accordion
                  collapsibleOpen($panel_headers.filter('.active'), true);
                  {{--  collapsibleOpen($panel_headers.filter('.active').first(), true);  --}}

          
                } else { // Handle Expandables
                  $panel_headers.filter('.active').each(function() {
                    collapsibleOpen($(this), true);
                  });
                }
          
              });
            };
          
            $(document).ready(function(){
              $('.collapsible').collapsible();
            });
          }( jQuery ));

    </script>

    @endsection
