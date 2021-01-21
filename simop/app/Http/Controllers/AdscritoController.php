<?php

namespace App\Http\Controllers;

use App\Municipio;
use App\Seccion;
use Illuminate\Http\Request as R;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FechaController as FC;
use App\Lider;
use App\Adscrito;
use App\Militante;

class AdscritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('adscrito.index')
        ->with('Lid', Lider::where('id', '>', 0)->orderby('name', 'ASC')->get())
        ->with('Ads', Adscrito::orderby('id', 'ASC')->paginate(100))
        ->with('Sec', Seccion::orderby('name', 'ASC')->paginate(100))
        ->with('Mun', Municipio::orderby('name', 'ASC')->get());
    }

    public function store(R $r)
    {
        $SCR = '<script>
                    $(function() {
                        $("#tb-1").addClass("hidden");
                        $("#form-result").removeClass("hidden");
                    });
                </script>';
        $R = [
            'nom' => 'required|string|min:2|max:150',
            'apa' => 'required|string|min:2|max:150',
            'ama' => 'required|string|min:2|max:150',
            'ife' => 'required|string|min:2|max:150',
            'dir' => 'required|string|min:2|max:500',
        ];
        $M = [
            'nom.required' => 'El *Nombre* es obligatorio.'.$SCR,
            'nom.string'   => 'El *Nombre* debe ser una cadena de texto.'.$SCR,
            'nom.min'      => 'El *Nombre* no puede ser menor 2 letras.'.$SCR,
            'nom.max'      => 'El *Nombre* no puede ser mayor a 150 letras.'.$SCR,
            'apa.required' => 'El *Apellido Paterno* es obligatoria.'.$SCR,
            'apa.string'   => 'El *Apellido Paterno* debe ser una cadena de texto..'.$SCR,
            'apa.min'      => 'El *Apellido Paterno* no puede ser menor 2 letras.'.$SCR,
            'apa.max'      => 'El *Apellido Paterno* no puede ser mayor a 150 letras.'.$SCR,
            'ama.required' => 'El *Apellido Materno* es obligatorio.'.$SCR,
            'ama.string'   => 'El *Apellido Materno* debe ser una cadena de texto.'.$SCR,
            'ama.min'      => 'El *Apellido Materno* no puede ser menor a 2 letras.'.$SCR,
            'ama.max'      => 'El *Apellido Materno* no puede ser mayor a 150 letras.'.$SCR,
            'ife.required' => 'El *IFE / INE* es obligatorio.'.$SCR,
            'ife.string'   => 'El *IFE / INE* debe ser una cadena de texto.'.$SCR,
            'ife.min'      => 'El *IFE / INE* no puede ser menor a 2 letras.'.$SCR,
            'ife.max'      => 'El *IFE / INE* no puede ser mayor a 150 letras.'.$SCR,
            'dir.required' => 'La *Dirección* es obligatoria.'.$SCR,
            'dir.string'   => 'La *Dirección* debe ser una cadena de texto.'.$SCR,
            'dir.min'      => 'La *Dirección* no puede ser menor a 2 letras.'.$SCR,
            'dir.max'      => 'La *Dirección* no puede ser mayor a 500 letras.'.$SCR,
        ];
        $this->validate($r, $R, $M);

    
        $L = Lider::find($r->lideres_id);
        if (!$L) {
            return back()
            ->withInput()
            ->with('error', 'Por favor seleccione un Lider de la lista.')
            ->with('script', 'E');
        }

        $S = Seccion::find($r->secciones_id);
        if (!$S) {
            return back()
            ->withInput()
            ->with('error', 'Por favor seleccione una Sección de la lista.')
            ->with('script', 'E');
        }

        $Mi = Militante::where('ife', $r->ife)->get();
        if (count($Mi) > 0) {
            return back()
            ->withInput()
            ->with('error', 'El *IFE / INE* ya se encuentra registrado.')
            ->with('script', 'E');
        }

        $M = Militante::where('name', $r->nom)->where('apat', $r->apa)->where('amat', $r->ama)->get();
        if (count($M) > 0) {
            return back()
            ->withInput()
            ->with('error', 'El *Militante* ya se encuentra registrado.')
            ->with('script', 'E');
        }

        Militante::create([
            'name'  =>  $r->nom,
            'apat'  =>  $r->apa,
            'amat'  =>  $r->ama,
            'ife'   =>  $r->ife,
            'dir'   =>  $r->dir,
            'created_at' => FC::Instante()
        ]);

        $M = Militante::where('name', $r->nom)->where('apat', $r->apa)->where('amat', $r->ama)->get();
            
        Adscrito::create([
            'anio_id'      => 2018,
            'seccion_id'  => $S->name,
            'militante_id' => $M[0]->id,
            'lider_id'    => $L->id,
        ]);
            
        if ($r->remember) {
            return back()
            ->withInput($r->except('nom', 'apa', 'ama', 'ife', 'dir'))
            ->with('ok', 'El militante: '.$r->nom.' '.$r->apa.' '.$r->ama.', ha sido registrado en la sección '.$S->name.' en el municipio de '.$S->municipio->name.'. Reclultado por: '.$L->name.' '.$L->apat.' '.$L->amat.'.')
            ->with('script', 'E');
        }
        return back()
        ->with('ok', 'El militante: '.$r->nom.' '.$r->apa.' '.$r->ama.', de la sección '.$S->name.' en el municipio de '.$S->municipio->name.'. Reclultado por: '.$L->name.' '.$L->apat.' '.$L->amat.'.');
    }
}