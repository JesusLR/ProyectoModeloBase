<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RelAlumnosReprobadosExport implements FromView
{
    private $datos;
    private $tipoReporte;
    private $periodo;
    private $perNumero;
    private $perAnio;

    public function __construct($datos, $tipoReporte,$periodo,$perNumero,$perAnio) 
    {
        $this->datos = $datos;
        $this->tipoReporte = $tipoReporte;
        $this->periodo = $periodo;
        $this->perNumero = $perNumero;
        $this->perAnio = $perAnio;
    }

   
    public function view(): View
    {
      return view('excel.relAlumnosReprobadosExport', [
        'datos' => $this->datos,
        'tipoReporte' => $this->tipoReporte,
        'periodo' => $this->periodo,
        'perNumero' => $this->perNumero,
        'perAnio' => $this->perAnio
      ]);
    }

}
