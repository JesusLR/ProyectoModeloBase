<?php

namespace App\Http\Controllers\Preescolar;

use App\clases\departamentos\MetodosDepartamentos;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Periodo;
use App\Models\Preescolar\Preescolar_calificacion;
use App\Models\Preescolar\Preescolar_rubricas;
use App\Models\Preescolar\Preescolar_rubricas_tipo;
use App\Models\Programa;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;
use Validator;

class PreescolarRubricasController extends Controller
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
        return view('preescolar.rubricas.show-list');
    }

    public function list()
    {
        $rubricas = Preescolar_rubricas::select(
            'preescolar_rubricas.id',
            'preescolar_rubricas.grado',
            'preescolar_rubricas.trimestre1',
            'preescolar_rubricas.trimestre2',
            'preescolar_rubricas.trimestre3',
            'preescolar_rubricas.rubrica',
            'preescolar_rubricas.aplica',
            'preescolar_rubricas_tipo.tipo',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnioPago')
        ->join('preescolar_rubricas_tipo', 'preescolar_rubricas.preescolar_rubricas_tipo_id', '=', 'preescolar_rubricas_tipo.id')
        ->join('programas', 'preescolar_rubricas.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('periodos', 'preescolar_rubricas.periodo_id', '=', 'periodos.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT']);

        return DataTables::of($rubricas)
        
        ->filterColumn('ubicacion', function($query, $keyword) {
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion', function($query) {
            return $query->ubiNombre;
        })

        ->filterColumn('year', function($query, $keyword) {
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('year', function($query) {
            return $query->perAnioPago;
        })

        ->filterColumn('programa', function($query, $keyword) {
            $query->whereRaw("CONCAT(progClave, ' ', progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('programa', function($query) {
            return $query->progClave."-".$query->progNombre;
        })
       
        ->addColumn('action',function($query){
            return '<a href="preescolar_rubricas/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="preescolar_rubricas/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>

           ';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $departamento = Departamento::select()->whereIn('depClave', ['PRE'])->get();

        // $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::get();
       

        return view('preescolar.rubricas.create', [
            // 'preescolar_rubricas_tipo' => $preescolar_rubricas_tipo,
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);
    }

    public function getRubricasPre(Request $request, $programa_id, $grado)
    {
        if($request->ajax()){
            // si es ajax es para el combobox entonces sea json y ordenado
            return response()->json( Preescolar_rubricas::where('programa_id', $programa_id)->where('grado', $grado)->orderBy('orden_impresion', 'DESC')->get() );
        } else {
            // no enviamos un json
            return Preescolar_rubricas::where('programa_id', $programa_id)->where('grado', $grado)->get();
        }
    }

    public function getRubrica(Request $request, $programa_id)
    {
        if($request->ajax()){
            $tipo_rubricas = Preescolar_rubricas_tipo::where('programa_id', $programa_id)->get();

            return response()->json($tipo_rubricas);
        }
    }

    public function getDepartamentosPre(Request $request, $id)
    {
        if($request->ajax()){
            if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1)) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRE', 'MAT']);
            }

            return response()->json($departamentos);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'preescolar_rubricas_tipo_id'   => 'required',
            'grado'           => 'required',
            'rubrica'   => 'required',
            'aplica'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect ('preescolar_rubricas/create')->withErrors($validator)->withInput();
        }

        // varibles que vienen del \request

        $periodo_id = $request->periodo_id;
        $programa_id = $request->programa_id;
        $preescolar_rubricas_tipo_id = $request->preescolar_rubricas_tipo_id;
        $grado = $request->grado;
        $trimestre1 = $request->trimestre1;
        $trimestre2 = $request->trimestre2;
        $trimestre3 = $request->trimestre3;
        $rubrica = $request->rubrica;
        $aplica = $request->aplica;

        // obtener el nombre tipo 
        $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::findOrFail($preescolar_rubricas_tipo_id);
        $tipo = $preescolar_rubricas_tipo->tipo;

        $orden_impresion = $request->orden_impresion ? $request->orden_impresion + 1 : 1;

        try {
            // buscar el rango de impresión e incrementar en 1
            if ( !is_null($request->orden_impresion) ) {
                $last = Preescolar_rubricas::where('programa_id', $programa_id)
                            ->where('grado', $grado)
                            ->orderBy('orden_impresion', 'DESC')
                            ->first();

                if ($request->orden_impresion < $last->orden_impresion) {
                    $init = $request->orden_impresion == 0 ? 0 : $request->orden_impresion+1;
                    Preescolar_rubricas::where('programa_id', $programa_id)
                        ->where('grado', $grado)
                        ->whereBetween('orden_impresion', [$init, $last->orden_impresion])
                        ->orderBy('orden_impresion', 'ASC')
                        ->increment('orden_impresion');
                }
            }

            $rubicas = Preescolar_rubricas::create([
                'periodo_id'                    => $periodo_id,
                'programa_id'                   =>$programa_id,
                'preescolar_rubricas_tipo_id'   =>$preescolar_rubricas_tipo_id,
                'tipo'                          => $tipo,
                'grado'                         => $grado,
                'trimestre1'                    => $trimestre1,
                'trimestre2'                    => $trimestre2,
                'trimestre3'                    => $trimestre3,
                'rubrica'                       => $rubrica,
                'aplica'                        => $aplica,
                'orden_impresion'               => $orden_impresion // se agrega orden de impresión
            ]);

            alert('Escuela Modelo', 'La rubica se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
            return back();

        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton()->autoClose(5000);
            return redirect('preescolar_rubricas/create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rubrica = Preescolar_rubricas::findOrFail($id);

        return view('preescolar.rubricas.show', [
            "rubrica" => $rubrica
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rubrica = Preescolar_rubricas::select(
            'preescolar_rubricas.id',
            'preescolar_rubricas.preescolar_rubricas_tipo_id',
            'preescolar_rubricas.grado',
            'preescolar_rubricas.trimestre1',
            'preescolar_rubricas.trimestre2',
            'preescolar_rubricas.trimestre3',
            'preescolar_rubricas.rubrica',
            'preescolar_rubricas.aplica',
            'preescolar_rubricas_tipo.tipo',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.id as periodo_id',
            'periodos.perAnioPago',
            'periodos.perNumero',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal'
        )
        ->join('preescolar_rubricas_tipo', 'preescolar_rubricas.preescolar_rubricas_tipo_id', '=', 'preescolar_rubricas_tipo.id')
        ->join('programas', 'preescolar_rubricas.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('periodos', 'preescolar_rubricas.periodo_id', '=', 'periodos.id')
        ->findOrFail($id);

        $programas = Programa::select(
            'programas.id',
            'programas.progClave',
            'programas.progNombre',
            'departamentos.depClave'
        )
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
        ->get();



        $ubicaciones = Ubicacion::all();
        $departamento = Departamento::select()->whereIn('depClave', ['PRE', 'MAT'])->get();
        $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::get();

        
        return view('preescolar.rubricas.edit', [
            "rubrica" => $rubrica,
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento,
            "preescolar_rubricas_tipo" => $preescolar_rubricas_tipo,
            "programas" => $programas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // seleccionar el id correspondiente 
        $rubrica_edit = Preescolar_rubricas::where('id', $id)->first();

        $validator = Validator::make($request->all(),
        [
            'preescolar_rubricas_tipo_id'   => 'required',
            'grado'           => 'required',
            'rubrica'   => 'required',
            'aplica'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect ('preescolar_rubricas/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $preescolar_calificacion = Preescolar_calificacion::where('rubrica_id', $rubrica_edit->id)->get();


        // if(count($preescolar_calificacion) > 0){
        //     alert('Escuela Modelo', 'No es posible actualizar esta rúbrica debido que hay calificaciones con esta información','warning')->showConfirmButton()->autoClose(5000);
        //     return back();
        // }

        // varibles que vienen del \request
        $preescolar_rubricas_tipo_id = $request->preescolar_rubricas_tipo_id;
        $periodo_id = $request->periodo_id;
        $programa_id = $request->programa_id;
        $grado = $request->grado;
        $trimestre1 = $request->trimestre1;
        $trimestre2 = $request->trimestre2;
        $trimestre3 = $request->trimestre3;
        $rubrica = $request->rubrica;
        $aplica = $request->aplica;

        $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::findOrFail($preescolar_rubricas_tipo_id);

        $preescolar_rubricas = Preescolar_rubricas::findOrFail($id);
        $orden_deseado = $request->orden_impresion;
        $orden_original = $preescolar_rubricas->orden_impresion;

        try {
            $datos_actualizar = [
                'periodo_id'                    => $periodo_id,
                'programa_id'                   => $programa_id,
                'preescolar_rubricas_tipo_id'   => $preescolar_rubricas_tipo_id,
                'tipo'                          => $preescolar_rubricas_tipo->tipo,
                'grado'                         => $grado,
                'trimestre1'                    => $trimestre1,
                'trimestre2'                    => $trimestre2,
                'trimestre3'                    => $trimestre3,
                'rubrica'                       => $rubrica,
                'aplica'                        => $aplica,
                // 'orden_impresion'               => $orden_deseado // se agrega orden de impresión
            ];
            if ( !is_null($request->orden_impresion) ) {
                $section = Preescolar_rubricas::where('programa_id', $programa_id)
                        ->where('grado', $grado)
                        ->whereBetween('orden_impresion', [$orden_deseado, $orden_original])
                        ->orderBy('orden_impresion', 'ASC');

                // si el orden es mayor que el actual
                if ($orden_deseado > $orden_original) $section->decrement('orden_impresion');
                // si el orden es menos que el actual
                if ($orden_deseado < $orden_original) $section->increment('orden_impresion');
                //si es igual no hacer nada
                $datos_actualizar['orden_impresion'] = $orden_deseado;
            }

            $rubrica_edit->update($datos_actualizar);
            
            alert('Escuela Modelo', 'La rubica se ha actualizado con éxito','success')->showConfirmButton()->autoClose(5000);
            return back();

        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton()->autoClose(5000);
            return redirect('preescolar_rubricas/'.$id.'/edit')->withInput();
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
