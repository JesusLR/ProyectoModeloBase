<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResumenInscritosExport implements FromCollection,ShouldAutoSize
{
    private $datos;

    public function __construct($datos) 
    {
        $this->datos = $datos;
    }

   
    public function collection()
    {
        return $this->datos;
    }

}
