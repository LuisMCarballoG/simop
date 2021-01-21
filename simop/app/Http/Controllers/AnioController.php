<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FechaController as FC;
use App\Anio;
use App\Historial;

class AnioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $A = Anio::all();
        return view('anio.index')
            ->with('A', $A)
            ->with('CA', count($A));
    }

    public function create()
    {
        return view('anio.add');
    }

    public function store(Request $r)
    {
        $A = FC::Anio();
        $R = [
            'name' => 'required|integer|min:1990|max:'.$A.'|unique:anio,id'
        ];
        $M = [
            'name.required' => 'El *Año* es obligatorio.',
            'name.integer' => 'El *Año* debe ser un número entero.',
            'name.min' => 'El *Año* no puede ser menor a 1990.',
            'name.max' => 'El *Año* no puede ser mayor a '.$A.'.',
            'name.unique' => 'El *Año* ya se encuentra registrado.',
        ];
        $this->validate($r, $R, $M);

        $ValAn = ($r->name -2)/3;
        if(!is_int($ValAn)){
            return redirect()->route('anio.create')->with('error', 'El año que intenta registrar es invalido.')->withInput();
        }


        Anio::create([
            'id'=>$r->name,
        ]);

        $Id = Anio::find($r->name);
        $MSG1 = 'Ha ocurrido un error inesperado y no se ha podido registrar el año.';
        $MSG2 = 'error';
        $MSG3 = $MSG1;
        if ($Id){
            $MSG2 = 'ok';
            $MSG3 = 'Año registrado exitosamente.';
            $MSG1 = 'Año registrado: <b>'.$r->name.'</b>. <a href="'.route('anio.show', $Id->id).'">Ver</a>';
        }

        Historial::create([
            'movimiento'=>$MSG1,
            'fecha'=>FC::Instante()
        ]);

        return redirect()->route('anio.index')->with($MSG2, $MSG3);
    }

    public function show($id)
    {
        $A = Anio::find($id);
        if ($A) {
            return view('anio.show')->with('a', $A);
        }
        return redirect()->route('anio.index')->with('error', 'Año no encontrado.');
    }

    public function destroy($id)
    {
        $A = Anio::find($id);
        if (!$A){
            return redirect()->route('anio.index')->with('error', 'No se ha encontrado el año que desea eliminar.');
        }
        $A->delete();
        Historial::create([
            'movimiento'=>'Año eliminado: <b>'.$id.'</b>.',
            'fecha'=>FC::Instante()
        ]);

        return redirect()->route('anio.index')->with('ok', 'Año eliminado exitosamente.');
    }

    public function block(Request $r)
    {
        Anio::find($r->id)->update(['oculto'=>'Y']);
        Historial::create([
            'movimiento' => 'El año <b>'.$r->id.'</b> cambio a oculto.',
            'fecha' => FC::Instante()
        ]);
        return back();
    }

    public function unblock(Request $r)
    {
        Anio::find($r->id)->update(['oculto' => 'N']);
        Historial::create([
            'movimiento' => 'El año <b> '.$r->id.'</b> cambio a visible.',
            'fecha' => FC::Instante()
        ]);
        return back();
    }
}