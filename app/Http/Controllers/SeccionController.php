<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Seccion;
use App\Municipio;
use App\Historial;
use App\Http\Controllers\FechaController as FC;

class SeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('seccion.index');
    }

    public function create()
    {
        return view('seccion.add');
    }

    public function store(Request $r)
    {
        $R = [
            'name' => 'required|integer|max:9999|min:1',
        ];
        $M = [
            'name.required' => 'El *Número de la Sección* es obligatorio.',
            'name.integer'  => 'El *Número de la Sección* debe ser un número entero.',
            'name.min'      => 'El *Número de la Sección* no puede ser menor a 1.',
            'name.max'      => 'El *Número de la Sección* no puede ser mayor a 9999.',
        ];
        $this->validate($r, $R, $M);
        $Se = Seccion::find($r->name);
        if ($Se) {
            return back()->withInput()->with('error', 'La sección ya se encuentra registrada.');
        }
        $Mu = Municipio::find($r->municipio);
        if (!$Mu){
            return back()->withInput()->with('error', 'Seleccione un municipio de la lista.');
        }

        $F = FC::Instante();
        Seccion::create([
            'id'            =>  $r->name,
            'municipio_id' =>  $r->municipio,
            'name'          =>  $r->name,
        ]);

        Historial::create([
            'user_id'   =>  Auth::user()->id,
            'movimiento'=>  'Sección registrada: <b>'.$r->name.'</b>; En el municipio de: <b>'.$Mu->name.'</b>.',
            'fecha'     =>  $F
        ]);
        return redirect()->route('seccion.index')->with('ok', 'La sección ha sido registrada.');
    }

    public function show($id)
    {
        $Sec = Seccion::find($id);
        if (!$Sec){
            return redirect()->route('secciones.index')->with('error', 'La sección no ha sido encontrada.');
        }
        return view('seccion.show')->with('S',$Sec);
    }

    public function edit($id)
    {
        $Sec = Seccion::find($id);
        if (!$Sec){
            return redirect()->route('secciones.index')->with('error', 'La sección no ha sido encontrada.');
        }
        return view('seccion.edit')->with('S',$Sec);
    }

    public function update(Request $r, $id)
    {
        $Sec = Seccion::find($id);
        if ($Sec->name == $r->name && $Sec->municipio_id == $r->municipio){
            return redirect()->route('secciones.edit', $id)->with('error','Debe modificar por lo menos un campo para poder actualizar la información.');
        }
        $regla = [
            'name' => 'required|integer|max:9999|min:1',
        ];
        $msg = [
            'name.required' => 'El *Número de la Sección* es obligatorio.',
            'name.integer' => 'El *Número de la Sección* debe se un número entero.',
            'name.min' => 'El *Número de la Sección* no puede ser menor a 1.',
            'name.max' => 'El *Número de la Sección* no puede ser mayor a 9999.',
        ];
        $this->validate($r, $regla, $msg);
        $Secs = Seccion::where('name', $r->name)->where('municipio_id',$r->municipio)->get();
        if (count($Secs) > 0){
            return redirect()->route('secciones.edit', $id)->withInput()->with('error','Esta sección ya se encuentra registrada.');
        }
        $Fi = FC::FechaInstante();
        $Mensaje = 'Sección actualizada: ';
        if ($Sec->name != $r->name){
            $Mensaje = $Mensaje.'<b>'.$Sec->name.'</b> -> <b>'.$r->name.'</b>; ';
            $Sec->name = $r->name;
        }else{
            $Mensaje = $Mensaje.'<b>'.$Sec->name.'</b>; ';
        }
        if ($Sec->municipio_id != $r->municipio){
            $Munic = Municipio::find($r->municipio);
            $Mensaje = $Mensaje.'Municipio : <b>'.$Sec->municipio->name.'</b> -> <b>'.$Munic->name.'</b>; ';
            $Sec->municipio_id = $r->municipio;
        }
        $Mensaje = $Mensaje.'<a href="'.route('secciones.show', $id).'">Ver</a>';
        $Sec->updated_at = $Fi;
        $Sec->save();
        Historial::create(['user_id'=>Auth::user()->id, 'movimiento'=>$Mensaje, 'fecha'=>$Fi]);
        return redirect()->route('secciones.index')->with('ok', 'La sección ha sido actualizada.');
    }

    public function destroy($id)
    {
            $Sec = Seccion::find($id);
            Historial::create(['user_id'=>Auth::user()->id, 'movimiento'=>'Sección eliminada: <b>'.$Sec->name.'</b>; Perteneciente al municipio de: <b>'.$Sec->municipio->name.'</b>.','fecha'=>FC::FechaInstante()]);
            $Sec->delete();
            return redirect()->route('secciones.index')->with('ok', 'Registro eliminado exitosamente.');
        
    }
}
