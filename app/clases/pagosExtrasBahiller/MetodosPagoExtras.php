<?php
namespace App\clases\pagosExtrasBahiller; 

use Illuminate\Support\Facades\DB;

class MetodosPagoExtras
{
 
    public static function actualizaEstadoPago($perAnioPago,$aluClave, $semestre, $perNumero, $extraordinario_id){
        
        return DB::select("call procBachillerActualizaEstadoRecuperativo(".$perAnioPago.",
        ".$aluClave.", ".$semestre.", ".$perNumero.", ".$extraordinario_id.")");
    } 

}