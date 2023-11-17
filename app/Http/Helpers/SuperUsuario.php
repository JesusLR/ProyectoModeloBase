<?php
namespace App\Http\Helpers;

class SuperUsuario
{
  public static function tieneSuperPoder($cveDepartamento, $cveUsuario)
  {
        $esSuper = false;

        if($cveDepartamento == "PRE")
        {
            if (($cveUsuario == "DESARROLLO.PREESCOLAR")
              ||($cveUsuario == "SCEM.ADMINISTRATIVO"))
            {
                $esSuper = true;
            }
        }

        if($cveDepartamento == "PRI")
        {
              if (($cveUsuario == "DESARROLLO.PRIMARIA")
              ||($cveUsuario == "SCEM.ADMINISTRATIVO") ||($cveUsuario == "ARELYMAR"))
              {
                  $esSuper = true;
              }
        }

        if($cveDepartamento == "SEC")
        {
              if (($cveUsuario == "DESARROLLO.SECUNDARIA")
              ||($cveUsuario == "SCEM.ADMINISTRATIVO") ||($cveUsuario == "ARELYMAR"))
              {
                  $esSuper = true;
              }
        }

        if($cveDepartamento == "BAC")
        {
              if (($cveUsuario == "DESARROLLO.BACHILLER")
              ||($cveUsuario == "SCEM.ADMINISTRATIVO"))
              {
                  $esSuper = true;
              }
        }

        return $esSuper;
  }
}
