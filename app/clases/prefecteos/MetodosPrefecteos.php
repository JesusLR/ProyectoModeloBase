<?php
namespace App\clases\prefecteos;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\Prefecteo;
use App\Http\Models\PrefecteoDetalle;
use App\Http\Models\Horario;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MetodosPrefecteos
{
    /**
    * Devuelve los Prefecteos filtrados desde el request de alguna vista.
    * filtroHoraInicio y filtroHoraFinal, son campos usados en los forms de filtrado.
    *
    * @param Request
    */
    public static function buscarDesdeRequest($request)
    {
        return Prefecteo::with('periodo')
        ->where(static function ($query) use ($request) {
            if($request->periodo_id) {
                $query->where('periodo_id', $request->periodo_id);
            }
            if($request->prefFecha) {
                $query->whereDate('prefFecha', $request->prefFecha);
            }
            if($request->filtroHoraInicio && $request->filtroHoraFinal) {
                $query->whereBetween('prefHoraInicio', [$request->filtroHoraInicio, $request->filtroHoraFinal]);
            }
        });
    }



    /**
    * @param int
    */
    public static function buscarPorPeriodo($periodo_id)
    {
        return Prefecteo::with('periodo')->where('periodo_id', $periodo_id);
    }



    /**
    * Devuelve los PrefecteosDetalles filtrados desde el request de alguna vista.
    * filtroHoraInicio y filtroHoraFinal, son campos usados en los forms de filtrado.
    *
    * @param Request
    */
    public static function buscarDetallesDesdeRequest($request)
    {
        return PrefecteoDetalle::with(['prefecteo', 'grupo.empleado.persona', 'aula', 'programa'])
        ->where(static function($query) use ($request) {
            if($request->prefecteo_id) {
                $query->where('prefecteo_id', $request->prefecteo_id);
            }
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
            }
        })
        ->whereHas('prefecteo', static function($query) use ($request) {
            if($request->prefFecha) {
                $query->whereDate('prefFecha', $request->prefFecha);
            }
            if($request->periodo_id) {
                $query->where('periodo_id', $request->periodo_id);
            }
            if($request->filtroHoraInicio && $request->filtroHoraFinal) {
                $query->whereBetween('prefHoraInicio', [$request->filtroHoraInicio, $request->filtroHoraFinal]);
            }
        })
        ->whereHas('programa', static function($query) use ($request) {
            if($request->escuela_id) {
                $query->where('escuela_id', $request->escuela_id);
            }
        });
    }



    /**
    * Recibe una Collection del Modelo Prefecteo.
    *
    * @param Collection
    */
    public static function buscarDetallesDesdeCollection($prefecteos)
    {
        return PrefecteoDetalle::with(['prefecteo', 'grupo', 'aula', 'programa'])
        ->whereIn('prefecteo_id', $prefecteos->pluck('id'));
    }



    /**
    * @param int $periodo_id
    * @param fecha formato Y-m-d
    */
    public static function crearPorFecha($periodo_id, $fecha): Collection
    {   
        $prefecteos = new Collection;

        // desde 7 a.m. hasta 9 p.m.
        for ($i=7; $i < 22; $i++) { 
            $prefecteo = self::crearPrefecteo($periodo_id, $fecha, $i);
            $prefecteos->push($prefecteo);
        }

        return $prefecteos;
    }



    /**
    * @param int $periodo_id
    * @param fecha formato Y-m-d
    * @param int $horaInicio
    */
    public static function crearPrefecteo($periodo_id, $fecha, $horaInicio): Prefecteo
    {
        try {
            $prefecteo = Prefecteo::create([
                'periodo_id' => $periodo_id,
                'prefFecha' => $fecha,
                'prefHoraInicio' => $horaInicio,
            ]);
        } catch (Exception $e) {
            throw new Exception("No se pudo crear el Prefecteo del {$fecha} de las {$horaInicio}:00 hrs.", 1);
        }
        return $prefecteo;
    }



    /**
    * Cada item de la Collection resultante, es un array listo para crear un PrefecteoDetalle.
    *
    * @param Collection $prefecteos.
    * @param Collection $horarios
    */
    public static function mapearCollectionConHorarios($prefecteos, $horarios): Collection
    {
        return $prefecteos->map(static function($prefecteo) use ($horarios) {
            $horarios_concurrentes = self::filtrarHorariosConcurrentes($prefecteo, $horarios);
            return self::mapearHorariosConModelo($horarios_concurrentes, $prefecteo);
        })->flatten(1); #le quita el primer nivel de agrupación.
    }



    /**
    * Cada item de la Collection resultante, es un array listo para crear un PrefecteoDetalle.
    *
    * @param Collection $horarios
    * @param App\Http\Models\Prefecteo $prefecteo
    */
    public static function mapearHorariosConModelo($horarios, $prefecteo): Collection
    {
        return $horarios->map(static function($horario) use ($prefecteo) {
            return [
                'prefecteo_id' => $prefecteo->id,
                'grupo_id' => $horario->grupo->id,
                'aula_id' => $horario->aula->id,
                'programa_id' => $horario->grupo->plan->programa->id,
                'asistenciaObservaciones' => null,
                'asistenciaEstado' => 'F',
                'prefHora' => null,
                'ghDia' => (int)$horario->ghDia,
                'ghInicio' => (int)$horario->ghInicio,
                'ghFinal' => (int)$horario->ghFinal,
            ];
        });
    }



    /**
    * @param App\Http\Models\Prefecteo $prefecteo
    * @param Collection $horarios
    */
    public static function filtrarHorariosConcurrentes($prefecteo, $horarios): Collection
    {
        return $horarios->where('ghFinal', '>', $prefecteo->prefHoraInicio)
            ->where('ghInicio', '<=', $prefecteo->prefHoraInicio);
    }



    /**
    * Crea varios detalles loopeando en una colección de arreglos
    *
    * @param array $datos
    */
    public static function crearDetallesDesdeCollection($infoCollection) : Collection
    {   
        $detalles = new Collection;
        $infoCollection->each(static function($infoArray) use ($detalles) {
            try {
                $detalle = PrefecteoDetalle::create($infoArray);
            } catch (Exception $e) {
                throw new Exception("Error al crear PrefecteoDetalle.", 1);
            }
            $detalles->push($detalle);
        });

        return $detalles;
    }





}