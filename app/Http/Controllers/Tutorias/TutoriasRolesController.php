<?php

namespace App\Http\Controllers\Tutorias;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Tutorias\Tutorias_permiso_roles;
use App\Http\Models\Tutorias\Tutorias_permisos;
use App\Http\Models\Tutorias\Tutorias_roles;
use ArrayIterator;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class TutoriasRolesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:tutoriasroles',['except' => ['index', 'list', 'create', 'store', 'edit', 'update', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutorias.roles.show-list');
    }

    public function list()
    {

        $rol = Tutorias_roles::get();


        return DataTables::of($rol)


            ->addColumn('action', function ($rol) {
                $acciones = '';

                $acciones = '<a href="/tutorias_rol/'.$rol->RolID.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
                </a>
                
                <a href="/tutorias_rol/' . $rol->RolID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                    '
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
        $rol_permiso = Tutorias_permisos::get();
        return view('tutorias.roles.create', [
            'rol_permiso' => $rol_permiso
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

        $validator = Validator::make($request->all(),
        [
            'PermisoID' => 'required',
            'Nombre' => 'unique:tutorias_roles,Nombre'

            
        ],
        [
            'Nombre.unique' => "El rol ya existe"
        ]
        );

        if ($validator->fails()) {
            return redirect ()->route('tutorias_rol.create')->withErrors($validator)->withInput();
        }{
            try {

                Tutorias_roles::create([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'Clave' => $request->Clave,
                ]);
        
        
                $PermisoID = $request->PermisoID;
        
        
                // obtener el ultimo ID ingresado 
                $Roles = Tutorias_roles::latest('RolID')->first();
                $RolID = $Roles->RolID;
        
        
        
                $c = count($PermisoID);
        
                for ($i = 0; $i < $c; $i++) {
        
                    $perimiso_roles = array();
                    $perimiso_roles = new Tutorias_permiso_roles();
                    $perimiso_roles['RolID'] = $RolID;
                    $perimiso_roles['PermisoID'] = $PermisoID[$i];
        
                    $perimiso_roles->save();
                }

                alert('Escuela Modelo', 'El rol se ceo con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_rol');
            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_rol.create')->withInput();
            }

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

        $rol_permiso = Tutorias_permisos::get();


        $roles = Tutorias_roles::select()->where('RolID', '=', $id)->first();

        $permisoRoles = Tutorias_permiso_roles::select()->where('RolID', '=', $id)->get();

   
        return view('tutorias.roles.show', [
            'roles' => $roles,
            'rol_permiso' => $rol_permiso,
            'permisoRoles' => $permisoRoles
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

        $rol_permiso = Tutorias_permisos::get();


        $roles = Tutorias_roles::select()->where('RolID', '=', $id)->first();

        $permisoRoles = Tutorias_permiso_roles::select()->where('RolID', '=', $id)->get();


        return view('tutorias.roles.edit',[
            'roles' => $roles,
            'rol_permiso' => $rol_permiso,
            'permisoRoles' => $permisoRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $RolID)
    {
        $validator = Validator::make($request->all(),
        [
            'Nombre' => 'required',
            'Descripcion' => 'required',
            // 'PermisoID' => 'unique:tutorias_permiso_roles,PermisoID'
           
        ]
        );

        if ($validator->fails()) {
            return redirect ()->route('tutorias_rol.edit')->withErrors($validator)->withInput();
        }{
            try {

                $tutorias_rol = Tutorias_roles::where('RolID', '=', $RolID)->firstOrFail();


                $tutorias_rol->update([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'Clave' => $request->Clave,
                ]);
       
        
                $permisoRoles = Tutorias_permiso_roles::select()->where('RolID', '=', $RolID)->get();

                $permisoRol = collect($permisoRoles);
                
                // valores guardados en la base de datos 
                $valoresRemover = $permisoRol->pluck('PermisoID');
                
                // obtiene los valores del input 
                $PermisoID = $request->PermisoID;

                
                foreach ($valoresRemover as $valor) {
                    foreach ($PermisoID as $valor2) {
                        if($valor == $valor2){
                            //echo "coincidencia" . "<br>";
                            $borrar=array_search($valor, $PermisoID);
                            unset($PermisoID[$borrar]);            
                        }   
                    }
                }              
                      
                // return $PermisoID;
                $collection = collect($PermisoID);

                $keysPermisoID = $collection->values();

         
             
                $c = count($PermisoID);
        
                for ($i = 0; $i < $c; $i++) {
        
                    $perimiso_roles = array();
                    $perimiso_roles = new Tutorias_permiso_roles();
                    $perimiso_roles['RolID'] = $RolID;
                    $perimiso_roles['PermisoID'] = $keysPermisoID[$i];
        
                    $perimiso_roles->save();
                }

                alert('Escuela Modelo', 'El rol se actualizo con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_rol');
            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_rol.edit')->withInput();
            }

        }
    }

    public function actulizarEstatus()
    {
        
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
