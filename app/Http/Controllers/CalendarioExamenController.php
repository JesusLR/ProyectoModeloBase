<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalendarioExamen\StoreCalendarioExamen;
use App\Http\Requests\CalendarioExamen\UpdateCalendarioExamen;

use Auth;
use App\Models\User;
use App\Models\CalendarioExamen;
use App\Models\Extraordinario;
use App\Models\Ubicacion;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Helpers\Utils;
use Carbon\Carbon;
use Exception;
use DB;

class CalendarioExamenController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:alumno');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('calendarioexamen.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ubicaciones = Ubicacion::all();
        return view('calendarioexamen/create', compact('ubicaciones'));
    }

    public function checkPeriod($first, $last, $date)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $first);
        $endDate = Carbon::createFromFormat('Y-m-d', $last);
        return Carbon::parse($date)->between($startDate,$endDate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalendarioExamen $request)
    {
        if ( is_null($request->calexInicioExtraordinario) || is_null($request->calexFinExtraordinario) ) {
            alert()->warning('Fechas del Período Extraordinarios 1', 'Fechas del Período Extraordinarios 1 no pueden ir vacias.')->showConfirmButton();
            return back()->withInput();
        }

        // El Request ya ha sido validado en StoreCalendarioExamen.
        DB::beginTransaction();
        try {

            $calendario = CalendarioExamen::create([
                'periodo_id' => $request->periodo_id,
                'calexInicioParcial1' => $request->calexInicioParcial1,
                'calexFinParcial1' => $request->calexFinParcial1,
                'calexInicioParcial2' => $request->calexInicioParcial2,
                'calexFinParcial2' => $request->calexFinParcial2,
                'calexInicioParcial3' => $request->calexInicioParcial3,
                'calexFinParcial3' => $request->calexFinParcial3,
                'calexInicioOrdinario' => $request->calexInicioOrdinario,
                'calexFinOrdinario' => $request->calexFinOrdinario,
                'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                'calexFinExtraordinario' => $request->calexFinExtraordinario,
                'calexInicioExtraordinario2' => $request->calexInicioExtraordinario2,
                'calexFinExtraordinario2' => $request->calexFinExtraordinario2,
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            alert('Error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        return redirect('calendarioexamen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $calendario = CalendarioExamen::findOrFail($id);
        return view('calendarioexamen.show', compact('calendario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $calendario = CalendarioExamen::findOrFail($id);
        return view('calendarioexamen.edit', compact('calendario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalendarioExamen $request, $id)
    {
        // El Request ya ha sido validado en UpdateCalendarioExamen.
        $calendario = CalendarioExamen::find($id);
        DB::beginTransaction();
        try {

            $calendario->update([
                'calexInicioParcial1' => $request->calexInicioParcial1,
                'calexFinParcial1' => $request->calexFinParcial1,
                'calexInicioParcial2' => $request->calexInicioParcial2,
                'calexFinParcial2' => $request->calexFinParcial2,
                'calexInicioParcial3' => $request->calexInicioParcial3,
                'calexFinParcial3' => $request->calexFinParcial3,
                'calexInicioOrdinario' => $request->calexInicioOrdinario,
                'calexFinOrdinario' => $request->calexFinOrdinario,
                'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                'calexFinExtraordinario' => $request->calexFinExtraordinario,
                'calexInicioExtraordinario2' => $request->calexInicioExtraordinario2,
                'calexFinExtraordinario2' => $request->calexFinExtraordinario2,
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            alert('Error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        return back();
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
        $calendario = CalendarioExamen::find($id);
        $calendario->delete();

        return back();
    }


    //función para generar DataTable de CalendarioExamen.
    public function list() {

        $calendarios = CalendarioExamen::with('periodo.departamento.ubicacion')->latest();

        return DataTables::eloquent($calendarios)
        ->filterColumn('ubicacion', static function($query, $keyword) {
            return $query->whereHas('periodo.departamento.ubicacion', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT(ubiClave,'-',ubiClave) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('ubicacion', static function (CalendarioExamen $calendario) {
            $ubicacion = $calendario->periodo->departamento->ubicacion;
            return $ubicacion->ubiClave;
        })
        ->filterColumn('departamento', static function ($query, $keyword) {
            return $query->whereHas('periodo.departamento.ubicacion', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT(depClave,'-',depNombre) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('departamento', static function (CalendarioExamen $calendario) {
            $departamento = $calendario->periodo->departamento;
            return $departamento->depClave;
        })
        // ->filterColumn('periodo', static function ($query, $keyword) {
        //     return $query->whereHas('periodo.departamento.ubicacion', static function ($query) use ($keyword) {
        //         return $query->whereRaw("CONCAT(perNumero,'-',perAnio) LIKE ?", ["%{$keyword}%"]);
        //     });
        // })
        ->filterColumn('perNumero', static function($query, $keyword) {
            return $query->whereHas('periodo', static function($query) use ($keyword) {
                $query->where('perNumero', $keyword);
            });
        })
        ->addColumn('perNumero', static function (CalendarioExamen $calendario) {
            return $calendario->periodo->perNumero;
        })
        ->filterColumn('perAnio', static function($query, $keyword) {
            return $query->whereHas('periodo', static function($query) use ($keyword) {
                $query->where('perAnio', $keyword);
            });
        })
        ->addColumn('perAnio', static function (CalendarioExamen $calendario) {
            return $calendario->periodo->perAnio;
        })
        ->addColumn('calexInicioParcial1', static function (CalendarioExamen $calendario) {
            $fechaInicial = Utils::fecha_string($calendario->calexInicioParcial1, true,'YY');
            $fechaFinal = Utils::fecha_string($calendario->calexFinParcial1, true,'YY');
            return "{$fechaInicial} - {$fechaFinal}";
        })
        ->addColumn('calexInicioParcial2', static function (CalendarioExamen $calendario) {
            $fechaInicial = Utils::fecha_string($calendario->calexInicioParcial2, true, 'YY');
            $fechaFinal = Utils::fecha_string($calendario->calexFinParcial2, true, 'YY');
            return "{$fechaInicial} - {$fechaFinal}";
        })
        ->addColumn('calexInicioParcial3', static function (CalendarioExamen $calendario) {
            $fechaInicial = Utils::fecha_string($calendario->calexInicioParcial3, true, 'YY');
            $fechaFinal = Utils::fecha_string($calendario->calexFinParcial3, true, 'YY');
            return "{$fechaInicial} - {$fechaFinal}";
        })
        ->addColumn('calexInicioOrdinario', static function (CalendarioExamen $calendario) {
            $fechaInicial = Utils::fecha_string($calendario->calexInicioOrdinario, true, 'YY');
            $fechaFinal = Utils::fecha_string($calendario->calexFinOrdinario, true, 'YY');
            return "{$fechaInicial} - {$fechaFinal}";
        })
        ->addColumn('action', static function (CalendarioExamen $calendario) {

            $btn_borrar = null;
            $btn_editar = null;
            $permiso = User::permiso('calendarioexamen');

            if($permiso == "A" || $permiso == "B" || Auth::user()->username == "DESARROLLO") {
                $btn_borrar = '<form id="delete_' . $calendario->id . '" action="calendarioexamen/' . $calendario->id . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <a href="#" data-id="' . $calendario->id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </form>';

                $btn_editar = '<a href="calendarioexamen/'.$calendario->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                                <i class="material-icons">edit</i>
                               </a>';
            }//permiso


            return '<div class="row">
                        <div class="col s1">
                        <a href="calendarioexamen/'.$calendario->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                            '.$btn_editar.'
                        </div>
                        <div class="col s1">
                            '.$btn_borrar.'
                        <div>
                    </div>';
        })
        ->toJson();
    }//list.



}
