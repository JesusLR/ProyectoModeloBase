@extends('layouts.dashboard')

@section('template_title')
    Bachiller revalidación
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_revalidaciones.index')}}" class="breadcrumb">Lista de historial académico (revalidaciones)</a>    
    <a href="{{url('bachiller_revalidaciones/'.$bachiller_historico->id.'/edit')}}" class="breadcrumb">Editar revalidación</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_revalidaciones.update', $bachiller_historico->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR REVALIDACIÓN #{{$bachiller_historico->id}}</span>

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

                <div class="row" id="oculta">
                    <div class="col s12 m6 l4">
                        <div class="">
                            {!! Form::label('aluClave', 'Clave de pago *', array('class' => '')); !!}
                          {!! Form::number('aluClave', $bachiller_historico->aluClave, array('id' => 'aluClave', 'class' => 'validate','required', 'readonly')) !!}                          
                        </div>
                    </div>     
                    <div class="col s12 m6 l6">
                        <label for="nombreAlu">Nombre del alumno (solo lectura)</label>
                        <input type="text" value="{{$bachiller_historico->perApellido1.' '.$bachiller_historico->perApellido2.' '.$bachiller_historico->perNombre}}" id="nombreAlu" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required
                            name="ubicacion_id" style="width: 100%;">
                            <option value="{{$bachiller_historico->ubicacion_id}}">{{$bachiller_historico->ubiClave.' '.$bachiller_historico->ubiNombre}}</option>                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$bachiller_historico->departamento_id}}">{{$bachiller_historico->depClave.' '.$bachiller_historico->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id"
                            style="width: 100%;">
                            <option value="{{$bachiller_historico->escuela_id}}">{{$bachiller_historico->escClave.' '.$bachiller_historico->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo (Reingreso)*', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="{{$bachiller_historico->periodo_id}}" class="browser-default validate select2" required name="periodo_id"
                            style="width: 100%;">
                            @forelse ($periodos as $periodo)
                                <option value="{{$periodo->id}}" {{ $bachiller_historico->periodo_id == $periodo->id ? 'selected' : '' }}>{{$periodo->perNumero.'-'.$periodo->perAnio}}</option>
                            @empty
                                
                            @endforelse
                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                            'validate','readonly')) !!}                            
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                            'validate','readonly')) !!}                            
                        </div>
                    </div>
                </div>
                <div class="row">  
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required
                            name="programa_id" style="width: 100%;">
                            <option value="{{$bachiller_historico->programa_id}}">{{$bachiller_historico->progClave.' '.$bachiller_historico->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                            style="width: 100%;">
                            <option value="{{$bachiller_historico->plan_id}}">{{$bachiller_historico->planClave}}</option>
                        </select>
                    </div>                               
                   
                </div>
              

                <div class="row">   
                    <div class="col s12 m6 l4">
                        {!! Form::label('tipoOficio', 'Tipo oficio *', array('class' => '')); !!}
                        <select id="tipoOficio" data-tipoOficio-id="{{old('tipoOficio')}}" class="browser-default validate select2" required name="tipoOficio"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>                                                      
                            <option value="RV" {{ $bachiller_historico->histPeriodoAcreditacion == 'RV' ? 'selected' : '' }}>RV</option>
                            <option value="RC" {{ $bachiller_historico->histPeriodoAcreditacion == 'RC' ? 'selected' : '' }}>RC</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('fechaOficio', 'Fecha Oficio/Rec *', ['class' => '']); !!}                       
                        {!! Form::date('fechaOficio', $bachiller_historico->histFechaExamen, array('id' => 'fechaOficio', 'class' =>'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id_ficticio', 'Periodo (Revalidación)*', array('class' => '')); !!}
                        <select id="periodo_id_ficticio" data-periodo-id="{{$bachiller_historico->periodo_id_ficticio}}" class="browser-default validate select2" required name="periodo_id_ficticio"
                            style="width: 100%;">
                            @forelse ($periodos as $periodo)
                                <option value="{{$periodo->id}}" {{ $bachiller_historico->periodo_id_ficticio == $periodo->id ? 'selected' : '' }}>{{$periodo->perNumero.'-'.$periodo->perAnio}}</option>
                            @empty
                                
                            @endforelse
                            
                        </select>
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        {!! Form::label('opcion', 'Opción *', array('class' => '')); !!}
                        <select id="opcion" data-opcion-id="{{old('opcion')}}" class="browser-default validate select2" required name="opcion"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="A" {{ old('opcion') == 'A' ? 'selected' : '' }}>A - Solo 1er Curso</option>
                            <option value="B" {{ old('opcion') == 'B' ? 'selected' : '' }}>B - 1er y 2do Curso</option>
                            <option value="C" {{ old('opcion') == 'C' ? 'selected' : '' }}>C - Solo 2do Curso</option>
                        </select>
                    </div>                   --}}
                    
                </div>

                {{--  <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="numeroMateriasRev">Num. Mats Rev. o Rec</label>
                            <input type="number" name="numeroMateriasRev" id="numeroMateriasRev" min="0" max="100" maxlength="6">
                        </div>
                    </div>
                </div>  --}}

                
               


            </div>
            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                      ['onclick'=>'this.disabled=true;this.innerText="Guardando datos...";this.form.submit(); mostrarAlerta();','class' =>
                      'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
              </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


@endsection

@section('footer_scripts')

<script type="text/javascript">


    $("#periodo_id").change( event => {
      
        //${event.target.value}
        $.get(base_url+`/bachiller_revalidaciones/obtienePeriodo/${event.target.value}`,function(res,sta){
                
            $("#perFechaInicial").val(res.perFechaInicial);                    
            $("#perFechaFinal").val(res.perFechaFinal);                    


        });
    });

    let periodo_id = $("#periodo_id").val();
    $.get(base_url+`/bachiller_revalidaciones/obtienePeriodo/${periodo_id}`,function(res,sta){
                
        $("#perFechaInicial").val(res.perFechaInicial);                    
        $("#perFechaFinal").val(res.perFechaFinal);                    


    });

     
</script>


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


@endsection