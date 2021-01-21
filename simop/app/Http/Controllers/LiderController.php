<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FechaController as FC;
use App\Seccion;

use App\Lider;
use App\Militante;
use App\Historial;
class LiderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('lider.index');
    }

    public function create()
    {
        return view('lider.add');
    }

    public function store(Request $r)
    {
        $R = [
            'name'=> 'required|string|max:150|min:3',
            'apa' => 'required|string|max:150|min:3',
            'ama' => 'required|string|max:150|min:3',
            'ife' => 'required|string|max:150|min:5',
            'dir' => 'required|string|max:500|min:10',
        ];
        $M = [
            'name.required' => 'El *Nombre(s)* es obligatorio.',
            'name.string'   => 'El *Nombre(s)* no puede estar vacio.',
            'name.min'      => 'El *Nombre(s)* debe contener por lo menos 3 caracteres.',
            'name.max'      => 'El *Nombre(s)* no puede contener más de 150 caracteres.',
            'apa.required'  => 'El *Apellido Paterno* es obligatorio.',
            'apa.string'    => 'El *Apellido Paterno* no puede estar vacio.',
            'apa.min'       => 'El *Apellido Paterno* debe contener por lo menos 3 caracteres.',
            'apa.max'       => 'El *Apellido Paterno* no puede contener más de 150 caracteres.',
            'ama.required'  => 'El *Apellido Materno* es obligatorio.',
            'ama.string'    => 'El *Apellido Materno* no puede estar vacio.',
            'ama.min'       => 'El *Apellido Materno* debe contener por lo menos 3 caracteres.',
            'ama.max'       => 'El *Apellido Materno* no puede contener más de 150 caracteres.',
            'ife.required'  => 'El *IFE/INE* es obligatorio.',
            'ife.string'    => 'El *IFE/INE* no puede estar vacio.',
            'ife.min'       => 'El *IFE/INE* debe contener por lo menos 5 caracteres.',
            'ife.max'       => 'El *IFE/INE* no puede contener más de 150 caracteres.',
            'dir.required'  => 'La *Dirección* es obligatoria.',
            'dir.string'    => 'La *Dirección* no puede estar vacia.',
            'dir.min'       => 'La *Dirección* debe contener por lo menos 10 caracteres.',
            'dir.max'       => 'La *Dirección* no puede contener más de 500 caracteres.',
        ];
        $this->validate($r, $R, $M);

        $LidE = Lider::where('name', $r->name)->where('apat', $r->apa)->where('amat', $r->ama)->get();
        if (count($LidE) > 0){
            return back()->withInput()->with('error', 'El lider ya se encuentra registrado.');
        }

        $F = FC::Instante();
        Lider::create([
            'name'=>$r->name,
            'apat'=>$r->apa,
            'amat'=>$r->ama,
            'ife'=>$r->ife,
            'dir'=>$r->dir,
            'created_at'=>$F,
            'updated_at'=>NULL
        ]);

        return redirect()->route('lider.index')->with('ok', 'El lider ha sido registrado con exito.');
    }
    
    public function show($id)
    {
        return abort(404);
        $Lid = Lider::find($id);
        if (!$Lid){
            return redirect()->route('lideres.index')->with('error', 'El lider que busca no ha sido encontrado.');
        }
        return view('lider.show')->with('L', $Lid);
    }

    public function edit($id)
    {
        if (Auth::user()->master == 'Y' || Auth::user()->editar == 'Y'){
            $Lid = Lider::find($id);
            if (!$Lid){
                return redirect()->route('lideres.index')->with('error', 'El lider que busca no ha sido encontrado.');
            }
            return view('lider.edit')->with('L', $Lid);
        }
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->master == 'Y' || Auth::user()->editar == 'Y'){
            $R = [
                'name' => 'required|string|max:150|min:3',
                'apa' => 'required|string|max:150|min:3',
                'ama' => 'required|string|max:150|min:3',
                'ife' => 'required|string|max:150|min:5',
                'dir' => 'required|string|max:500|min:10',
            ];
            $M = [
                'name.required' => 'El *Nombre(s)* es obligatorio.',
                'name.string' => 'El *Nombre(s)* no puede estar vacio.',
                'name.min' => 'El *Nombre(s)* debe contener por lo menos 3 caracteres.',
                'name.max' => 'El *Nombre(s)* no puede contener más de 150 caracteres.',
                'apa.required' => 'El *Apellido Paterno* es obligatorio.',
                'apa.string' => 'El *Apellido Paterno* no puede estar vacio.',
                'apa.min' => 'El *Apellido Paterno* debe contener por lo menos 3 caracteres.',
                'apa.max' => 'El *Apellido Paterno* no puede contener más de 150 caracteres.',
                'ama.required' => 'El *Apellido Materno* es obligatorio.',
                'ama.string' => 'El *Apellido Materno* no puede estar vacio.',
                'ama.min' => 'El *Apellido Materno* debe contener por lo menos 3 caracteres.',
                'ama.max' => 'El *Apellido Materno* no puede contener más de 150 caracteres.',
                'ife.required' => 'El *IFE/INE* es obligatorio.',
                'ife.string' => 'El *IFE/INE* no puede estar vacio.',
                'ife.min' => 'El *IFE/INE* debe contener por lo menos 5 caracteres.',
                'ife.max' => 'El *IFE/INE* no puede contener más de 150 caracteres.',
                'dir.required' => 'La *Dirección* es obligatoria.',
                'dir.string' => 'La *Dirección* no puede estar vacia.',
                'dir.min' => 'La *Dirección* debe contener por lo menos 10 caracteres.',
                'dir.max' => 'La *Dirección* no puede contener más de 500 caracteres.',
            ];
            $this->validate($r, $R, $M);
            $L = Lider::find($id);
            if ($L->name == $r->name && $L->apat == $r->apa && $L->amat == $r->ama && $L->ife == $r->ife && $L->dir == $r->dir){
                return redirect()->route('lideres.edit', $id)->with('error', 'Debe modificar por lo menos un campo para poder actualizar la información.');
            }
            $Le = Lider::where('name', $r->name)->where('apat', $r->apa)->where('amat', $r->ama)->where('ife', $r->ife)->where('anio_id', $r->anio)->get();
            if (count($Le) > 0){
                return redirect()->route('lideres.edit', $id)->with('error', 'El lider ya se encuentra registrado.');
            }
            $F = FC::FechaInstante();
            $Men = 'Lider actualizado: ';
            if ($L->name != $r->name){$Men = $Men.'<b>'.$L->name.'</b> -> <b>'.$r->name.'</b> ;';$L->name = $r->name;}
            if ($L->apat != $r->apa){$Men = $Men.'<b>'.$L->apat.'</b> -> <b>'.$r->apa.'</b> ;';$L->apat = $r->apa;}
            if ($L->amat != $r->ama){$Men = $Men.'<b>'.$L->amat.'</b> -> <b>'.$r->ama.'</b> ;';$L->amat = $r->ama;}
            if ($L->ife != $r->ife){$Men = $Men.'<b>'.$L->ife.'</b> -> <b>'.$r->ife.'</b> ;';$L->ife = $r->ife;}
            if ($L->dir != $r->dir){$Men = $Men.'<b>'.$L->dir.'</b> -> <b>'.$r->dir.'</b> ;';$L->dir = $r->dir;}
            $L->updated_at = $F;
            $L->save();
            Historial::create(['user_id'=>Auth::user()->id, 'movimiento'=>$Men.' <a href="'.route('lideres.show', $id).'">Ver</a>', 'fecha'=>$F]);
            return redirect()->route('lideres.index')->with('ok', 'El lider ha sido actualizado exitosamente.');
        }
        return abort(404);
    }

   
    public function destroy($id)
    {
         if (Auth::user()->master == 'Y' || Auth::user()->borrar == 'Y'){
            $Lid = Lider::find($id);
            Historial::create(['user_id'=>Auth::user()->id,'movimiento'=>'Lider eliminado: <b>'.$Lid->name.' '.$Lid->apat.' '.$Lid->amat.'</b>; Perteneciente a la colonia <b>'.$Lid->colonia->name.'</b>.', 'fecha'=>FC::FechaInstante()]);
            $Lid->delete();
            return redirect()->route('lideres.index')->with('ok', 'El lider ha sido eliminado exitosamente.');
        }
        return abort(404);
    }
}
