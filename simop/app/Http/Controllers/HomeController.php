<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anio;
use App\Eleccion;
use App\Municipio;
use App\Partido;
use App\Coalicion;
use App\Seccion;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $coa = DB::table('coalicion');

        $par = DB::table('partido')
            ->union($coa)
            ->orderBy('id', 'DESC')
            ->get();
        return view('panel.index')
        ->with('A', Anio::where('oculto', 'N')->orderBy('id', 'ASC')->get())
        ->with('P', Partido::where('oculto', 'N')->orderBy('name_small', 'ASC')->get())
        ->with('C', Coalicion::where('oculto', 'N')->orderBy('name_small', 'ASC')->get())
        ->with('Union', $par)
        ->with('Els', Eleccion::orderBy('partido_id', 'DESC')->get());
    }

    public function anio($id)
    {
        $A = Anio::find($id);
        if (!$A) {
            return redirect()->route('home')->with('error', 'El año que busca no ha sido encontrado.');
        }
        return view('panel.show')
        ->with('a', $A)
        ->with('A', Anio::all())
        ->with('E', Eleccion::where('anio_id', $id)->orderBy('partido_id', 'ASC')->get())
        ->with('Sec', Eleccion::where('anio_id', $id)->orderBy('seccion_id', 'ASC')->paginate(100))
        ->with('Mn', Eleccion::select(DB::raw('DISTINCT seccion_id'))->where('anio_id', $id)->orderBy('seccion_id', 'ASC')->get())
        ->with('Pt', Eleccion::select(DB::raw('DISTINCT partido_id'))->where('anio_id', $id)->orderBy('partido_id', 'ASC')->get());
    }

    public function anio_mun($id, $mun)
    {
        $Id_m = 0;
        foreach (Municipio::all() as $i) {
            $x = Self::StrReplace($i->name);
            if ($x == $mun) {
                $Id_m = $i->id;
                break;
            }
        }
        
        if ($Id_m <= 0) {
            return back()
            ->with('error', 'El municipio que busca no ha sido encontrado.');
        }

        $M = Municipio::find($Id_m);
        $A = Anio::find($id);
        if (!$A) {
            return redirect()
            ->route('home')
            ->with('error', 'El año que busca no ha sido encontrado.');
        }
        
        return view('panel.show_mun')
        ->with('a', $A)
        ->with('m', $M)
        ->with('mun', $mun);
    }

    public static function hex(){
         $str = "#";
         for($i = 0 ; $i < 6 ; $i++){
             $randNum = rand(0, 15);
             switch ($randNum) {
                 case 10: $randNum = "A"; 
                 break;
                 case 11: $randNum = "B"; 
                 break;
                 case 12: $randNum = "C"; 
                 break;
                 case 13: $randNum = "D"; 
                 break;
                 case 14: $randNum = "E"; 
                 break;
                 case 15: $randNum = "F"; 
                 break; 
             }
             $str .= $randNum;
         }
         return $str;
    }

    public static function hex2rgba($color, $opacity) {
        $default = 'rgb(0,0,0)';
 
        if(empty($color))
            return $default; 
 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        }elseif( strlen( $color ) == 3 ){
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        }else{
            return $default;
        }
 
        $rgb =  array_map('hexdec', $hex);
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        return $output;
    }

    public static function StrReplace($x){
        $X1 = str_replace(' ', '-', $x);
        $X2 = str_replace('Á', 'A', $X1);
        $X3 = str_replace('É', 'E', $X2);
        $X4 = str_replace('Í', 'I', $X3);
        $X5 = str_replace('Ó', 'O', $X4);
        $X6 = str_replace('Ú', 'U', $X5);
        $X7 = str_replace('Ñ', 'N', $X6);
        return $X7;
    }
}