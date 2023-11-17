<?php
namespace App\clases\horarios;

use App\Http\Models\Bachiller\Bachiller_cch_horarios;
use App\Http\Models\Bachiller\Bachiller_horarios;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\Horario;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MetodosHorarios
{
    /**
    * @param fecha formato Y-m-d
    * @param int $periodo
    */
    public static function buscarPorFecha($fecha, $periodo_id = null)
    {
        $dia = Carbon::parse($fecha)->dayOfWeek;

        return Horario::with('aula', 'grupo.plan.programa.escuela')
        ->whereHas('grupo.plan.programa.escuela', static function($query) use ($periodo_id) {
            if($periodo_id) {
                $query->where('periodo_id', $periodo_id);
            }
        })
        ->where('ghDia', $dia);
    }



    /**
    * Creado para GrupoController, método eliminarHorario()
    *
    * @param App\Http\Models\Grupo
    */
    public static function buscarHorariosEquivalentes($horario)
    {
        $grupo = $horario->grupo;
        $equivalentes = $grupo->equivalentes()->get();
        if($equivalentes->isNotEmpty()) {
            return Horario::whereIn('grupo_id', $equivalentes->pluck('id'))
            ->where('ghDia', $horario->ghDia)
            ->where('ghInicio', $horario->ghInicio)
            ->where('ghFinal', $horario->ghFinal)
            ->where('aula_id', $horario->aula_id)->get();
        } else {
            return collect();
        }
    }

    public static function buscarBachillerHorariosEquivalentes($horario)
    {
        $grupo = $horario->bachiller_grupo_merida;
        $equivalentes = $grupo->equivalentes()->get();
        if($equivalentes->isNotEmpty()) {
            return Bachiller_horarios::whereIn('grupo_id', $equivalentes->pluck('id'))
            ->where('ghDia', $horario->ghDia)
            ->where('ghInicio', $horario->ghInicio)
            ->where('ghFinal', $horario->ghFinal)
            ->where('aula_id', $horario->aula_id)->get();
        } else {
            return collect();
        }
    }


    public static function buscarBachillerHorariosEquivalentesChetumal($horario)
    {
        $grupo = $horario->bachiller_grupo_chetumal;
        $equivalentes = $grupo->equivalentes()->get();
        if($equivalentes->isNotEmpty()) {
            return Bachiller_cch_horarios::whereIn('grupo_id', $equivalentes->pluck('id'))
            ->where('ghDia', $horario->ghDia)
            ->where('ghInicio', $horario->ghInicio)
            ->where('ghFinal', $horario->ghFinal)
            ->where('aula_id', $horario->aula_id)->get();
        } else {
            return collect();
        }
    }

}