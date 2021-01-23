<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FechaController as FC;
use App\Municipio;
use App\Historial;

class MunicipioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $M = Municipio::orderBy('name', 'ASC')->get();
        return view('municipio.index')
            ->with('M', $M)
            ->with('CM', count($M));
    }

    public function create()
    {
        return view('municipio.add');
    }

    public function store(Request $r)
    {
        $R = [
            'name' => 'required|string|max:150|min:3|unique:municipio',
        ];
        $M = [
            'name.required' => 'El *Municipio* es obligatorio.',
            'name.string' => 'El *Municipio* no puede estar vacio.',
            'name.min' => 'El *Municipio* debe contener por lo menos 3 caracteres.',
            'name.max' => 'El *Municipio* no puede contener más de 150 caracteres.',
        ];
        $this->validate($r, $R, $M);

        $F = FC::Instante();
        Municipio::create([
            'name'=>$r->name,
        ]);

        $Id = Municipio::where('name', $r->name)->get();
        Historial::create([
            'user_id'=>Auth::user()->id,
            'movimiento'=>'Municipio registrado: <b>'.$r->name.'</b>;. <a href="'.route('municipio.show', $Id[0]->id).'">Ver</a>',
            'fecha'=>$F
        ]);
        return redirect()->route('municipio.index')->with('ok', 'Municipio registrado exitosamente.');
    }

    public function show($id)
    {
        return abort(404);
        $Mun = Municipio::find($id);
        if ($Mun){
            return view('municipio.show')->with('m', $Mun);
        }
        return redirect()->route('municipio.index')->with('error', 'El municipio no ha sido encontrado');
    }

    public function edit($id)
    {
        
            $M = Municipio::find($id);
            if (!$M){
                return redirect()->route('municipio.index')->with('error', 'El municipio que busca no ha sido encontado');
            }
            return view('municipio.edit')->with('M', $M);
        
        return abort(404);
    }

    public function update(Request $request, $id)
    {
            $M = Municipio::find($id);
            if ($M->name == $r->name){
                return redirect()->route('municipio.edit', $id)->withInput()->with('error', 'Debe modificar por lo menos un campo para poder actualizar la información.');
            }
            $regla = [
                'name' => 'required|string|max:150|min:3',
            ];
            $msg = [
                'name.required' => 'El *Municipio* es obligatorio.',
                'name.string' => 'El *Municipio* no puede estar vacio.',
                'name.min' => 'El *Municipio* debe contener por lo menos 3 caracteres.',
                'name.max' => 'El *Municipio* no puede contener más de 150 caracteres.',
            ];
            $this->validate($r, $regla, $msg);
            $Mun = Municipio::where('name', $r->name)->get();
            if (count($Mun) > 0){
                return redirect()->route('municipio.edit', $id)->withInput()->with('error', 'El municipio ya se encuentra registrado.');
            }
            $Fi = FC::Instante();
            $Movimiento = 'Municipio actualizado: ';
            if ($M->name != $r->name){
                $Movimiento = $Movimiento.'<b>'.$M->name.'</b> -> <b>'.$r->name.'</b>; ';
            }else{
                $Movimiento = $Movimiento.'<b>'.$M->name.'</b>; ';
            }
            
            Historial::create([
                'user_id'=>Auth::user()->id,
                'movimiento'=>$Movimiento.'<a href="'.route('municipio.show', $M->id).'">Ver</a>',
                'fecha'=>$Fi
            ]);            
            $M->name = $r->name;
            $M->updated_at = $Fi;
            $M->save();
            return redirect()->route('municipio.index')->with('ok', 'Municipio actualizado exitosamente.');
        
    }

    public function destroy($id)
    {
            $M = Municipio::find($id);
            Historial::create([
                'user_id'=>Auth::user()->id,
                'movimiento'=>'Municipio eliminado: <b>'.$M->name.'</b>.',
                'fecha'=>FC::Instante()]);
            $M->delete();
            return redirect()->route('municipio.index')->with('ok', 'Municipio eliminado exitosamente.');
       
    }

    /**
    public function NuevaSeccion($id){
        if (Auth::user()->master == 'Y' || Auth::user()->crear == 'Y') {
            $M = Municipio::find($id);
            if(!$M){
                return redirect()->route('municipio.index')->with('error', 'No se ha encontrado el municipio.');
            }
            return view('municipio.add_seccion')->with('m', $M);
        }
        return abort(404);
    }

    public function StoreSeccion(Request $r, $id){
        if (Auth::user()->master == 'Y' || Auth::user()->crear == 'Y') {
            $regla = [
                'name' => 'required|integer|min:1|max:9999',
            ];
            $msg = [
                'name.required' => 'La *Sección* es obligatoria.',
                'name.integer' => 'La *Sección* debe ser un número entero.',
                'name.min' => 'La *Sección* no puede ser menor a 1.',
                'name.max' => 'La *Sección* no puede ser mayor a 9999.',
            ];
            $this->validate($r, $regla, $msg);
            $ExSecc = Seccion::where('name', $r->name)->where('municipio_id', $id)->get();
            if (count($ExSecc) > 0){
                return redirect()->route('municipio.seccion', $id)->with('error', 'La sección ya se encuentra registrada.');
            }
            $Fi = FC::FechaInstante();
            $d = new Seccion();
            $d->municipio_id = $id;
            $d->name = $r->name;
            $d->created_at = $Fi;
            $d->updated_at = $Fi;
            $d->save();
            $IdSeccion = Seccion::where('municipio_id', $id)->where('name', $r->name)->where('created_at', $Fi)->get();
            $Mensaje = 'Sección registrada: <b>'.$r->name.'</b>; En el municipio de: <b>'.$r->municipio.'</b>. <a href="'.route('secciones.show', $IdSeccion[0]->id).'">Ver</a>';
            Historial::create(['user_id'=>Auth::user()->id,'movimiento'=>$Mensaje, 'fecha'=>$Fi]);
            return redirect()->route('municipio.index')->with('ok', 'Seccion registrada y asignada exitosamente a '.$r->municipio);
        }
        return abort(404);
    }  
    */
}
