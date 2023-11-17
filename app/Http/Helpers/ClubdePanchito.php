<?php
namespace App\Http\Helpers;


class ClubdePanchito
{
  public static function esAmigo($cveDepartamento, $cveUsuario)
  {
        $esAmigodelPanchitos = false;

        if($cveDepartamento == "PRE")
        {
            if ($cveUsuario == "REBECAR" || $cveUsuario == "MFERNANDA" ||
                $cveUsuario == "FLOPEZH" || $cveUsuario == "SUSANA" ||
                $cveUsuario == "DIONEDPENICHE" || $cveUsuario == "MAGIVI" ||
                $cveUsuario == "JIMENARIVERO"
                )
            {
                $esAmigodelPanchitos = true;
            }
        }

        if($cveDepartamento == "PRI")
        {
              if ($cveUsuario == "REBECAR" || $cveUsuario == "MFERNANDA" ||
                  $cveUsuario == "FLOPEZH" || $cveUsuario == "SUSANA" ||
                  $cveUsuario == "DIONEDPENICHE" || $cveUsuario == "MCARRILLO" ||
                  $cveUsuario == "JIMENARIVERO" ||
                  $cveUsuario ==  "MARIANAT")
              {
                  $esAmigodelPanchitos = true;
              }
        }

        if($cveDepartamento == "SEC")
        {
              if ($cveUsuario == "REBECAR" || $cveUsuario == "MFERNANDA" ||
                  $cveUsuario == "FLOPEZH" || $cveUsuario == "MARIANAT" ||
                  $cveUsuario == "SUSANA" || $cveUsuario == "MCARRILLO" ||
                  $cveUsuario == "DIONEDPENICHE" ||
                  $cveUsuario == "JIMENARIVERO")
              {
                  $esAmigodelPanchitos = true;
              }
        }

        if($cveDepartamento == "BAC")
        {
              if ($cveUsuario == "REBECAR"  || $cveUsuario == "MFERNANDA" ||
                  $cveUsuario == "FLOPEZH"  || $cveUsuario == "MARIANAT" ||
                  $cveUsuario == "SUSANA" || $cveUsuario == "MCARRILLO" ||
                  $cveUsuario == "DIONEDPENICHE" || $cveUsuario == "HRIVAS"
                  || $cveUsuario == "JPEREIRA"|| $cveUsuario == "JIMENARIVERO" ||
                  $cveUsuario ==  "SRIVERO")
              {
                  $esAmigodelPanchitos = true;
              }
          }



    return $esAmigodelPanchitos;
  }
}
