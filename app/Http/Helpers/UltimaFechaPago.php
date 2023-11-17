<?php
namespace App\Http\Helpers;

use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Modules;
use App\Http\Models\Pago;
use Akaunting\Money\Money;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Http\Models\Permiso_programa_user;
use Illuminate\Support\Facades\DB;

class UltimaFechaPago
{
  public static function ultimoPago()
  {
    //$registroUltimoPago = Pago::where("pagFormaAplico", "=", "A")->latest()->first();
	$registroUltimoPago = DB::table("view_fecha_ultimo_pago_aplicado")->first();
    $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
    . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
    . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

    return $registroUltimoPago;
  }



}//Utils class.