<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AcreditacionesExport implements WithMultipleSheets,ShouldAutoSize
{
    use Exportable;

    private $datosParcial1;
    private $datosParcial2;
    private $datosParcial3;
    private $datosOrdinario;

    public function __construct($datosParcial1,$datosParcial2,$datosParcial3,$datosOrdinario)
    {
        $this->datosParcial1 = $datosParcial1;
        $this->datosParcial2 = $datosParcial2;
        $this->datosParcial3 = $datosParcial3;
        $this->datosOrdinario = $datosOrdinario;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AcreditacionesExportClass($this->datosParcial1, "1er Parcial");
        $sheets[] = new AcreditacionesExportClass($this->datosParcial2, "2do Parcial");
        $sheets[] = new AcreditacionesExportClass($this->datosParcial3, "3er Parcial");
        $sheets[] = new AcreditacionesExportClass($this->datosOrdinario, "Ordinario");

        return $sheets;
    }

}
