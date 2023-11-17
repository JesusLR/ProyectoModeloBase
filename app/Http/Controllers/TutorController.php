<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Tutor;
use App\Http\Models\Alumno;
use App\Http\Models\TutorAlumno;

use App\clases\tutores\MetodosTutores;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;

class TutorController extends Controller
{

    public function __contruct(){
        $this->middleware('auth');
        $this->middleware('permisos:r_constancia_inscripcion');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('tutores.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tutores.create');
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
        DB::beginTransaction();
        try {
            $tutor = Tutor::create([
                'tutNombre' => $request->tutNombre,
                'tutCalle' => $request->tutCalle,
                'tutColonia' => $request->tutColonia,
                'tutCodigoPostal' => $request->tutCodigoPostal,
                'tutPoblacion' => $request->tutPoblacion,
                'tutEstado' => $request->tutEstado,
                'tutTelefono' => $request->tutTelefono,
                'tutCorreo' => $request->tutCorreo
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if($request->aluClaves) {
            $alumnos = Alumno::whereIn('aluClave',$request->aluClaves)->get()->unique('alumno_id');
            MetodosTutores::vincularAlumnos($alumnos, $tutor);
        }

        DB::commit();
        alert()->success('Realizado', 'Se ha registrado con éxito el tutor.');
        return redirect('tutores');
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
        $tutor = Tutor::findOrFail($id);

        return view('tutores.show', compact('tutor'));
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
        $tutor = Tutor::findOrFail($id);

        return view('tutores.edit', compact('tutor'));
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
        $tutor = Tutor::findOrFail($id);


        DB::beginTransaction();
        try {

            $tutor->update([
                'tutNombre' => $request->tutNombre,
                'tutCalle' => $request->tutCalle,
                'tutColonia' => $request->tutColonia,
                'tutCodigoPostal' => $request->tutCodigoPostal,
                'tutPoblacion' => $request->tutPoblacion,
                'tutEstado' => $request->tutEstado,
                'tutTelefono' => $request->tutTelefono,
                'tutCorreo' => $request->tutCorreo
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
   
        if($request->aluClaves) {
            $alumnos = Alumno::whereIn('aluClave',$request->aluClaves)->get()->unique('alumno_id');
            MetodosTutores::vincularAlumnos($alumnos, $tutor);
        }else{
            $tutor->alumnos()->delete();
        }

        DB::commit(); #TEST.
        return redirect('tutores');

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
        $tutor = Tutor::findOrFail($id);
        $tutor->delete();

    }

    /*
    * Envía los datos a la vista tutores.show-list.
    *
    */
    public function list(){

        $tutores = Tutor::select('*')->latest('tutores.created_at');

        return DataTables::eloquent($tutores)
        ->addColumn('tutNombre', function (Tutor $tutor) {
            return $tutor->tutNombre;
        })
        ->addColumn('tutCalle', function (Tutor $tutor) {
            return $tutor->tutCalle;
        })
        ->addColumn('tutColonia', function (Tutor $tutor) {
            return $tutor->tutColonia;
        })
        ->addColumn('tutCodigoPostal', function (Tutor $tutor) {
            return $tutor->tutCodigoPostal;
        })
        ->addColumn('tutPoblacion', function (Tutor $tutor) {
            return $tutor->tutPoblacion;
        })
        ->addColumn('tutEstado', function (Tutor $tutor) {
            return $tutor->tutEstado;
        })
        ->addColumn('tutTelefono', function (Tutor $tutor) {
            return $tutor->tutTelefono;
        })
        ->addColumn('tutCorreo', function (Tutor $tutor) {
            return $tutor->tutCorreo;
        })
        ->addColumn('action', function (Tutor $tutor) {
            return '<div class="row">
                        <div class="col s1">
                        <a href="tutores/'.$tutor->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="tutores/'.$tutor->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                    </div>';
        })
        ->toJson();

    }//list.

    public function alumnos_tutor($id){

        $tutor = Tutor::findOrFail($id);
        $alumnos = $tutor->alumnos()->get()->load('alumno.persona');

        return json_encode($alumnos);

    }//alumnos_tutor.

    /*
    * 
    */
    public function buscarAlumno(Request $request, $aluClave){

        $alumno = Alumno::with('persona')
        ->where('aluClave', $aluClave)->first();
        
        return ($request->ajax) ? json_encode($alumno) : $alumno;
    }//buscarAlumno.



}//controller.
