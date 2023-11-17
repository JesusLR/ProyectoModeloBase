@if ((Auth::user()->preescolar == 1)  || (Auth::user()->maternal == 1))
{{-- @if (Auth::user()->empleado->escuela->departamento->depClave == "PRE") --}}

    @php
        $userDepClave = Auth::user()->empleado->escuela->departamento->depClave;
        $userClave = Auth::user()->username;
    @endphp

    @if (Auth::user()->maternal == 1)
        @php
          $userDepClave = "MAT";
        @endphp
    @endif
    @if (Auth::user()->preescolar == 1)
        @php
          $userDepClave = "PRE";
        @endphp
    @endif



    @if(  Auth::user()->departamento_sistemas == 1 )

            <optgroup label="MAT-PRE Catálogos">
                {{--  programas   --}}
                <option value="{{ route('preescolar.preescolar_programa.index') }}" {{ url()->current() ==  route('preescolar.preescolar_programa.index') ? "selected": "" }}>Programas</option>
                {{--  planes   --}}
                <option value="{{ route('preescolar.preescolar_plan.index') }}" {{ url()->current() ==  route('preescolar.preescolar_plan.index') ? "selected": "" }}>Planes</option>
                {{--  periodos   --}}
                <option value="{{ route('preescolar.preescolar_periodo.index') }}" {{ url()->current() ==  route('preescolar.preescolar_periodo.index') ? "selected": "" }}>Períodos</option>
                {{--  materias   --}}
                <option value="{{ route('preescolar.preescolar_materia.index') }}" {{ url()->current() ==  route('preescolar.preescolar_materia.index') ? "selected": "" }}>Materias</option>
                {{--  cgts   --}}
                <option value="{{ route('preescolar.preescolar_cgt.index') }}" {{ url()->current() ==  route('preescolar.preescolar_cgt.index') ? "selected": "" }}>CGT</option>
                {{--  Tipo rubricas   --}}
                <option value="{{ route('preescolar.preescolar_tipo_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_tipo_rubricas.index') ? "selected": "" }}>Tipo de rubricas</option>
                {{--  Rubricas   --}}
                <option value="{{ route('preescolar.preescolar_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_rubricas.index') ? "selected": "" }}>Rubricas</option>

                <option value="{{ route('preescolar.preescolar_fecha_de_calificaciones.index') }}" {{ url()->current() ==  route('preescolar.preescolar_fecha_de_calificaciones.index') ? "selected": "" }}>Fechas de calificaciones</option>

            </optgroup>

            <optgroup label="MAT-PRE C.Escolar">
                {{--  Empleados   --}}
                <option value="{{ route('preescolar_empleado.index') }}" {{ url()->current() ==  route('preescolar_empleado.index') ? "selected": "" }}>Empleados</option>
                {{--  Alumnos   --}}
                <option value="{{ route('preescolar_alumnos.index') }}" {{ url()->current() ==  route('preescolar_alumnos.index') ? "selected": "" }}>Alumnos</option>

                {{--  Preinscritos   --}}
                <option value="{{ route('curso_preescolar.index') }}" {{ url()->current() ==  route('curso_preescolar.index') ? "selected": "" }}>Preinscritos</option>

                {{--  Historia clinica   --}}
                <option value="{{ url('clinica') }}" {{ url()->current() ==  url('clinica') ? "selected": "" }}>Historia clinica</option>
                {{--  Asignar CGT   --}}
                <option value="{{ route('preescolar.preescolar_asignar_cgt.index') }}" {{ url()->current() ==  route('preescolar.preescolar_asignar_cgt.index') ? "selected": "" }}>Asignar CGT</option>
                {{--  Cambiar CGT   --}}
                <option value="{{ route('preescolar.preescolar_cambiar_cgt.edit') }}" {{ url()->current() ==  route('preescolar.preescolar_cambiar_cgt.edit') ? "selected": "" }}>Cambiar CGT</option>

                <option value="{{ route('preescolar.preescolar_cgt_materias.index') }}" {{ url()->current() ==  route('preescolar.preescolar_cgt_materias.index') ? "selected": "" }}>CGT Materias</option>
                {{--  Grupos   --}}
                <option value="{{ route('preescolar_grupo.index') }}" {{ url()->current() ==  route('preescolar_grupo.index') ? "selected": "" }}>Grupos</option>

                <option value="{{ route('preescolar.preescolar_grupo_rubricas.index') }}" {{ url()->current() ==  route('preescolar.preescolar_grupo_rubricas.index') ? "selected": "" }}>Grupos rubricas</option>


                {{--  Inscritos materia   --}}
                <option value="{{ route('PreescolarInscritos.index') }}" {{ url()->current() ==  route('PreescolarInscritos.index') ? "selected": "" }}>Inscritos materia</option>

                <option value="{{ route('preescolar.preescolar_modificar_plantilla_calificaciones.index') }}" {{ url()->current() ==  route('preescolar.preescolar_modificar_plantilla_calificaciones.index') ? "selected": "" }}>Cambiar plantilla (calificaciones)</option> 
                {{--  Calendario   --}}
                <option value="{{ url('calendario') }}" {{ url()->current() ==  url('calendario') ? "selected": "" }}>Calendario</option>

            </optgroup>

            <optgroup label="MAT-PRE Act. ExtraEscolares">

                <option value="{{ route('universidad.universidad_actividades.index') }}"
                    {{ url()->current() ==  route('universidad.universidad_actividades.index') ? "selected": "" }}>Actividades (Grupos)</option>

                <option value="{{ route('universidad.universidad_nuevo_externo.create') }}"
                    {{ url()->current() ==  route('universidad.universidad_nuevo_externo.create') ? "selected": "" }}>Nuevo Externo</option>

                <option value="{{ route('universidad.universidad_actividades_inscritos.index') }}"
                {{ url()->current() ==  route('universidad.universidad_actividades_inscritos.index') ? "selected": "" }}>Inscritos Actividades</option>
    
                       
            </optgroup>

            <optgroup label="MAT-PRE Pagos">
                {{--  Ficha general   --}}
                <option value="{{ url('pagos/ficha_general') }}" {{ url()->current() ==  url('pagos/ficha_general') ? "selected": "" }}>Ficha general</option>

                <option value="{{ url('preescolar/pagos/aplicar_pagos') }}" {{ url()->current() ==  url('preescolar/pagos/aplicar_pagos') ? "selected": "" }}>Pagos Manuales</option>
            </optgroup>

            <optgroup label="MAT-PRE Reportes">
                {{--  Catálogos   --}}
                <optgroup label="&nbsp;Catálogos">
                    <option value="{{ route('reporte.preescolar_rubricas.reporte') }}"
                        {{ url()->current() ==  route('reporte.preescolar_rubricas.reporte') ? "selected": "" }}>Rúbricas</option>
                </optgroup>
                {{-- Alumnos --}}
                <optgroup label="&nbsp;Alumnos PRE">
                    <option value="{{ route('preescolar_inscrito_preinscrito.create') }}"
                        {{ url()->current() ==  route('preescolar_inscrito_preinscrito.create') ? "selected": "" }}>Inscritos y preinscritos</option>

                    {{--  Resumen inscritos   --}}
                    <option value="{{ url('reporte/preescolar_resumen_inscritos') }}"
                        {{ url()->current() ==  url('reporte/preescolar_resumen_inscritos') ? "selected": "" }}>Resumen inscritos PRE</option>

                    {{--  Reporte de alumnos becados   --}}
                    <option value="{{ route('preescolar_reporte.preescolar_alumnos_becados.reporte') }}"
                        {{ url()->current() ==  route('preescolar_reporte.preescolar_alumnos_becados.reporte') ? "selected": "" }}>Rel. alumnos becados</option>
                
                    <option value="{{ route('preescolar.datos_completos_alumno.reporteAlumnos') }}" {{ url()->current() ==  route('preescolar.datos_completos_alumno.reporteAlumnos') ? "selected": "" }}>Datos Completos de Alumnos</option>

                    <option value="{{ route('preescolar.preescolar_inscritos_sexo.reporte') }}"
                    {{ url()->current() ==  route('preescolar.preescolar_inscritos_sexo.reporte') ? "selected": "" }}>Resumen inscritos sexo MAT-PRE</option>

                
                </optgroup>

                {{-- Pagos --}}
                <optgroup label="&nbsp;Pagos">
                    <option value="{{ url('reporte/preescolar_relacion_deudas') }}"
                        {{ url()->current() ==  url('reporte/preescolar_relacion_deudas') ? "selected": "" }}>Deudas de un Alumno</option>

                    {{--  Resumen inscritos   --}}
                    <option value="{{ url('reporte/preescolar_relacion_deudores') }}"
                        {{ url()->current() ==  url('reporte/preescolar_relacion_deudores') ? "selected": "" }}>Relación de Deudores</option>

                </optgroup>

            </optgroup>



    @endif

@endif
