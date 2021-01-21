<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FechaController extends Controller
{
    public static function TimeZoneDate($x)
    {
    	date_default_timezone_set('America/Monterrey');
        $a = new \DateTime();
        $b = $a->format($x);
        return $b;
    }

	public static function Instante()
	{
        $x = self::TimeZoneDate('Y-m-d H:i:s');
        return $x;
    }

    public static function DMA()
    {   
    	date_default_timezone_set('America/Monterrey');
    	$D = [
    		"Domingo",
    		"Lunes",
    		"Martes",
    		"Miercoles",
    		"Jueves",
    		"Viernes",
    		"Sábado"
    	];
		$M = [
			"Enero",
			"Febrero",
			"Marzo",
			"Abril",
			"Mayo",
			"Junio",
			"Julio",
			"Agosto",
			"Septiembre",
			"Octubre",
			"Noviembre",
			"Diciembre"
		];
		return $D[date('w')]." ".date('d')." de ".$M[date('n')-1]. " del ".date('Y') ;
	}

    public static function Anio()
    {
        $x = self::TimeZoneDate('Y');
        return $x;
    }
}