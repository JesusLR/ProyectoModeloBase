<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Helpers\UltimaFechaPago;


class RelDeudoresCursoAnteriorExport implements FromView
{
    private $datos;
    private $fechaActual;
    private $horaActual;
    private $elTitulo;
    private $elMes;
    private $laUbicacion;
    private $ubiClave;
    private $depClave;
    private $elPeriodo;

    /**
     * RelDeudoresCursoAnteriorExport constructor.
     * @param $datos
     * @param $fechaActual
     * @param $horaActual
     * @param $elTitulo
     * @param $elMes
     * @param $laUbicacion
     * @param $ubiClave
     * @param $depClave
     * @param $elPeriodo
     */
    public function __construct($datos, $fechaActual, $horaActual, $elTitulo, $elMes, $laUbicacion, $ubiClave, $depClave, $elPeriodo)
    {
        $this->datos = $datos;
        $this->fechaActual = $fechaActual;
        $this->horaActual = $horaActual;
        $this->elTitulo = $elTitulo;
        $this->elMes = $elMes;
        $this->laUbicacion = $laUbicacion;
        $this->ubiClave = $ubiClave;
        $this->depClave = $depClave;
        $this->elPeriodo = $elPeriodo;
    }


    public function view(): View
    {
      return view('excel.relDeudoresCursoAnteriorExport', [
          'datos' => $this->datos,
          'fechaActual' => $this->fechaActual,
          'horaActual'  =>  $this->horaActual,
          'elTitulo'  =>  $this->elTitulo,
          'elMes'  =>  $this->elMes,
          'laUbicacion'  =>  $this->laUbicacion,
          'ubiClave'  =>  $this->ubiClave,
          'depClave'  =>  $this->depClave,
          'elPeriodo'  =>  $this->elPeriodo,
          'ultimaFechaPago' => UltimaFechaPago::ultimoPago(),
      ]);
    }

}
