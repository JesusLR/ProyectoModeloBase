<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ficha;

use App\clases\personas\MetodosPersonas;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Helpers\Utils;
use Carbon\Carbon;

class ConsultaFichasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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

    public function fichas() {
        return view('pagos/consulta_fichas.show-list');
    }//fichas.

    /*
    * Crea la estructura del datatable de la tabla fichas.
    */
    public function list() {

        $fichas = Ficha::with(['alumno.persona', 'usuario'])->latest();

        return DataTables::of($fichas)
        ->addColumn('fchClaveAlu', static function(Ficha $ficha) {
            return $ficha->fchClaveAlu;
        })
        ->filterColumn('nombreAlumno', static function ($query, $keyword) {
            return $query->whereHas('alumno.persona', static function($query) use ($keyword) {
                return $query->whereRaw("CONCAT(perNombre,' ',perApellido1,' ',perApellido2) LIKE ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreAlumno', static function(Ficha $ficha) {
            $alumno = $ficha->alumno;
            return $alumno ? MetodosPersonas::nombreCompleto($alumno->persona) : '';
        })
        ->addColumn('fchNumPer', static function(Ficha $ficha) {
            return $ficha->fchNumPer;
        })
        ->addColumn('fchAnioPer', static function(Ficha $ficha) {
            return $ficha->fchAnioPer;
        })
        ->filterColumn('grado', static function($query, $keyword) {
            return $query->whereRaw("CONCAT(fchGradoSem, '-', fchGrupo) LIKE ?", ["%{$keyword}%"]);
        })
        ->addColumn('grado', static function(Ficha $ficha) {
            return $ficha->fchGradoSem.'-'.$ficha->fchGrupo;
        })
        ->filterColumn('fchFechaImpr', static function($query, $keyword) {
            $esValida = strtotime($keyword);
            if($esValida != false) {
                $keyword = Carbon::parse($keyword)->format('Y-m-d');
            } else {
                $keyword = Carbon::now('CDT')->format('Y-m-d');
            }
            return $query->where('fchFechaImpr', $keyword);

        })
        ->addColumn('fchFechaImpr', static function(Ficha $ficha) {
            return Utils::fecha_string($ficha->fchFechaImpr, true, 'y');
        })
        ->addColumn('fchTipo', static function(Ficha $ficha) {
            return $ficha->fchTipo;
        })
        ->addColumn('fchConc', static function(Ficha $ficha) {
            return $ficha->fchConc;
        })
        ->filterColumn('fhcRef1', static function($query, $keyword) {
            return $query->where("fhcRef1", ["%{$keyword}%"]);
        })
        ->addColumn('fhcRef1', static function(Ficha $ficha) {
            return $ficha->fhcRef1;
        })
        ->filterColumn('fchFechaVenc1', static function($query, $keyword) {
            $esValida = strtotime($keyword);
            if($esValida != false) {
                $keyword = Carbon::parse($keyword)->format('Y-m-d');
            } else {
                $keyword = Carbon::now('CDT')->format('Y-m-d');
            }
            return $query->where('fchFechaVenc1', $keyword);

        })
        ->addColumn('fchFechaVenc1', static function(Ficha $ficha) {
            return Utils::fecha_string($ficha->fchFechaVenc1, true, 'y');
        })
        ->addColumn('fhcImp1', static function(Ficha $ficha) {
            return $ficha->fhcImp1;
        })
        ->addColumn('fchEstado', static function(Ficha $ficha) {
            return $ficha->fchEstado;
        })
        ->filterColumn('username', static function($query, $keyword) {
            return $query->whereHas('usuario', static function($query) use ($keyword) {
                return $query->where('username', 'like', '%'.$keyword.'%');
            });
        })
        ->addColumn('username', static function(Ficha $ficha) {
            return $ficha->usuario->username;
        })
        ->toJson();
    }//list.
    
}//Controller class
