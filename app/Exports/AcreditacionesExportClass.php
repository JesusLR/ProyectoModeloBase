<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AcreditacionesExportClass implements FromCollection,ShouldAutoSize, WithTitle
{
    private $datos;
    private $nombrehoja;

    public function __construct($datos, $nombrehoja)
    {
        $this->datos = $datos;
        $this->nombrehoja = $nombrehoja;
    }


    public function collection()
    {
        return $this->datos;
    }

    public function title(): string
    {
        return $this->nombrehoja;
    }

}
