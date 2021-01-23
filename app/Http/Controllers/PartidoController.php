<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FechaController as FC;
use App\Http\Controllers\HelperController as HC;
use App\Partido;
use App\Historial;

class PartidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $P = Partido::all();
        return view('partido.index')
            ->with('P', $P)
            ->with('CP', count($P));
    }

    public function create()
    {
        return view('partido.add');
    }

    public function store(Request $r)
    {
        $R = [
            'name_small'=> 'required|min:2|max:150|unique:partido',
            'name'      => 'required|min:2|max:150|unique:partido',
            'foto'      => 'required|mimes:jpg,jpeg,png,bmp,gif,svg|max:1000000',
        ];
        $M = [
            'name_small.required'   => 'El *Nombre corto* es obligatorio.',
            'name_small.min'        => 'El *Nombre corto* debe tener por lo menos 2 letras.',
            'name_small.max'        => 'El *Nombre corto* no puede tener mas de 150 letras.',
            'name_small.unique'     => 'El *Nombre corto* ya se encuentra registrado.',

            'name.required' => 'El *Nombre completo* es obligatorio.',
            'name.min'      => 'El *Nombre completo* debe tener por lo menos 2 letras.',
            'name.max'      => 'El *Nombre completo* no puede tener mas de 150 letras.',
            'name.unique'   => 'El *Nombre completo* ya se encuentra registrado.',

            //'foto.required' => 'La *Foto* es obligatorio.',
            //'foto.min' => 'La *Foto* debe tener por lo menos 2 letras.',
            //foto.max' => 'La *Foto* no puede tener mas de 150 letras.',
            //'foto.unique' => 'La *Foto* ya se encuentra registrado.',
        ];
        $this->validate($r, $R, $M);

        $I = FC::Instante();
        $MSG = 'Partido registrado exitosamente';
        $file = NULL;

        if ($r->foto != '') {
            $name = HC::str_random();
            $ext = $r->foto->extension();
            $file = $name . '.' . $ext;
            $r->foto->storeAs('public', $file);
            if (!$r->file('foto')->isValid()) {
                $MSG = 'El partido se registro exitosamente, pero hubo un problema al subir la imagen';
            }
        }

        Partido::create([
            'name_small'=>$r->name_small,
            'name'=>$r->name,
            'foto'=>$file
        ]);

        $Id = Partido::where('name_small', $r->name_small)->where('name', $r->name)->where('foto', $file)->get();
        $MSG2 = '';
        if (count($Id) > 0){
            $MSG2 = ' <a href="'.route('partido.show', $Id[0]->id) .'">Ver</a>';
        }

        Historial::create([
            'movimiento' => 'Partido registrado: <b>'.$r->name.'</b>.'.$MSG2,
            'fecha' => $I
        ]);

        return redirect()->route('partido.index')->with('ok', $MSG);
    }

    public function show($id)
    {
        $P = Partido::find($id);
        if (!$P){
            return redirect()->route('partido.index')->with('error', 'El partido que usted busca no ha sido encontrado');
        }
        return view('partido.show')->with('P', $P);
    }

    public function edit($id)
    {
        $P = Partido::find($id);
        if (!$P){
            return redirect()->route('partido.index')->with('error', 'El partido que usted busca no ha sido encontrado');
        }
        return view('partido.edit')->with('P', $P);
    }

    public function update(Request $r, $id)
    {
        $P = Partido::find($id);
        if (!$P){
            return redirect()->route('partido.index')->with('error', 'El partido que busca no ha sido encontrado');
        }
        $x = '';
        $y = '';
        $z = '';
        if ($P->name != $r->name){
            $x = '|unique:partido';
            $z = $z.'De: <b>'.$P->name.'</b>. A: <b>'.$r->name.'</b>. ';
        }
        if ($P->name_small != $r->name_small){
            $y = '|unique:partido';
            $z = $z.'De: <b>'.$P->name.'</b>. A: <b>'.$r->name.'</b>. ';
        }
        $R = [
            'name' => 'required|min:2|max:150'.$x,
            'name_small' => 'required|min:2|max:150'.$y,
            'foto' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,svg|min:1|max:1000000',
        ];
        $M = [
            'name.required' => 'El *Nombre* es obligatorio.',
            'name.min' => 'El *Nombre* debe tener por lo menos 2 letras.',
            'name.max' => 'El *Nombre* no puede tener mas de 150 letras.',
            'name.unique' => 'El *Nombre* ya se encuentra registrado.',

            'name_small.required' => 'El *Nombre corto* es obligatorio.',
            'name_small.min' => 'El *Nombre corto* debe tener por lo menos 2 letras.',
            'name_small.max' => 'El *Nombre corto* no puede tener mas de 150 letras.',
            'name_small.unique' => 'El *Nombre corto* ya se encuentra registrado.',

            //'foto.required' => 'La *Foto* es obligatorio.',
            'foto.min' => 'La *Foto* debe se por lo menos de 1 kilobyte.',
            //foto.max' => 'La *Foto* no puede tener mas de 150 letras.',
            //'foto.unique' => 'La *Foto* ya se encuentra registrado.',
        ];
        $this->validate($r, $R, $M);


        $I = FC::Instante();


        $P->name = $r->name;
        $P->name_small = $r->name_small;
        if ($r->foto != ''){
            Storage::disk('public')->delete($P->foto);
            $name = HC::str_random();
            $ext = $r->foto->extension();
            $file = $name.'.'.$ext;
            $r->foto->storeAs('public', $file);
            $P->foto = $file;
            $z = $z.'Logotipo actualizado.';
        }
        $P->save();

        Historial::create([
            'movimiento' => 'Partido actualizado: '.$z.' <a href="'.route('partido.show', $id).'"></a>',
            'fecha' => $I
        ]);

        $MSG = 'Actualización exitosa';
        if ($r->foto != ''){
            if (!$r->file('foto')->isValid()) {
                $MSG = 'Actualización exitosa, pero hubo un problema al subir la imagen';
            }
        }
        return redirect()->route('partido.show', $id)->with('ok', $MSG);
    }

    public function destroy($id)
    {
        $P = Partido::find($id);
        if (!$P){
            return redirect()->route('partido.index')->with('error', 'El partido que desea eliminar no ha sido encontrado');
        }
        Historial::create([
            'movimiento' => 'El partido <b> '.$P->name.' ( '.$P->name_small.' )</b> ha sido eliminado.',
            'fecha' => FC::Instante()
        ]);
        $P->delete();
        return redirect()->route('partido.index')->with('ok', 'El partido ha sido eliminado');
    }

    public function block(Request $r)
    {
        $P = Partido::find($r->partido);
        $P->oculto = 'Y';
        Historial::create([
            'movimiento' => 'El partido <b> '.$P->name.' ( '.$P->name_small.' )</b> ahora se encuentra oculto.',
            'fecha' => FC::Instante()
        ]);
        $P->save();
        return back();
    }

    public function unblock(Request $r)
    {
        $P = Partido::find($r->partido);
        $P->oculto = 'N';
        Historial::create([
            'movimiento' => 'El partido <b> '.$P->name.' ( '.$P->name_small.' )</b> ahora se encuentra oculto.',
            'fecha' => FC::Instante()
        ]);
        $P->save();
        return back();
    }
}