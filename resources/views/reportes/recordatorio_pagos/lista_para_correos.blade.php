@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Recordatorio de pagos</a>
@endsection

@section('content')

<div class="row">
  <div class="col s12 ">
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Recordatorio de Pago</span>
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
              <div class="col s12 m12 l8">
                <table id="tabla_deudores" class="responsive-table striped">
                  <thead>
                    <tr>
                      <td>Clave de pago</td>
                      <td>Nombre</td>
                      <td>Carrera</td>
                      <td>Grado</td>
                      <td>Beca</td>
                      <td>Enviar correo</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($cursos as $curso)
                      <tr>
                        <td>{{$curso['aluClave']}}</td>
                        <td>{{$curso['nombreCompleto']}}</td>
                        <td>{{$curso['programa']}}</td>
                        <td>{{$curso['grado']}} {{$curso['grupo']}}</td>
                        <td>{{$curso['beca']}}</td>
                        <td>
                          <a id="curso_{{$curso['curso_id']}}" data-curso-id="{{$curso['curso_id']}}" href="#" class="btn waves-effect btn_mail" title="Enviar Mail">
                              <i class="material-icons">email</i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
        </div>
      </div>
  </div>
</div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection


@section('footer_scripts')

<script type="text/javascript">
    $(document).ready(function() {
      const cursos = {!! json_encode($cursos) !!};
      const departamento = {!! json_encode($departamento) !!};
      const ubicacion = {!! json_encode($ubicacion) !!};
      const ultimaFecha = {!! json_encode($ultimaFecha) !!};
      const mensaje = {!! json_encode($mensaje) !!};
      const mensaje_agregado = {!! json_encode($mensaje_agregado) !!};

      $('.btn_mail').on('click', function(e) {
        e.preventDefault();
        let curso_id = $(this).data('curso-id');
        let curso = curso_id ? cursos_donde_id(cursos, $(this).data('curso-id')).shift() : {};
        $('.btn_mail').attr('disabled', 'disabled');
        if(!$.isEmptyObject(curso)) {
          enviar_correo(curso, departamento, ubicacion, ultimaFecha, mensaje, mensaje_agregado);
        } else {
          $('.btn_mail').removeAttr('disabled');
        }
      });

    });


    function cursos_donde_id(cursos, curso_id) {
      return Object.values(cursos).filter(curso => curso.curso_id == curso_id);
    }

    function enviar_correo(curso, departamento, ubicacion, ultimaFecha, mensaje, mensaje_agregado) {
      $.ajax({
        type: 'POST',
        url: `${base_url}/reporte/recordatorio_pagos/enviar_correo/${curso['id']}`,
        dataType: 'json',
        data: {
          'curso': curso,
          'departamento': departamento,
          'ubicacion': ubicacion,
          'ultimaFecha': ultimaFecha,
          'mensaje': mensaje,
          'mensaje_agregado': mensaje_agregado,
          '_token': "{!! csrf_token() !!}"
        },
        success: function(data) {
          swal({
            type: data.status,
            title: data.title,
            text: data.msg,
          });
          $('.btn_mail').removeAttr('disabled');
        },
        error: function(Xhr, textMessage, errorMessage) {
          // console.log(errorMessage, Xhr); # TEST
          swal({
            type: 'error',
            title: 'Ha ocurrido un error',
            text: errorMessage,
          });
          $('.btn_mail').removeAttr('disabled');
        }
      });
    }
</script>

@endsection