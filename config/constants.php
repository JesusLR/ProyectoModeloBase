<?php

if (!defined("TIPOS_INGRESO")) {
    define('TIPOS_INGRESO', [
        'NI' => 'NUEVO INGRESO',
        'PI' => 'PRIMER INGRESO',
        'RO' => 'REPETIDOR',
        'RI' => 'REINSCRIPCIÓN',
        'RE' => 'REINGRESO',
        'EQ' => 'REVALIDACIÓN',
        'OY' => 'OYENTE',
        'XX' => 'OTRO',
    ]);
}

if (!defined("TIPOS_INGRESO_PREES_PRI_SEC")) {
    define('TIPOS_INGRESO_PREES_PRI_SEC', [
        // 'NI' => 'NUEVO INGRESO',
        'PI' => 'PRIMER INGRESO',
        // 'RO' => 'REPETIDOR',
        'RI' => 'REINSCRIPCIÓN',
        'RE' => 'REINGRESO'
        // 'EQ' => 'REVALIDACIÓN',
        // 'OY' => 'OYENTE',
        // 'XX' => 'OTRO',
    ]);
}

if (!defined("PLANES_PAGO")) {
    define('PLANES_PAGO', [
        'N' => 'NORMAL - 10 MESES',
        'A' => 'ANTICIPO CRÉDITO',
        'O' => '11 MESES',
        'C' => 'CUATRIMESTRAL',
        // 'D' => '12 MESES',
    ]);
}

if (!defined("ESTADO_CURSO")) {
    define('ESTADO_CURSO', [
        'P' => 'PREINSCRITO',
        'R' => 'REGULAR',
        'C' => 'CONDICIONADO',
        'A' => 'CONDICIONADO 2',
        'B' => 'BAJA',
    ]);
}

if (!defined("TIPOS_BECA")) {
    define('TIPOS_BECA', [
        'S' => 'SEP',
        'C' => 'CONSEJO',
        'H' => 'HERMANOS',
        'E' => 'EMPLEADO',
        'F' => 'FERNANDO PONCE',
        'R' => 'RECOMENDACIÓN',
        'L' => 'LIGA A.S.',
        'X' => 'EXCELENCIA',
        'T' => 'LEALTAD',
    ]);
}

if (!defined("SI_NO")) {
    define('SI_NO', [
        'S' => 'SI',
        'N' => 'NO',
    ]);
}

if (!defined("ESTADO_SOLICITUD")) {
    define('ESTADO_SOLICITUD', [
        'P' => 'PAGADO',
        'N' => 'PENDIENTE PAGO',
        'C' => 'CANCELADO',
    ]);
}

if (!defined("MODO_REGISTRO")) {
    define('MODO_REGISTRO', [
        'E' => 'EFECTIVO',
        'B' => 'BANCO',
    ]);
}

if (!defined("ESTADO_ACUERDO_PLAN")) {
    define("ESTADO_ACUERDO_PLAN", [
        'N' => 'NUEVO O ACTUAL',
        'L' => 'LIQUIDACIÓN',
        'C' => 'CERRADO',
        'X' => 'EXTRAOFICIAL'
    ]);
}

if(!defined("EN_MANTENIMIENTO")) {
    define("EN_MANTENIMIENTO", false);
}
