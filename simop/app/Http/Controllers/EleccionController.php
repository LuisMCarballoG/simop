<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as R;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FechaController as FC;
use App\Seccion;
use App\Historial;
use App\Partido;
Use App\Eleccion;

class EleccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('eleccion.index');
    }

    public function store(R $r)
    {
        if ($r->partido_h != '' && $r->coalicion_h != '' && $r->partido_h == '0' && $r->coalicion_h == '0'){
            return back()->with('error', 'Debe seleccionar un partido o una coalicion')->with('script', 'E')->withInput();
        }
        if ($r->partido_h != '' && $r->coalicion_h != '' && $r->partido_h != '0' && $r->coalicion_h != '0'){
            return back()->with('error', 'Debe seleccionar un partido o una coalicion')->with('script', 'E')->withInput();
        }

        if ($r->partido_h == '' && $r->coalicion_h == ''){
            return back()->with('error', 'Debe seleccionar un partido o una coalicion')->with('script', 'E')->withInput();
        }

        $R = [
            'total'         => 'required|integer|min:0',
        ];
        $M = [
            'total.required'         => 'El *Tótal* es obligatorio.',
            'total.integer'          => 'El *Tótal* debe ser un número entero.',
            'total.min'              => 'El *Tótal* no puede ser menor a 0.',
        ];
        $this->validate($r, $R, $M);

        $S = Seccion::find($r->secciones_id);
        $P = Partido::find($r->partidos_id);
        $E = Eleccion::where('anio_id', 2018)
        ->where('partido_id', $r->partidos_id)
        ->where('seccion_id', $r->secciones_id)
        ->get();
        if (count($E) > 0){
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Ya se encuentran registrados los votos para el partido  en esta sección.')
            ->with('script', 'E');
        }
        $E2 = Eleccion::where('anio_id', 2018)
        ->where('coalicion_id', $r->coalicion_id)
        ->where('seccion_id', $r->secciones_id)
        ->get();
        if (count($E2) > 0){
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Ya se encuentran registrados los votos para la coalición  en esta sección.')
            ->with('script', 'E');
        }

        $F = FC::Instante();

        $Partido = NULL;
        if ($r->partido_h != '' &&$r->partido_h != '0'){
            $Partido = $r->partido_h;
        }
        $Coalicion = NULL;
        if ($r->coalicion_h != '' &&$r->coalicion_h != '0'){
            $Coalicion = $r->coalicion_h;
        }

        Eleccion::create([
            'anio_id' => 2018,
            'partido_id' => $Partido,
            'coalicion_id' => $Coalicion,
            'seccion_id' => $r->secciones_id,
            'total' => $r->total,
        ]);
        
        if ($r->remember) {
            return redirect()
            ->back()
            ->withInput()
            ->with('ok', 'Votos registrados.')
            ->with('script', 'E');
        }
        return redirect()
        ->route('elecciones.index')
        ->with('ok', 'Votos registrados.');
    }
}
