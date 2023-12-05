<?php

namespace App\Http\Controllers\Tutorias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tutorias\Tutorias_bitacoras;
use Yajra\DataTables\Facades\DataTables;

class TutoriasBitacoraElectronicaController extends Controller
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
        return view('tutorias.bitacora.show-list');
    }

    public function list()
    {


        $alumnos = Tutorias_bitacoras::select(
            'tutorias_alumnos.AlumnoID',
            'tutorias_alumnos.Nombre AS nombre_alumno',
            'tutorias_alumnos.ApellidoPaterno as apellido_patermo_alumno',
            'tutorias_alumnos.ApellidoMaterno as apellido_materno_alumno',
            'tutorias_alumnos.Correo',
            'tutorias_alumnos.Matricula', 
            'tutorias_alumnos.CarreraID',
            'tutorias_alumnos.ClaveCarrera',
            'tutorias_alumnos.EscuelaID',
            'tutorias_alumnos.ClaveEscuela',
            'tutorias_alumnos.Escuela',
            'tutorias_alumnos.UniversidadID',
            'tutorias_alumnos.ClaveUniversidad',
            'tutorias_alumnos.Universidad'
        )
        ->leftJoin('tutorias_carreras', 'tutorias_alumnos.CarreraID', '=', 'tutorias_carreras.CarreraID');

        return DataTables::of($alumnos)

            ->addColumn('action', function ($alumnos) {
                $acciones = '';

                $acciones = '<div class="row">
                                  
                    <a href="/tutorias_alumnos/encuestas_disponibles/'.$alumnos->AlumnoID.'" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>'
                    ;

                return $acciones;
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
}
