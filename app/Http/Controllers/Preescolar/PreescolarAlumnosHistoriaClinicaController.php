<?php

namespace App\Http\Controllers\Preescolar;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Empleado;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Municipio;
use App\Models\Pago;
use App\Models\Pais;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_actividades;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_conducta;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_desarrollo;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_familiares;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_habitos;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_heredo;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_medica;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_nacimiento;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_sociales;
use App\Models\Ubicacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PreescolarAlumnosHistoriaClinicaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $preescolar_alumnos_historia_clinica = Preescolar_alumnos_historia_clinica::get();

        return view('preescolar.preescolar_alumnos_historia_clinica.index', [
            'preescolar_alumnos_historia_clinica' => $preescolar_alumnos_historia_clinica
        ]);
    }


    public function list()
    {
        if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1)) {
            $preescolar_alumnos_historia_clinica = Preescolar_alumnos_historia_clinica::select(
                'preescolar_alumnos_historia_clinica.id as historia_id',
                'alumnos.aluClave',
                'alumnos.id as alumno_id',
                'alumnos.aluMatricula',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perCurp'
            )
                ->join('alumnos', 'preescolar_alumnos_historia_clinica.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->latest('preescolar_alumnos_historia_clinica.created_at');
        }

        return Datatables::of($preescolar_alumnos_historia_clinica)
            ->filterColumn('perNombre', function ($query, $keyword) {
                return $query->whereHas('persona', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perNombre', function ($query) {
                return $query->perNombre;
            })
            ->filterColumn('perApellido1', function ($query, $keyword) {
                return $query->whereHas('persona', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido1', function ($query) {
                return $query->perApellido1;
            })
            ->filterColumn('perApellido2', function ($query, $keyword) {
                return $query->whereHas('persona', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido2', function ($query) {
                return $query->perApellido2;
            })


            ->addColumn('action', function ($query) {

                $btnMostrarAcciones = '';
                if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1)) {
                    $btnMostrarAcciones = '
                    <a href="/clinica/'.$query->historia_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>

                    <a href="/clinica/' . $query->historia_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                }

                return
                    $btnMostrarAcciones;
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alumnos = Alumno::select('alumnos.id', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2')
            ->join('personas', 'personas.id', '=', 'alumnos.id')
            ->get();

        $municipios = Municipio::all();

        return view('preescolar.preescolar_alumnos_historia_clinica.create', [
            'alumnos' => $alumnos,
            'municipios' => $municipios
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $preescolar_alumnos_historia_clinica = Preescolar_alumnos_historia_clinica::create([
            'alumno_id' => $request->alumno_id,
            'hisTipoSangre' => $request->hisTipoSangre,
            'hisAlergias' => $request->hisAlergias,
            'hisEscuelaProcedencia' => $request->hisEscuelaProcedencia,
            'hisUltimoGrado' => $request->hisUltimoGrado,
            'hisRecursado' => $request->hisRecursado,
            'hisRecursadoDetalle' => $request->hisRecursadoDetalle,
            'usuario_at' => auth()->user()->id
        ]);

        Preescolar_alumnos_historia_clinica_familiares::create([
            'historia_id' => $preescolar_alumnos_historia_clinica->id,
            'famNombresMadre' => $request->famNombresMadre,
            'famApellido1Madre' => $request->famApellido1Madre,
            'famApellido2Madre' => $request->famApellido2Madre,
            'famFechaNacimientoMadre' => $request->famFechaNacimientoMadre,
            'municipioMadre_id' => $request->municipioMadre_id,
            'famOcupacionMadre' => $request->famOcupacionMadre,
            'famEmpresaMadre' => $request->famEmpresaMadre,
            'famCelularMadre' => $request->famCelularMadre,
            'famTelefonoMadre' => $request->famTelefonoMadre,
            'famEmailMadre' => $request->famEmailMadre,
            'famRelacionMadre' => $request->famRelacionMadre,
            'famRelacionFrecuenciaMadre' => $request->famRelacionFrecuenciaMadre,
            'famNombresPadre' => $request->famNombresPadre,
            'famApellido1Padre' => $request->famApellido1Padre,
            'famApellido2Padre' => $request->famApellido2Padre,
            'famFechaNacimientoPadre' => $request->famFechaNacimientoPadre,
            'municipioPadre_id' => $request->municipioPadre_id,
            'famOcupacionPadre' => $request->famOcupacionPadre,
            'famEmpresaPadre' => $request->famEmpresaPadre,
            'famCelularPadre' => $request->famCelularPadre,
            'famTelefonoPadre' => $request->famTelefonoPadre,
            'famEmailPadre' => $request->famEmailPadre,
            'famRelacionPadre' => $request->famRelacionPadre,
            'famRelacionFrecuenciaPadre' => $request->famRelacionFrecuenciaPadre,
            'famEstadoCivilPadres' => $request->famEstadoCivilPadres,
            'famSeparado' => $request->famSeparado,
            'famReligion' => $request->famReligion,
            'famExtraNombre' => $request->famExtraNombre,
            'famTelefonoExtra' => $request->famTelefonoExtra,
            'famAutorizado1' => $request->famAutorizado1,
            'famAutorizado2' => $request->famAutorizado2,
            'famIntegrante1' => $request->famIntegrante1,
            'famParentesco1' => $request->famParentesco1,
            'famEdadIntegrante1' => $request->famEdadIntegrante1,
            'famEscuelaGrado1' => $request->famEscuelaGrado1,
            'famIntegrante2' => $request->famIntegrante2,
            'famParentesco2' => $request->famParentesco2,
            'famEdadIntegrante2' => $request->famEdadIntegrante2,
            'famEscuelaGrado2' => $request->famEscuelaGrado2,
            'famIntregrante3' => $request->famIntregrante3,
            'famParentesco3' => $request->famParentesco3,
            'famEdadIntregrante3' => $request->famEdadIntregrante3,
            'famEscuelaGrado3' => $request->famEscuelaGrado3,
        ]);

        return redirect()->route('clinica.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preescolar_alumnos_historia_clinica  $preescolar_alumnos_historia_clinica
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // obtiene los datos de la tabla Preescolar_alumnos_historia_clinica
        $historia = Preescolar_alumnos_historia_clinica::select('preescolar_alumnos_historia_clinica.id','preescolar_alumnos_historia_clinica.alumno_id',
        'preescolar_alumnos_historia_clinica.hisTipoSangre','preescolar_alumnos_historia_clinica.hisAlergias','preescolar_alumnos_historia_clinica.hisEscuelaProcedencia',
        'preescolar_alumnos_historia_clinica.hisUltimoGrado','preescolar_alumnos_historia_clinica.hisRecursado','preescolar_alumnos_historia_clinica.hisRecursadoDetalle',
        'preescolar_alumnos_historia_clinica.hisEdadActualMeses',
        'alumnos.persona_id','alumnos.aluClave','personas.perCurp', 'personas.perApellido1', 'personas.perApellido2', 'personas.perNombre',
        'personas.perFechaNac', 'municipios.id as municipio_id', 'municipios.munNombre', 'estados.edoNombre','paises.id as pais_id' ,'paises.paisNombre')
        ->join('alumnos', 'alumnos.id', '=', 'preescolar_alumnos_historia_clinica.alumno_id')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->join('municipios', 'municipios.id', '=', 'personas.municipio_id')
        ->join('estados', 'estados.id', '=', 'municipios.estado_id')
        ->join('paises', 'paises.id', '=', 'estados.pais_id')
        ->findOrFail($id);


        $paises = Pais::all();


        $familia = Preescolar_alumnos_historia_clinica_familiares::select()->where('historia_id', '=', $historia->id)->first();



        $embarazo = Preescolar_alumnos_historia_clinica_nacimiento::select()->where('historia_id', '=', $historia->id)->first();

        $medica = Preescolar_alumnos_historia_clinica_medica::select()->where('historia_id', '=', $historia->id)->first();

        $habitos = Preescolar_alumnos_historia_clinica_habitos::select()->where('historia_id', '=', $historia->id)->first();

        $desarrollo = Preescolar_alumnos_historia_clinica_desarrollo::select()->where('historia_id', '=', $historia->id)->first();

        $heredo = Preescolar_alumnos_historia_clinica_heredo::select()->where('historia_id', '=', $historia->id)->first();

        $social = Preescolar_alumnos_historia_clinica_sociales::select()->where('historia_id', '=', $historia->id)->first();

        $consucta = Preescolar_alumnos_historia_clinica_conducta::select()->where('historia_id', '=', $historia->id)->first();

        $actividad = Preescolar_alumnos_historia_clinica_actividades::select()->where('historia_id', '=', $historia->id)->first();

        $municipioMadre = Municipio::select('id', 'munNombre','estado_id')->where('id', '=', $familia->municipioMadre_id)->first();
        if ($municipioMadre)
        {
            $estadoMadre =  Estado::select('id', 'edoNombre', 'pais_id')->where('id', '=', $municipioMadre->estado_id)->first();
            $paisMadre = Pais::select('id', 'paisNombre')->where('id', '=', $estadoMadre->pais_id)->first();
        }

        $municipioPadre = Municipio::select('id', 'munNombre','estado_id')->where('id', '=', $familia->municipioPadre_id)->first();
        if($municipioPadre)
        {
            $estadoPadre =  Estado::select('id', 'edoNombre', 'pais_id')->where('id', '=', $municipioPadre->estado_id)->first();
            $paisPadre = Pais::select('id', 'paisNombre')->where('id', '=', $estadoPadre->pais_id)->first();
        }

        if(!$municipioMadre || !$municipioPadre)
        {
            alert()->warning('No existe información', 'Favor de capturar los datos de la historia clinica de este alumno(a).')->showConfirmButton();
            return back()->withInput();
        }

        return view('preescolar.preescolar_alumnos_historia_clinica.show', [
            'paises' => $paises,
            'historia' => $historia,
            'familia' => $familia,
            'municipioMadre' => $municipioMadre,
            'embarazo' => $embarazo,
            'medica' => $medica,
            'habitos' => $habitos,
            'desarrollo' => $desarrollo,
            'heredo' => $heredo,
            'social' => $social,
            'consucta' => $consucta,
            'actividad' => $actividad,
            'estadoMadre' => $estadoMadre,
            'paisMadre' => $paisMadre,
            'paisPadre' => $paisPadre,
            'estadoPadre' => $estadoPadre,
            'municipioPadre' => $municipioPadre
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preescolar_alumnos_historia_clinica  $preescolar_alumnos_historia_clinica
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumnos = Alumno::select('alumnos.id', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2')
            ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
            ->get();

        // obtiene los datos de la tabla Preescolar_alumnos_historia_clinica
        $historia = Preescolar_alumnos_historia_clinica::select('preescolar_alumnos_historia_clinica.id','preescolar_alumnos_historia_clinica.alumno_id',
        'preescolar_alumnos_historia_clinica.hisTipoSangre','preescolar_alumnos_historia_clinica.hisAlergias','preescolar_alumnos_historia_clinica.hisEscuelaProcedencia',
        'preescolar_alumnos_historia_clinica.hisUltimoGrado','preescolar_alumnos_historia_clinica.hisRecursado','preescolar_alumnos_historia_clinica.hisRecursadoDetalle',
        'preescolar_alumnos_historia_clinica.hisEdadActualMeses',
        'alumnos.persona_id','alumnos.aluClave','personas.perCurp', 'personas.perApellido1', 'personas.perApellido2', 'personas.perNombre',
        'personas.perFechaNac', 'municipios.id as municipio_id', 'municipios.munNombre', 'estados.edoNombre','paises.id as pais_id' ,'paises.paisNombre')
        ->join('alumnos', 'alumnos.id', '=', 'preescolar_alumnos_historia_clinica.alumno_id')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->join('municipios', 'municipios.id', '=', 'personas.municipio_id')
        ->join('estados', 'estados.id', '=', 'municipios.estado_id')
        ->join('paises', 'paises.id', '=', 'estados.pais_id')
        ->findOrFail($id);


        $paises = Pais::all();


        $familia = Preescolar_alumnos_historia_clinica_familiares::select()->where('historia_id', '=', $historia->id)->first();

        if($familia->municipioMadre_id == ""){
            $municipioMadre = 0;
        }else{
            $municipioMadre = $familia->municipioMadre_id;
        }

        if($familia->municipioPadre_id == ""){
            $municipioPadre = 0;
        }else{
            $municipioPadre = $familia->municipioPadre_id;
        }

        // estado de la madre 
        $estado_id_madre = Municipio::select('estados.id as estado_id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id')
        ->where('municipios.id', $municipioMadre)->first();

        // pais del madre 
        $pais_madre_id = Estado::select('paises.id as pais_id')
        ->join('paises', 'estados.pais_id', '=', 'paises.id')
        ->where('estados.id', $estado_id_madre->estado_id)->first();


        // estado de la padre 
        $estado_id_padre = Municipio::select('estados.id as estado_id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id')
        ->where('municipios.id', $municipioPadre)->first();

        // pais del padre 
        $pais_padre_id = Estado::select('paises.id as pais_id')
        ->join('paises', 'estados.pais_id', '=', 'paises.id')
        ->where('estados.id', $estado_id_padre->estado_id)->first();

        $embarazo = Preescolar_alumnos_historia_clinica_nacimiento::select()->where('historia_id', '=', $historia->id)->first();

        $medica = Preescolar_alumnos_historia_clinica_medica::select()->where('historia_id', '=', $historia->id)->first();

        $habitos = Preescolar_alumnos_historia_clinica_habitos::select()->where('historia_id', '=', $historia->id)->first();

        $desarrollo = Preescolar_alumnos_historia_clinica_desarrollo::select()->where('historia_id', '=', $historia->id)->first();

        $heredo = Preescolar_alumnos_historia_clinica_heredo::select()->where('historia_id', '=', $historia->id)->first();

        $social = Preescolar_alumnos_historia_clinica_sociales::select()->where('historia_id', '=', $historia->id)->first();

        $consucta = Preescolar_alumnos_historia_clinica_conducta::select()->where('historia_id', '=', $historia->id)->first();

        $actividad = Preescolar_alumnos_historia_clinica_actividades::select()->where('historia_id', '=', $historia->id)->first();


        // $municipioMadre = Municipio::select('id', 'munNombre','estado_id')->where('id', '=', $familia->municipioMadre_id)->first();
        // $estadoMadre =  Estado::select('id', 'edoNombre', 'pais_id')->where('id', '=', $municipioMadre->estado_id)->first();
        // $paisMadre = Pais::select('id', 'paisNombre')->where('id', '=', $estadoMadre->pais_id)->first();


        // $municipioPadre = Municipio::select('id', 'munNombre','estado_id')->where('id', '=', $familia->municipioPadre_id)->first();
        // $estadoPadre =  Estado::select('id', 'edoNombre', 'pais_id')->where('id', '=', $municipioPadre->estado_id)->first();
        // $paisPadre = Pais::select('id', 'paisNombre')->where('id', '=', $estadoPadre->pais_id)->first();

        $municipios = Municipio::get();
        $estados = Estado::get();

        return view('preescolar.preescolar_alumnos_historia_clinica.edit', [
            'alumnos' => $alumnos,
            'paises' => $paises,
            'historia' => $historia,
            'familia' => $familia,
            'embarazo' => $embarazo,
            'medica' => $medica,
            'habitos' => $habitos,
            'desarrollo' => $desarrollo,
            'heredo' => $heredo,
            'social' => $social,
            'consucta' => $consucta,
            'actividad' => $actividad,
            'estado_id_madre' => $estado_id_madre,
            'pais_madre_id' => $pais_madre_id,
            'estado_id_padre' => $estado_id_padre,
            'pais_padre_id' => $pais_padre_id,
            'municipios' => $municipios,
            'estados' => $estados
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preescolar_alumnos_historia_clinica  $preescolar_alumnos_historia_clinica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preescolar_alumnos_historia_clinica $id)
    {

        $id->update([
            'hisEdadActualMeses' => $request->hisEdadActualMeses,
            'hisTipoSangre' => $request->hisTipoSangre,
            'hisAlergias' => $request->hisAlergias,
            'hisEscuelaProcedencia' => $request->hisEscuelaProcedencia,
            'hisUltimoGrado' => $request->hisUltimoGrado,
            'hisRecursado' => $request->hisRecursado,
            'hisRecursadoDetalle' => $request->hisRecursadoDetalle

        ]);

        $familia = Preescolar_alumnos_historia_clinica_familiares::select()->where('historia_id', '=', $id->id)->first();

        // cambiar de valor si no se seleccionada nada en en formulario 
        if($request->municipioMadre_id == ""){
            $municipioMadre_id = 0;
        }else{
            $municipioMadre_id = $request->municipioMadre_id;
        }

        if($request->municipioPadre_id == ""){
            $municipioPadre_id = 0;
        }else{
            $municipioPadre_id = $request->municipioPadre_id;
        }


        $familia->update([
            'historia_id' => $familia->historia_id,
            'famNombresMadre' => $request->famNombresMadre,
            'famApellido1Madre' => $request->famApellido1Madre,
            'famApellido2Madre' => $request->famApellido2Madre,
            'famFechaNacimientoMadre' => $request->famFechaNacimientoMadre,
            'municipioMadre_id' => $municipioMadre_id,
            'famOcupacionMadre' => $request->famOcupacionMadre,
            'famEmpresaMadre' => $request->famEmpresaMadre,
            'famCelularMadre' => $request->famCelularMadre,
            'famTelefonoMadre' => $request->famTelefonoMadre,
            'famEmailMadre' => $request->famEmailMadre,
            'famRelacionMadre' => $request->famRelacionMadre,
            'famRelacionFrecuenciaMadre' => $request->famRelacionFrecuenciaMadre,
            'famNombresPadre' => $request->famNombresPadre,
            'famApellido1Padre' => $request->famApellido1Padre,
            'famApellido2Padre' => $request->famApellido2Padre,
            'famFechaNacimientoPadre' => $request->famFechaNacimientoPadre,
            'municipioPadre_id' => $municipioPadre_id,
            'famOcupacionPadre' => $request->famOcupacionPadre,
            'famEmpresaPadre' => $request->famEmpresaPadre,
            'famCelularPadre' => $request->famCelularPadre,
            'famTelefonoPadre' => $request->famTelefonoPadre,
            'famEmailPadre' => $request->famEmailPadre,
            'famRelacionPadre' => $request->famRelacionPadre,
            'famRelacionFrecuenciaPadre' => $request->famRelacionFrecuenciaPadre,
            'famEstadoCivilPadres' => $request->famEstadoCivilPadres,
            'famSeparado' => $request->famSeparado,
            'famReligion' => $request->famReligion,
            'famExtraNombre' => $request->famExtraNombre,
            'famTelefonoExtra' => $request->famTelefonoExtra,
            'famAutorizado1' => $request->famAutorizado1,
            'famAutorizado2' => $request->famAutorizado2,
            'famIntegrante1' => $request->famIntegrante1,
            'famParentesco1' => $request->famParentesco1,
            'famEdadIntegrante1' => $request->famEdadIntegrante1,
            'famEscuelaGrado1' => $request->famEscuelaGrado1,
            'famIntegrante2' => $request->famIntegrante2,
            'famParentesco2' => $request->famParentesco2,
            'famEdadIntegrante2' => $request->famEdadIntegrante2,
            'famEscuelaGrado2' => $request->famEscuelaGrado2,
            'famIntregrante3' => $request->famIntregrante3,
            'famParentesco3' => $request->famParentesco3,
            'famEdadIntregrante3' => $request->famEdadIntregrante3,
            'famEscuelaGrado3' => $request->famEscuelaGrado3,
        ]);

        $embarazo = Preescolar_alumnos_historia_clinica_nacimiento::select()->where('historia_id', '=', $id->id)->first();

        $embarazo->update([
            'historia_id' => $embarazo->historia_id,
            'nacNumEmbarazo' => $request->nacNumEmbarazo,
            'nacEmbarazoPlaneado' => $request->nacEmbarazoPlaneado,
            'nacEmbarazoTermino' => $request->nacEmbarazoTermino,
            'nacEmbarazoDuracion' => $request->nacEmbarazoDuracion,
            'NacParto' => $request->NacParto,
            'nacPeso' => $request->nacPeso,
            'nacMedia' => $request->nacMedia,
            'nacApgar' => $request->nacApgar,
            'nacComplicacionesEmbarazo' => $request->nacComplicacionesEmbarazo,
            'nacCualesEmbarazo' => $request->nacCualesEmbarazo,
            'nacComplicacionesParto' => $request->nacComplicacionesParto,
            'nacCualesParto' => $request->nacCualesParto,
            'nacComplicacionDespues' => $request->nacComplicacionDespues,
            'nacCualesDespues' => $request->nacCualesDespues,
            'nacLactancia' => $request->nacLactancia,
            'nacActualmente' => $request->nacActualmente
        ]);

        $medica = Preescolar_alumnos_historia_clinica_medica::select()->where('historia_id', '=', $id->id)->first();

        $medica->update([
            'historia_id' => $medica->historia_id,
            'medIntervencionQuirurgicas' => $request->medIntervencionQuirurgicas,
            'medMedicamentos' => $request->medMedicamentos,
            'medConvulsiones' => $request->medConvulsiones,
            'medAudicion' => $request->medAudicion,
            'medFiebres' => $request->medFiebres,
            'medProblemasCorazon' => $request->medProblemasCorazon,
            'medDeficiencia' => $request->medDeficiencia,
            'medAsma' => $request->medAsma,
            'medDiabetes' => $request->medDiabetes,
            'medGastrointestinales' => $request->medGastrointestinales,
            'medAccidentes' => $request->medAccidentes,
            'medEpilepsia' => $request->medEpilepsia,
            'medRinion' => $request->medRinion,
            'medPiel' => $request->medPiel,
            'medCoordinacionMotriz' => $request->medCoordinacionMotriz,
            'medEstrenimiento' => $request->medEstrenimiento,
            'medDificultadesSuenio' => $request->medDificultadesSuenio,
            'medAlergias' => $request->medAlergias,
            'medEspesificar' => $request->medEspesificar,
            'medOtro' => $request->medOtro,
            'medGastoMedico' => $request->medGastoMedico,
            'medNombreAsegurador' => $request->medNombreAsegurador,
            'medVacunas' => $request->medVacunas,
            'medTramiento' => $request->medTramiento,
            'medTerapia' => $request->medTerapia,
            'medMotivoTerapia' => $request->medMotivoTerapia,
            'medSaludFisicaAct' => $request->medSaludFisicaAct,
            'medSaludEmocialAct' => $request->medSaludEmocialAct
        ]);

        $habito = Preescolar_alumnos_historia_clinica_habitos::select()->where('historia_id', '=', $id->id)->first();

        $habito->update([
            'historia_id' => $habito->historia_id,
            'habBanio' => $request->habBanio,
            'habVestimenta' => $request->habVestimenta,
            'habLuz' => $request->habLuz,
            'habZapatos' => $request->habZapatos,
            'habCome' => $request->habCome,
            'habHoraDormir' => $request->habHoraDormir,
            'habHoraDespertar' => $request->habHoraDespertar,
            'habEstadoLevantar' => $request->habEstadoLevantar,
            'habRecipiente' => $request->habRecipiente
        ]);

        $desarrollo = Preescolar_alumnos_historia_clinica_desarrollo::select()->where('historia_id', '=', $id->id)->first();

        $desarrollo->update([
            'historia_id' => $desarrollo->historia_id,
            'desMotricesGruesas' => $request->desMotricesGruesas,
            'desMotricesGruCual' => $request->desMotricesGruCual,
            'desMotricesFinas' => $request->desMotricesFinas,
            'desMotricesFinCual' => $request->desMotricesFinCual,
            'desHiperactividad' => $request->desHiperactividad,
            'desHiperactividadCual' => $request->desHiperactividadCual,
            'desSocializacion' => $request->desSocializacion,
            'desSocializacionCual' => $request->desSocializacionCual,
            'desLenguaje' => $request->desLenguaje,
            'desLenguajeCual' => $request->desLenguajeCual,
            'desPrimPalabra' => $request->desPrimPalabra,
            'desEdadNombre' => $request->desEdadNombre,
            'desLateralidad' => $request->desLateralidad
        ]);

        $heredo = Preescolar_alumnos_historia_clinica_heredo::select()->where('historia_id', '=', $id->id)->first();

        $heredo->update([
            'historia_id' => $heredo->historia_id,
            'herEpilepsia' => $request->herEpilepsia,
            'herEpilepsiaGrado' => $request->herEpilepsiaGrado,
            'herDiabetes' => $request->herDiabetes,
            'herDiabetesGrado' => $request->herDiabetesGrado,
            'herHipertension' => $request->herHipertension,
            'herHipertensionGrado' => $request->herHipertensionGrado,
            'herCancer' => $request->herCancer,
            'herCancerGrado' => $request->herCancerGrado,
            'herNeurologicos' => $request->herNeurologicos,
            'herNeurologicosGrado' => $request->herNeurologicosGrado,
            'herPsicologicos' => $request->herPsicologicos,
            'herPsicologicosGrado' => $request->herPsicologicosGrado,
            'herLenguaje' => $request->herLenguaje,
            'herLenguajeGrado' => $request->herLenguajeGrado,
            'herAdicciones' => $request->herAdicciones,
            'herAdiccionesGrado' => $request->herAdiccionesGrado,
            'herOtro' => $request->herOtro,
            'herOtroGrado' => $request->herOtroGrado
        ]);

        $social = Preescolar_alumnos_historia_clinica_sociales::select()->where('historia_id', '=', $id->id)->first();

        $social->update([
            'historia_id' => $social->historia_id,
            'socAmigos' => $request->socAmigos,
            'socActitud' => $request->socActitud,
            'socNinioEdad' => $request->socNinioEdad,
            'socNinioRazon' => $request->socNinioRazon,
            'socActividadExtraescolar' => $request->socActividadExtraescolar,
            'socActividadRazon' => $request->socActividadRazon,
            'socSeparacion' => $request->socSeparacion,
            'socSeparacionRazon' => $request->socSeparacionRazon,
            'socRelacionFamilia' => $request->socRelacionFamilia
        ]);

        $conducta = Preescolar_alumnos_historia_clinica_conducta::select()->where('historia_id', '=', $id->id)->first();

        $conducta->update([
            'historia_id' => $conducta->historia_id,
            'conAfectivoNervioso' => $request->conAfectivoNervioso,
            'conAfectivoAgresivo' => $request->conAfectivoAgresivo,
            'conAfectivoDestraido' => $request->conAfectivoDestraido,
            'conAfectivoTimido' => $request->conAfectivoTimido,
            'conAfectivoSensible' => $request->conAfectivoSensible,
            'conAfectivoAmistoso' => $request->conAfectivoAmistoso,
            'conAfectivoAmable' => $request->conAfectivoAmable,
            'conAfectivoOtro' => $request->conAfectivoOtro,
            'conVerbalRenuente' => $request->conVerbalRenuente,
            'conVerbalTartamudez' => $request->conVerbalTartamudez,
            'conVerbalVerbalizacion' => $request->conVerbalVerbalizacion,
            'conVerbalExplicito' => $request->conVerbalExplicito,
            'conVerbalSilencioso' => $request->conVerbalSilencioso,
            'conVerbalRepetivo' => $request->conVerbalRepetivo,
            'conConductual' => $request->conConductual,
            'conBerrinches' => $request->conBerrinches,
            'conAgresividad' => $request->conAgresividad,
            'conMasturbacion' => $request->conMasturbacion,
            'conMentiras' => $request->conMentiras,
            'conRobo' => $request->conRobo,
            'conPesadillas' => $request->conPesadillas,
            'conEnuresis' => $request->conEnuresis,
            'conEncopresis' => $request->conEncopresis,
            'conExcesoAlimentacion' => $request->conExcesoAlimentacion,
            'conRechazoAlimentario' => $request->conRechazoAlimentario,
            'conLlanto' => $request->conLlanto,
            'conTricotilomania' => $request->conTricotilomania,
            'conOnicofagia' => $request->conOnicofagia,
            'conMorderUnias' => $request->conMorderUnias,
            'conSuccionPulgar' => $request->conSuccionPulgar,
            'conExplicaciones' => $request->conExplicaciones,
            'conPrivaciones' => $request->conPrivaciones,
            'conCorporal' => $request->conCorporal,
            'conAmenazas' => $request->conAmenazas,
            'conTiempoFuera' => $request->conTiempoFuera,
            'conOtros' => $request->conOtros,
            'conAplica' => $request->conAplica,
            'conRecompensa' => $request->conRecompensa
        ]);

        $actividad = Preescolar_alumnos_historia_clinica_actividades::select()->where('historia_id', '=', $id->id)->first();

        $actividad->update([
            'historia_id' => $actividad->historia_id,
            'actJuguete' => $request->actJuguete,
            'actCuento' => $request->actCuento,
            'actPelicula' => $request->actPelicula,
            'actHorasTelevision' => $request->actHorasTelevision,
            'actTenologia' => $request->actTenologia,
            'actTipoJuguetes' => $request->actTipoJuguetes,
            'actApoyoTarea' => $request->actApoyoTarea,
            'actCuidado' => $request->actCuidado,
            'actObservacionExtra' => $request->actObservacionExtra,
            'actGradoSugerido' => $request->actGradoSugerido,
            'actGradoElegido' => $request->actGradoElegido,
            'actNombreEntrevista' => $request->actNombreEntrevista
        ]);

        alert('Escuela Modelo', 'El historial clinico se ha actualizo con éxito','success')->autoClose('3000');
        // return redirect()->route('clinica.index');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preescolar_alumnos_historia_clinica  $preescolar_alumnos_historia_clinica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preescolar_alumnos_historia_clinica $preescolar_alumnos_historia_clinica)
    {
        //
    }
}
