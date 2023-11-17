<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Alumno;
use App\Http\Models\ListaNegra;
use App\Http\Models\NivelListaNegra;
use App\Http\Models\Persona;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BachillerListaNegraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bachiller.listaNegra.show-list');
    }

    public function list()
    {
        $listaNegra = ListaNegra::select(
            'listanegra.id',
            'listanegra.alumno_id',
            'listanegra.lnFecha',
            'listanegra.lnNivel',
            'listanegra.lnRazon',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'niveleslistanegra.nlnClave',
            'niveleslistanegra.nlnDescripcion'
        )
        ->leftJoin('alumnos', 'listanegra.alumno_id', '=', 'alumnos.id')
        ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->leftJoin('niveleslistanegra', 'listanegra.lnNivel', '=', 'niveleslistanegra.id')
        ->latest('listanegra.created_at');

        return DataTables::of($listaNegra)

            ->filterColumn('fecha_restriccion', function ($query, $keyword)  {

                if($keyword == "ENE"){
                    $keyword = "JAN";
                }

                if($keyword == "ABR"){
                    $keyword = "APR";
                }
                
                
                $query->whereRaw("CONCAT(date_format(lnFecha, '%d/%M/%Y')) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha_restriccion', function ($query) {
                return Utils::fecha_string($query->lnFecha, $query->lnFecha);
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('apellido_pat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_pat', function ($query) {
                return $query->perApellido1;
            })

            ->filterColumn('apellido_mat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_mat', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('nombres', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombres', function ($query) {
                return $query->perNombre;
            })

            ->filterColumn('razon', function ($query, $keyword) {
                $query->whereRaw("CONCAT(lnRazon) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('razon', function ($query) {
                return $query->lnRazon;
            })

            ->filterColumn('descripcion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(nlnDescripcion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('descripcion', function ($query) {
                return $query->nlnDescripcion;
            })
            

       
            ->addColumn('action', function ($query) {



                $btnEditar = "";

               

                $btnEditar = '<a href="bachiller_alumnos_restringidos/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                $btnBorrar = '<form id="delete_' . $query->id . '" action="bachiller_alumnos_restringidos/' . $query->id . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';


                return '<a href="bachiller_alumnos_restringidos/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>' 
                . $btnEditar
                . $btnBorrar;
            })
            ->make(true);
    }

    public function create()
    {
        $alumno = null;

        $NivelListaNegra = NivelListaNegra::get();

        $fechaActual = Carbon::now('America/Merida');

        return view('bachiller.listaNegra.create',[
            'alumno' => $alumno,
            'NivelListaNegra' => $NivelListaNegra,
            'fechaActual' => $fechaActual->format('Y-m-d')
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'alumno_id' => 'required|unique:listanegra,alumno_id',
                'lnNivel' => 'required',
                'lnFecha' => 'required',
                'lnRazon' => 'required'

            ],
            [
                'alumno_id.unique' => "El alumno ya se encuentra restringido",
                'lnNivel.required' => "El nivel de restricción es obligatorio",
                'lnFecha.required' => "La fecha de restricción es obligatorio",
                'lnRazon.required' => "La razón de restricción es obligatorio"
            ]
        );


        if ($validator->fails()) {
            return redirect ('bachiller_alumnos_restringidos/create')->withErrors($validator)->withInput();
        }

        $listaNegra = ListaNegra::where('alumno_id', $request->alumno_id)
        ->where('lnNivel', $request->lnNivel)
        ->whereNull('deleted_at')
        ->first();

        if($listaNegra != ""){
            alert('Escuela Modelo', 'Ya se encuentra registrado el alumno con dicha restricción','error')->showConfirmButton();
            return redirect ('bachiller_alumnos_restringidos/create')->withInput();
        }else{

            ListaNegra::create([
                'alumno_id' => $request->alumno_id,
                'lnFecha' => $request->lnFecha,
                'lnNivel' => $request->lnNivel,
                'lnRazon' => $request->lnRazon
            ]);

            alert('Escuela Modelo', 'El registro de ha realizado con éxito','success')->showConfirmButton();
            return redirect ('bachiller_alumnos_restringidos/create')->withInput();

        }
        
    }

    public function edit($id)
    {
        $listaNegra = ListaNegra::find($id);
        $alumno = Alumno::find($listaNegra->alumno_id);
        $persona = Persona::find($alumno->persona_id);
        $NivelListaNegra = NivelListaNegra::get();
        $fechaActual = Carbon::now('America/Merida');

        return view('bachiller.listaNegra.edit',[
            'listaNegra' => $listaNegra,
            'alumno' => $alumno,
            'persona' => $persona,
            'NivelListaNegra' => $NivelListaNegra,
            'fechaActual' => $fechaActual->format('Y-m-d')
        ]);
    }


    public function update($id, Request $request)
    {

        $lista = ListaNegra::find($id);

        if($lista->alumno_id == $request->alumno_id){
            $verificacion = 'required';
        }else{
            $verificacion = 'required|unique:listanegra,alumno_id';
        }
        $validator = Validator::make($request->all(),
            [
                'alumno_id' => $verificacion,
                'lnNivel' => 'required',
                'lnFecha' => 'required',
                'lnRazon' => 'required'

            ],
            [
                'alumno_id.unique' => "El alumno ya se encuentra restringido",
                'lnNivel.required' => "El nivel de restricción es obligatorio",
                'lnFecha.required' => "La fecha de restricción es obligatorio",
                'lnRazon.required' => "La razón de restricción es obligatorio"
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $registro = ListaNegra::find($id);

        $registro->update([
            'alumno_id' => $request->alumno_id,
            'lnFecha' => $request->lnFecha,
            'lnNivel' => $request->lnNivel,
            'lnRazon' => $request->lnRazon
        ]);

        alert('Escuela Modelo', 'El registro de actualizo con éxito','success')->showConfirmButton();
        return back();
        
    }

    public function show($id)
    {
        $listaNegra = ListaNegra::find($id);
        $alumno = Alumno::find($listaNegra->alumno_id);
        $persona = Persona::find($alumno->persona_id);
        $NivelListaNegra = NivelListaNegra::find($listaNegra->lnNivel);
        $fechaActual = Carbon::now('America/Merida');

        return view('bachiller.listaNegra.show',[
            'listaNegra' => $listaNegra,
            'alumno' => $alumno,
            'persona' => $persona,
            'NivelListaNegra' => $NivelListaNegra,
            'fecha' => Utils::fecha_string($listaNegra->lnFecha, $listaNegra->lnFecha)
        ]);
    }

    public function destroy($id)
    {
        $registro = ListaNegra::findOrFail($id);

        
        try {
           
            if($registro->delete()) {
                alert('Escuela Modelo', 'El registro se ha eliminado con éxito','success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el registro')->showConfirmButton();
            }
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_alumnos_restringidos')->withInput();
    }
}
