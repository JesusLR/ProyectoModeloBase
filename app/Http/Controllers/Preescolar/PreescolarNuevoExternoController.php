<?php

namespace App\Http\Controllers\Preescolar;

use App\clases\alumnos\MetodosAlumnos;
use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Helpers\Utils;
use App\Http\Models\Alumno;
use App\Http\Models\Beca;
use App\Http\Models\Candidato;
use App\Http\Models\Pais;
use App\Http\Models\Persona;
use App\Http\Models\Programa;
use App\Http\Models\Tutor;
use App\Http\Models\Ubicacion;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\Permission_module_user;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class PreescolarNuevoExternoController extends Controller
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
        // $departamentos = Departamentos::buscarSoloAcademicos(1, ['SUP', 'POS', 'DIP', 'PRE', 'PRI'])->unique("depClave");

        $departamentos = MetodosDepartamentos::buscarAEX(1, ['AEX'])->unique("depClave");

        $paises = Pais::get();

        return view('preescolar.nuevo_externo.create', compact('departamentos', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function store(Request $request)
    {

        $fechaActual = Carbon::now('CDT')->format('Y-m-d');
        $esCurpValida = "accepted";
        $perCurpValida = 'required|max:18|unique:personas,deleted_at,NULL';
        if ($request->paisId != "1") {
            $esCurpValida = "";
            $perCurpValida  = 'max:18';
        }


        $alumno = Alumno::with("persona")
        ->whereHas('persona', function ($query) use ($request) {
            if ($request->perCurp) {
                $query->where('perCurp', $request->perCurp);
            }
        })
            ->first();

        $aluClave = "";
        if ($alumno) {
            $aluClave = $alumno->aluClave;
        }

        //dd($alumno);



        $validator = Validator::make(
            $request->all(),
            [
                'aluClave'      => 'unique:alumnos,aluClave,NULL,id,deleted_at,NULL',
                'persona_id'    => 'unique:alumnos,persona_id,NULL,id,deleted_at,NULL',
                'aluNivelIngr'  => 'required|max:4',
                'aluGradoIngr'  => 'required|max:4',
                'perNombre'     => ['required', 'max:40', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido1'  => ['required', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perApellido2'  => ['nullable', 'max:30', 'regex:/^[A-ZÄËÏÖÜÑ ]+$/'],
                'perCurp'       =>  $perCurpValida,
                'esCurpValida'  => $esCurpValida,
                'perFechaNac'   => 'required|before_or_equal:' . $fechaActual,
                'municipio_id'  => 'required',
                'perSexo'       => 'required',
                'perDirCP'      => 'max:5',
                'perDirCalle'   => 'max:25',
                'perDirNumExt'  => 'max:6',
                'perDirColonia' => 'max:60',
                'perCorreo1'    => 'nullable|email',
                'perTelefono2'  => 'required'
            ],
            [
                'aluClave.unique'   => "El alumno ya existe",
                'persona_id.unique' => "La persona ya existe",
                'perCurp.unique'    => "Ya existe registrado un alumno con esta misma clave CURP. "
                . "Favor de consultar los datos del alumno existente, con su clave registrada: "
                . $aluClave,
                'perCurp.max' => 'El campo de CURP no debe contener más de 18 caracteres',
                'esCurpValida.accepted' => 'La CURP proporcionada no es válida. Favor de verificarla.',
                'perCorreo1.email' => 'Debe proporcionar una dirección de correo válida, Favor de verificar.',
                'perFechaNac.before_or_equal' => 'La fecha de Nacimiento no puede ser mayor a la fecha actual.',

                'perFechaNac.required' => 'La fecha de nacimiento es obligatoria.',
                'aluNivelIngr.required' => 'El nivel de ingreso es obligatorio',
                'aluGradoIngr.required' => 'El grado de ingreso es obligatorio',
                'perNombre.required' => 'El nombre es obligatorio',
                'perNombre.regex' => 'Los nombres no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido1.required' => 'El apellido paterno es obligatorio',
                'perApellido1.regex' => 'El apellido paterno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'perApellido2.regex' => 'El apellido materno no deben contener tildes ni caracteres especiales, solo se permiten Ñ,Ä,Ë,Ï,Ö,Ü',
                'municipio_id.required' => 'El municipio es obligatorio',
                'perSexo.required' => 'El sexo es obligatorio',
                // 'perDirCP.required' => 'El codigo postal es obligatorio',
                // 'perDirCalle.required' => 'La calle del domicilio es obligatoria',
                // 'perDirNumExt.required' => 'El numero exterior del domicilio es obligatorio',
                // 'perDirColonia.required' => 'La colonia del domicilio es obligatoria',
                // 'perCorreo1.required' => 'El email es obligatorio',
                'perTelefono2.required' => 'El teléfono movil es obligatorio',



            ]
        );
        // return redirect ('alumno/create')->withErrors($validator)->withInput();

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $existeNombre = Persona::where("perApellido1", "=", $request->perApellido1)
            ->where("perApellido2", "=", $request->perApellido2)
            ->where("perNombre", "=", $request->perNombre)
            ->first();
        if ($existeNombre) {
            alert()->error('Ups ...', 'El nombre y apellidos coincide con nuestra base de datos. Favor de verificar que exista el alumno o empleado')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        $claveAlu = $this->generarClave($request->aluNivelIngr, $request->aluGradoIngr);
        $perCurp = $request->perCurp;
        if ($request->paisId != "1" && $request->perSexo == "M") {
            $perCurp = "XEXX010101MNEXXXA4";
        }
        if ($request->paisId != "1" && $request->perSexo == "F") {
            $perCurp = "XEXX010101MNEXXXA8";
        }

        DB::beginTransaction();
        try {
            $persona = Persona::create([
                'perCurp'        => $perCurp,
                'perApellido1'   => $request->perApellido1,
                'perApellido2'   => $request->perApellido2 ? $request->perApellido2 : "",
                'perNombre'      => $request->perNombre,
                'perFechaNac'    => $request->perFechaNac,
                'municipio_id'   => Utils::validaEmpty($request->municipio_id),
                'perSexo'        => $request->perSexo,
                'perCorreo1'     => $request->perCorreo1,
                'perTelefono1'   => $request->perTelefono1,
                'perTelefono2'   => $request->perTelefono2,
                'perDirCP'       => Utils::validaEmpty($request->perDirCP),
                'perDirCalle'    => $request->perDirCalle,
                'perDirNumInt'   => $request->perDirNumInt,
                'perDirNumExt'   => $request->perDirNumExt,
                'perDirColonia'  => $request->perDirColonia
            ]);

            $alumno = Alumno::create([
                'persona_id'      => $persona->id,
                'aluClave'        => (int) $claveAlu,
                'aluNivelIngr'    => Utils::validaEmpty($request->aluNivelIngr),
                'aluGradoIngr'    => Utils::validaEmpty($request->aluGradoIngr),
                'aluMatricula'    => $request->aluMatricula,
                'preparatoria_id' => 0,
                'candidato_id'    => $request->candidato_id ? $request->candidato_id : null
            ]);

            if ($request->candidato_id) {
                $candidato = Candidato::findOrFail($request->candidato_id);
                $candidato->update([
                    "candidatoPreinscrito" => "SI",
                ]);
            }

            /* Si el alumno registrado se repite como candidato */
            $nosoymexicano = $request->noSoyMexicano ? $perCurp : $request->input('perCurp');
            DB::update("update candidatos c, personas p set  c.candidatoPreinscrito = 'SI' where c.perCurp = p.perCurp
        and c.perCurp <> 'XEXX010101MNEXXXA8' and c.perCurp <> 'XEXX010101MNEXXXA4' and LENGTH(ltrim(rtrim(c.perCurp))) > 0
        and p.deleted_at is null and p.perCurp = ?", [$nosoymexicano]);




            // * Si existen tutores, se realiza la vinculación a este alumno.

            if ($request->tutores) {
                $tutores = $request->tutores;
                $dataTutores = collect([]);
                foreach ($tutores as $key => $tutor) {
                    $tutor = explode('~', $tutor);

                    $tutNombre = $tutor[0];
                    $tutTelefono = $tutor[1];


                    $tutor = Tutor::where('tutNombre', 'like', '%' . $tutNombre . '%')
                        ->where('tutTelefono', $tutTelefono)->first();
                    if ($tutor) {
                        $dataTutores->push($tutor);
                    }
                }
                MetodosAlumnos::vincularTutores($dataTutores, $alumno);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('preescolar_alumnos/create')->withInput();
        }

        DB::commit(); #TEST.

        //datos para la vista de curso.create --------------------------------

        //OBTENER PERMISO DE USUARIO
        $user = Auth::user();
        $modulo = Modules::where('slug', 'curso')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;


        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();


        $tiposIngreso =  [
            'PI' => 'PRIMER INGRESO',
            // 'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
            //     'EQ' => 'REVALIDACIÓN',
            //     'OY' => 'OYENTE',
            //     'XX' => 'OTRO',
        ];

        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();

        $campus = $request->campus;
        $departamento = $request->departamento;
        $programa = $request->programa;
        $programaData = Programa::where("id", "=", $programa)->first();

        $escuela = null;
        if ($programaData) {
            $escuela = $programaData->escuela->id;
        }


        $candidato = null;
        if ($request->candidato_id) {
            $candidato = Candidato::where("id", "=", $request->candidato_id)->first();
        }


          // Todos  estos datos es para la pantalla de actividades inscritos 
          $ultimoAlunoRegistrado = Alumno::get()->last();
          $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
          $alumno = null;
          $becas = Beca::get();
  
  
  
          return view('preescolar.actividades_inscritos.create', [
              "ultimoAlunoRegistrado" => $ultimoAlunoRegistrado,
              "ubicaciones" => $ubicaciones,
              "alumno" => $alumno,
              "becas" => $becas
          ]);
    }//function store.

    private function generarClave($nivel,$grado)
    {
        $now = Carbon::now();
        $sufijo = sprintf("%04d",$this->nuevoSufijo());
        $añoActual = Str::substr($now->year, -2);

        // dd($nivel.$grado.$añoActual.$sufijo);
        return $grado.$nivel.$añoActual.$sufijo;
    }

    private function nuevoSufijo()
    {
        // // BLOQUEA LA TABLA
        DB::connection()->getpdo()->exec("LOCK TABLES clavepagosufijos WRITE");
        // AUMENTA EL PREFIJO
        DB::update("UPDATE clavepagosufijos SET cpsSufijo = cpsSufijo + 1 WHERE cpsIdentificador = 1");
        // VALIDA SI LLEGA A MIL LO REINICIA
        DB::update("UPDATE clavepagosufijos SET cpsSufijo = cpsSufijo % 10000 WHERE cpsIdentificador = 1");
        // SELECCIONA EL PREFIJO
        $sufijo = DB::table('clavepagosufijos')->first()->cpsSufijo;
        // DESBLOQUEA TABLA
        DB::connection()->getpdo()->exec("UNLOCK TABLES");

		return $sufijo;
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
