<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\CuotaDescuento;
use App\Http\Models\Cuota;
use App\Http\Helpers\Utils;
use App\clases\cuotas\MetodosCuotas;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class CuotaDescuentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:registro_cuotas']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pagos/cuota_descuento.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pagos/cuota_descuento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cuota = Cuota::findOrFail($request->cuota_id);

        if(!self::validarExisteCongruenciaDeFechas($request)) {
            alert('No se puede realizar la acción', 'Verifique que la fecha final del descuento de cuota sea posterior a la fecha de inicio.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        try {
            $cuota_descuento = CuotaDescuento::create($request->all());
        } catch (Exception $e) {
            alert('Ha ocurrido un error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        alert('Realizado', 'Se ha registrado el descuento correctamente', 'success')->showConfirmButton();
        return redirect("pagos/registro_cuotas/{$cuota->id}/cuota_descuento");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuota_descuento = CuotaDescuento::findOrFail($id);
        $cuota = $cuota_descuento->cuota;
        $programa = $cuota->cuoTipo == 'P' ? $cuota->relacion : null;
        $escuela = $cuota->cuoTipo == 'E' ? $cuota->relacion : null;
        $departamento = $cuota->cuoTipo == 'D' ? $cuota->relacion : null;

        return view('pagos/cuota_descuento.show', [
            'cuota_descuento' => $cuota_descuento,
            'cuota' => $cuota,
            'programa' => $programa,
            'escuela' => $escuela,
            'departamento' => $departamento,
            'ubicacion' => MetodosCuotas::ubicacion($cuota),
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
        $cuota_descuento = CuotaDescuento::findOrFail($id);
        $cuota = $cuota_descuento->cuota;
        $programa = $cuota->cuoTipo == 'P' ? $cuota->relacion : null;
        $escuela = $cuota->cuoTipo == 'E' ? $cuota->relacion : null;
        $departamento = $cuota->cuoTipo == 'D' ? $cuota->relacion : null;

        return view('pagos/cuota_descuento.edit', [
            'cuota_descuento' => $cuota_descuento,
            'cuota' => $cuota,
            'programa' => $programa,
            'escuela' => $escuela,
            'departamento' => $departamento,
            'ubicacion' => MetodosCuotas::ubicacion($cuota),
            'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
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
        $cuota_descuento = CuotaDescuento::findOrFail($id);

        if(!self::validarExisteCongruenciaDeFechas($request)) {
            alert('No se puede realizar la acción', 'Verifique que la fecha final del descuento de cuota sea posterior a la fecha de inicio.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        try {
            $cuota_descuento->update($request->all());
        } catch (Exception $e) {
            alert('Ha ocurrido un error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuota_descuento = CuotaDescuento::findOrFail($id);
        try {
            $cuota_descuento->delete();
        } catch (Exception $e) {
            alert('Ha ocurrido un error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return redirect()->back();
    }

    /**
     * función para agregar un descuento a una cuota_id específica,
     * es una ruta distinta a pagos/cuota_descuento/create.
     */
    public function agregar_descuento($cuota_id)
    {
        $cuota = Cuota::findOrFail($cuota_id);
        $programa = $cuota->cuoTipo == 'P' ? $cuota->relacion : null;
        $escuela = $cuota->cuoTipo == 'E' ? $cuota->relacion : null;
        $departamento = $cuota->cuoTipo == 'D' ? $cuota->relacion : null;

        return view('pagos/cuota_descuento.create', [
            'cuota' => $cuota,
            'programa' => $programa,
            'escuela' => $escuela,
            'departamento' => $departamento,
            'ubicacion' => MetodosCuotas::ubicacion($cuota),
            'hoy' => Carbon::now('America/Merida')->format('Y-m-d'),
        ]);
    }

    public function list(Request $request)
    {
        $cuotas_descuentos = CuotaDescuento::select('cuotas_descuento.*', 'cuotas.cuoAnio', 'cuotas.cuoTipo')
        ->join('cuotas', 'cuotas.id', 'cuotas_descuento.cuota_id')
        ->where(static function($query) use ($request) {
            $query->whereNull('cuotas.deleted_at');
            if($request->cuota_id)
                $query->where('cuota_id', $request->cuota_id);
        });

        return Datatables::of($cuotas_descuentos)
        ->addColumn('action', static function($cuota_descuento) {
            return '<div class="row">'
                    . Utils::btn_show($cuota_descuento->id, '/pagos/cuota_descuento')
                    . Utils::btn_edit($cuota_descuento->id, '/pagos/cuota_descuento') .
                '</div>';
        })->make(true);
    }

    /**
     * Si indican fechas inicio y final, debe verificar que la fecha final sea mayor a la de inicio.
     *
     * @param Illuminate\Http\Request
     */
    private static function validarExisteCongruenciaDeFechas($request): bool 
    {
        return ($request->cudFechaInicio && $request->cudFechaFinal) 
            ? $request->cudFechaFinal >= $request->cudFechaInicio
            : true;
    }
}
