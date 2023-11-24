<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Portal_configuracion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class BachillerConfiguracionPortal extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bachiller.portal_configuracion.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $portalConfiguracion = Portal_configuracion::select('*')->whereIn('pcClave', [
            'AVANCE_BAC_CME', 'AVANCE_BAC_CVA', 'BOLETA_BAC_CVA', 'BOLETA_BAC_MONTEJO', 'VIEW_HORARIOS_CME', 'VIEW_HORARIOS_CVA', 'VIEW_RECUPERATIVOS_CME', 'VIEW_RECUPERATIVOS_CVA'
        ]);

        return DataTables::of($portalConfiguracion)

        ->filterColumn('portal', function ($query, $keyword) {

            if($keyword == "A" || $keyword == "Al" || $keyword == "Alu" || $keyword == "Alum" || $keyword == "Alumn" || $keyword == "Alumno"){
                $buscar = "A";

                $query->whereRaw("CONCAT(pcPortal) like ?", ["%{$buscar}%"]);
            }else{
                if($keyword == "D" || $keyword == "DO" || $keyword == "DOC" || $keyword == "DOCE" || $keyword == "DOCEN" || $keyword == "DOCENT" || $keyword == "DOCENTE"){
                    $buscar = "D";

                    $query->whereRaw("CONCAT(pcPortal) like ?", ["%{$buscar}%"]);
                }
            }
          
            
        })
        ->addColumn('portal', function ($query) {

            if($query->pcPortal == "A"){
                return "Alumno";
            }else{
                return "Docente";
            }
            
        })

        ->filterColumn('estatus', function ($query, $keyword) {

            if($keyword == "A" || $keyword == "AC" || $keyword == "ACT" || $keyword == "ACTI" || $keyword == "ACTIV" || $keyword == "ACTIVO"){
                $buscar = "A";

                $query->whereRaw("CONCAT(pcEstado) like ?", ["%{$buscar}%"]);
            }else{
                if($keyword == "I" || $keyword == "IN" || $keyword == "INA" || $keyword == "INAC" || $keyword == "INACT" || $keyword == "INACTI" || $keyword == "INACTIV" || $keyword == "INACTIVO"){
                    $buscar = "I";

                    $query->whereRaw("CONCAT(pcEstado) like ?", ["%{$buscar}%"]);
                }
            }

        })
        ->addColumn('estatus', function ($query) {

            if($query->pcEstado == "A")
                return "Activo";
            else
                return "Inactivo";
        })

        ->addColumn('action',function($portalConfiguracion){

            $classsActive = $portalConfiguracion->pcEstado == 'A' ? 'green-text': 'red-text';

            return '<a href="/bachiller-portal-configuracion/toggleactive/'.$portalConfiguracion->id.'" class="button button--icon js-button js-ripple-effect" title="Activar/Inactivar">
                <i class="material-icons '.$classsActive.'">power_settings_new</i>
            </a>';
        }) ->make(true);

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
            return back();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
            return back();
        }
    }



}
