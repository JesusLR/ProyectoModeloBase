<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Portal_configuracion;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Auth;
use Validator;
// use App\Models\User;

class PortalConfiguracionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:usuario', ['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('portal_configuracion.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $portalConfiguracion = Portal_configuracion::select('*');

        return Datatables::of($portalConfiguracion)
        ->addColumn('action',function($portalConfiguracion){

            $classsActive = $portalConfiguracion->pcEstado == 'A' ? 'green-text': 'red-text';

            return '<a href="portal-configuracion/'.$portalConfiguracion->id.'" class="button button--icon js-button js-ripple-effect" title="Ver configuracion">
                <i class="material-icons">visibility</i>
            </a>
            <a href="portal-configuracion/'.$portalConfiguracion->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar configuracion">
                <i class="material-icons">edit</i>
            </a>
            <a href="api/portal-configuracion/toggleactive/'.$portalConfiguracion->id.'" class="button button--icon js-button js-ripple-effect" title="Activar/Inactivar">
                <i class="material-icons '.$classsActive.'">power_settings_new</i>
            </a>';
        }) ->make(true);

        // <form id="delete_'.$portalConfiguracion->id.'" action="portal-configuracion/'.$portalConfiguracion->id.'" method="POST" style="display:inline;">
        //     <input type="hidden" name="_method" value="DELETE">
        //     <input type="hidden" name="_token" value="'.csrf_token().'">
        //     <a href="#" data-id="'.$portalConfiguracion->id.'" class="button button--icon js-button js-ripple-effect confirm-delete">
        //         <i class="material-icons">delete</i>
        //     </a>
        // </form>

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portal_configuracion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'pcClave'      => 'required',
                'pcPortal'     => 'required',
                'pcEstado'     => 'required',

            ]
        );

        if ($validator->fails()) {
            return redirect ('portal-configuracion/create')->withErrors($validator)->withInput();
        } else {
            try {
                Portal_configuracion::create([
                    'pcClave'       => $request->input('pcClave'),
                    'pcPortal'      => $request->input('pcPortal'),
                    'pcDescripcion' => $request->input('pcDescripcion'),
                    'pcEstado'      => $request->input('pcEstado'),
                ]);

                alert('Escuela Modelo', 'La Configuración se ha creado con éxito','success')->showConfirmButton();
                return redirect('portal-configuracion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect('portal-configuracion/create')->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portalConfiguracion = Portal_configuracion::findOrFail($id);
        $portalConfiguracion->pcPortal = $portalConfiguracion->pcPortal == 'D' ? 'Docente': 'Alumno';
        $portalConfiguracion->pcEstado = $portalConfiguracion->pcEstado == 'I' ? 'Inactivo': 'Activo';
        return view('portal_configuracion.show',compact('portalConfiguracion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portalConfiguracion = Portal_configuracion::findOrFail($id);
        return view('portal_configuracion.edit',compact('portalConfiguracion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'pcClave'      => 'required',
                'pcPortal'     => 'required',
                'pcEstado'     => 'required',

            ]
        );

        if ($validator->fails()) {
            return redirect('portal-configuracion/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $portalConfiguracion = Portal_configuracion::findOrFail($id);
                $portalConfiguracion->update(
                    [
                        'pcClave'       => $request->input('pcClave'),
                        'pcPortal'      => $request->input('pcPortal'),
                        'pcDescripcion' => $request->input('pcDescripcion'),
                        'pcEstado'      => $request->input('pcEstado'),
                    ]
                );

                alert('Escuela Modelo', 'La configuración se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect('portal-configuracion');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('portal-configuracion/'.$id.'/edit')->withInput();
            }
        }
    }

    public function toggleActive($id)
    {
        try {
            $portalConfiguracion = Portal_configuracion::findOrFail($id);
            if ($portalConfiguracion->pcEstado == 'A') {
                $portalConfiguracion->update(['pcEstado' => 'I']);
            }elseif ($portalConfiguracion->pcEstado == 'I') {
                $portalConfiguracion->update(['pcEstado' => 'A']);
            }

            alert('Escuela Modelo', 'La configuración se ha actualizado con éxito', 'success')->showConfirmButton();
            return redirect('portal-configuracion');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return redirect('portal-configuracion')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portalConfiguracion = Portal_configuracion::findOrFail($id);
        $portalConfiguracion->delete();
        alert('Escuela Modelo', 'La configuración se ha eliminado con éxito','success')->showConfirmButton();
        return redirect('portal-configuracion');
    }
}