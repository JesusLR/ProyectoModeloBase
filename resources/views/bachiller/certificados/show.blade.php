@extends('layouts.dashboard')

@section('template_title')
    Bachiller pago certificado
@endsection

@section('breadcrumbs')
    <a href="{{ url('bachiller_curso') }}" class="breadcrumb">Inicio</a>
    <a href="{{ route('bachiller.bachiller_pago_certificado.index') }}" class="breadcrumb">Lista de certificados pagados</a>
    <a href="" class="breadcrumb">Editar Pago certificado</a>
@endsection

@section('content')
    <div class="row">
        <div class="col s12 ">
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">PAGO DE CERTIFICADO</span>

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
                                {!! Form::label('curEstado', 'Ubicación', ['class' => '']) !!}
                                <input type="text" readonly
                                    value="{{ $bachiller_pago_certificado->ubiClave . '-' . $bachiller_pago_certificado->ubiNombre }}">
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="departamento_id">Departamento</label>
                                <input type="text"
                                    value="{{ $bachiller_pago_certificado->depClave . '-' . $bachiller_pago_certificado->depNombre }}"
                                    readonly>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="escuela_id">Escuela </label>
                                <input type="text" name=""
                                    value="{{ $bachiller_pago_certificado->escClave . '-' . $bachiller_pago_certificado->escNombre }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="periodo_id">Período </label>
                                <input type="text" readonly
                                    value="{{ $bachiller_pago_certificado->perNumero . '-' . $bachiller_pago_certificado->perAnio }}"
                                    name="" id="">
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="programa_id">Programa </label>
                                <input type="text" readonly
                                    value="{{ $bachiller_pago_certificado->progClave . '-' . $bachiller_pago_certificado->progNombre }}"
                                    name="" id="">
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="plan_id">Plan </label>
                                <input type="text" readonly value="{{ $bachiller_pago_certificado->planClave }}"
                                    name="" id="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="curso_id">Alumno </label>
                                <input type="text" readonly
                                    value="{{ $bachiller_pago_certificado->perApellido1 . ' ' . $bachiller_pago_certificado->perApellido2 . ' ' . $bachiller_pago_certificado->perNombre }}"
                                    name="" id="">
                            </div>


                            <div class="col s12 m6 l4">
                                <div class="col s12 m6 l6">
                                    <div style="position:relative;">
                                        <label for="concepto_pago">Concepto Pago </label>
                                        <input type="text" readonly value="CERTIFICADO" name="" id="">
                                    </div>
                                </div>
                                <div class="col s12 m6 l6">
                                    <div style="position:relative;">
                                        <label for="monto_pago">Monto Pago </label>
                                        <input type="text" readonly value="250" name="" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m6 l4">
                                <label for="fecha_pago">Fecha Pago </label>
                                <input type="date" name="fecha_pago" id="fecha_pago"
                                    value="{{ $bachiller_pago_certificado->fecha_pago }}" readonly>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('footer_scripts')
    @endsection
