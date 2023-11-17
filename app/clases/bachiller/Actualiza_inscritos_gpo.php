<?php
namespace App\clases\bachiller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Actualiza_inscritos_gpo
{
	
	public static function total_inscritos() 
	{
		$select = DB::select("SELECT bg.id FROM bachiller_grupos AS bg
        INNER JOIN periodos AS p ON p.id = bg.periodo_id
        WHERE p.perAnio >= 2022
		AND bg.deleted_at IS NULL");

		if(count($select) > 0){
			foreach($select as $value){
				$sp = DB::select("call procBachillerActualizaTotalInscritos(".$value->id.")");
			}
		}
        
	}
	
}