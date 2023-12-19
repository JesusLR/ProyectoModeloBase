<?php

namespace App\Exports;

use App\Exports\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class BecasExport implements FromView
{
    private $pagos;
    private $aluEstado;
    private $fechaActual;
    private $horaActual;
    private $nombreArchivo;
    private $perAnio;
    private $perNumero;

    public function __construct($pagos, $aluEstado,$fechaActual,$horaActual,$nombreArchivo, $perAnio,$perNumero)
    {
        $this->pagos = $pagos;
        $this->aluEstado = $aluEstado;
        $this->fechaActual = $fechaActual;
        $this->horaActual = $horaActual;
        $this->nombreArchivo = $nombreArchivo;
        $this->perAnio = $perAnio;
        $this->perNumero = $perNumero;
    }


    public function view(): View
    {
      if ($this->nombreArchivo ==  "pdf_becas_campus.xlsx") {
        return view('excel.becasCampusExport', [
          'pagos' => $this->pagos,
          'aluEstado' => $this->aluEstado,
          'fechaActual' => $this->fechaActual,
          'horaActual' => $this->horaActual,
          'nombreArchivo' => $this->nombreArchivo,
          'perAnio' => $this->perAnio,
          'perNumero' => $this->perNumero,
        ]);
      }
      if ($this->nombreArchivo ==  "pdf_becas_carreras.xlsx") {
        return view('excel.becasCarrerasExport', [
          'pagos' => $this->pagos,
          'aluEstado' => $this->aluEstado,
          'fechaActual' => $this->fechaActual,
          'horaActual' => $this->horaActual,
          'nombreArchivo' => $this->nombreArchivo,
          'perAnio' => $this->perAnio,
          'perNumero' => $this->perNumero,
        ]);
      }
      if ($this->nombreArchivo ==  "pdf_becas_escuelas.xlsx") {
        return view('excel.becasEscuelasExport', [
          'pagos' => $this->pagos,
          'aluEstado' => $this->aluEstado,
          'fechaActual' => $this->fechaActual,
          'horaActual' => $this->horaActual,
          'nombreArchivo' => $this->nombreArchivo,
          'perAnio' => $this->perAnio,
          'perNumero' => $this->perNumero,
        ]);
      }

      if ($this->nombreArchivo ==  "pdf_becas_tipo.xlsx") {
        return view('excel.becasBecasTipoExport', [
          'pagos' => $this->pagos,
          'aluEstado' => $this->aluEstado,
          'fechaActual' => $this->fechaActual,
          'horaActual' => $this->horaActual,
          'nombreArchivo' => $this->nombreArchivo,
          'perAnio' => $this->perAnio,
          'perNumero' => $this->perNumero,
        ]);
      }

      if ($this->nombreArchivo ==  "pdf_becas_tipo_agrupado.xlsx") {
        return view('excel.becasBecasTipoAgrupado', [
          'pagos' => $this->pagos,
          'aluEstado' => $this->aluEstado,
          'fechaActual' => $this->fechaActual,
          'horaActual' => $this->horaActual,
          'nombreArchivo' => $this->nombreArchivo,
          'perAnio' => $this->perAnio,
          'perNumero' => $this->perNumero,
        ]);
      }
    }

}
