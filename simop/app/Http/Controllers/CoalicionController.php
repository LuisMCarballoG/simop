<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FechaController as FC;
use App\Coalicion;
use App\Partido;
use App\Historial;

class CoalicionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $C = Coalicion::all();
        return view('coalicion.index')
            ->with('C', $C)
            ->with('P', Partido::all())
            ->with('CP', count($C));
    }

    public function create()
    {
        $P = Partido::all();
        return view('coalicion.add')
            ->with('CP', count($P))
            ->with('P', $P);
    }

    public function store(Request $r)
    {
        $P = Partido::all();
        $CP = count($P);
        $DIVS = '';
        $FLAG = true;
        $Numeric = 1;
        foreach ($r->all() as $y => $i) {
            if ($y !== '_token' && $y !== 'name_small' && $y !== 'name' && $y !== 'partido_H' && $y !== 'partido'){
                if ($FLAG) {
                    $Numeric += 1;
                    $DIVS = $DIVS . '
                    <div id="input'.$Numeric.'" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label clonedInput">'.
                        '<input type="hidden" name="' . $y . '" id="' . $y . '" value="' . $i . '">';
                    $FLAG = false;
                }else{
                    $DIVS = $DIVS.'<select class="mdl-textfield__input" name="'.$y.'" id="'.$y.'"onchange="Assign(this)" required>';
                    if($CP > 0){
                        $DIVS = $DIVS.'<option disabled value="" selected="true">Seleccione una opción</option>';

                        foreach($P as $i){
                            $DIVS = $DIVS.'<option value="'.$i->id.'">'.$i->name_small.'</option>';
                        }
                    }else{
                        $DIVS = $DIVS.'<option value="">Debe teber registrados un minimo de 2 partidos</option>';
                    }
                    $DIVS = $DIVS.'</select>'.
                        '</div>';
                    $FLAG = true;
                }
            }
        }

        if ($r->name_small === '' || $r->name === ''){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'Todos los campos son obligatorios');
        }

        if (strlen(trim($r->name_small)) < 2 || strlen(trim($r->name)) < 2){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre* y el *Nombre corto* deben tener por lo menos 2 letras');
        }

        if (strlen(trim($r->name_small)) > 150 || strlen(trim($r->name)) > 150){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre* y el *Nombre corto* no deben tener mas de 150 letras');
        }

        $Pex = Partido::where('name_small', $r->name_small)->get();
        if (count($Pex) > 0){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'No puede utilizar el nombre de un partido.');
        }

        $Pex = Partido::where('name', $r->name)->get();
        if (count($Pex) > 0){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'No puede utilizar el nombre de un partido.');
        }

        $Col2 = Coalicion::where('name_small', $r->name_small)->get();
        if (count($Col2) > 0){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre corto* ya se encuentra registrado');
        }

        $Col = Coalicion::where('name', $r->name)->get();
        if (count($Col) > 0){
            return redirect()
                ->route('coalicion.create')
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre* ya se encuentra registrado');
        }

        foreach ($r->all() as $y => $i) {
            if ($y !== '_token' && $y !== 'name_small' && $y !== 'name'){
                $FLAG = true;
                foreach ($r->all() as $y_ => $i_) {
                    if ($y_ !== '_token' && $y_ !== 'name_small' && $y_ !== 'name'){
                        if ($y !== $y_){
                            if (!$FLAG){
                                if ($i === $i_){
                                    return redirect()
                                        ->route('coalicion.create')
                                        ->withInput()
                                        ->with('divs', $DIVS)
                                        ->with('error', 'Un partido solo puede existir una sola vez en la coalición');
                                }
                                $FLAG = true;
                            }else{
                                $FLAG = false;
                            }
                        }
                    }
                }
            }
        }

        $I = FC::Instante();
        Coalicion::create([
            'name'=>$r->name,
            'name_small'=>$r->name_small,
        ]);

        $Id = Coalicion::where('name', $r->name)->where('name_small', $r->name_small)->get();
        $MSG = '';
        if (count($Id) > 0){
            $FLAG = true;
            $MSG = ' <a href="'.route('coalicion.show', $Id[0]->id).'">Ver</a>';
            foreach ($r->all() as $y => $i) {
                if ($y !== '_token' && $y !== 'name_small' && $y !== 'name'){
                    if ($FLAG) {
                        $Id[0]->partidos()->attach($i);
                        $FLAG = false;
                    }else{
                        $FLAG = true;
                    }
                }
            }
        }

        Historial::create([
            'movimiento' => 'Coalicion registrada: <b>'.$r->name.'</b>.'.$MSG,
            'fecha' => $I
        ]);

        return redirect()->route('coalicion.index')->with('ok', 'Coalición registrada exitosamente');
    }

    public function show($id)
    {
        $C = Coalicion::find($id);
        if (!$C){
            return redirect()->route('coalicion.index')->with('error', 'La coalición no ha sido encontrada');
        }
        return view('coalicion.show')
            ->with('C', $C);
    }

    public function edit($id)
    {
        $C = Coalicion::find($id);
        if (!$C){
            return redirect()->route('coalicion.index')->with('error', 'La coalición no ha sido encontrada');
        }
        $P = Partido::all();
        return view('coalicion.edit')
            ->with('C', $C)
            ->with('P', $P)
            ->with('CP', count($P));
    }

    public function update(Request $r, $id)
    {
        $P = Partido::all();
        $CP = count($P);
        $DIVS = '';
        $FLAG = true;
        $Numeric = 1;
        foreach ($r->except('_token', 'name_small', 'name', 'partido_H', 'partido', '_method') as $y => $i) {
            if ($FLAG) {
                $Numeric += 1;
                $DIVS = $DIVS . '
                <div id="input'.$Numeric.'" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label clonedInput">'.
                    '<input type="hidden" name="'.$y.'" id="'.$y.'" value="'.$i.'">';
                $FLAG = false;
            }else{
                $DIVS = $DIVS.'<select class="mdl-textfield__input" name="'.$y.'" id="'.$y.'" onchange="Assign(this)" required>';
                if($CP > 0){
                    $DIVS = $DIVS.'<option disabled value="" selected="true">Seleccione una opción</option>';

                    foreach($P as $i){
                        $DIVS = $DIVS.'<option value="'.$i->id.'">'.$i->name_small.'</option>';
                    }
                }else{
                    $DIVS = $DIVS.'<option value="">Debe teber registrados un minimo de 2 partidos</option>';
                }
                $DIVS = $DIVS.'</select>'.
                    '</div>';
                $FLAG = true;
            }
        }

        if ($r->name_small === '' || $r->name === ''){
            return redirect()
                ->route('coalicion.edit', $id)
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'Todos los campos son obligatorios');
        }

        if (strlen(trim($r->name_small)) < 2 || strlen(trim($r->name)) < 2){
            return redirect()
                ->route('coalicion.edit', $id)
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre* y el *Nombre corto* deben tener por lo menos 2 letras');
        }

        if (strlen(trim($r->name_small)) > 150 || strlen(trim($r->name)) > 150){
            return redirect()
                ->route('coalicion.edit', $id)
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'El *Nombre* y el *Nombre corto* no deben tener mas de 150 letras');
        }

        $Pex = Partido::where('name_small', $r->name_small)->get();
        if (count($Pex) > 0){
            return redirect()
                ->route('coalicion.edit', $id)
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'No puede utilizar el nombre de un partido.');
        }

        $Pex = Partido::where('name', $r->name)->get();
        if (count($Pex) > 0){
            return redirect()
                ->route('coalicion.edit', $id)
                ->with('divs', $DIVS)
                ->withInput()
                ->with('error', 'No puede utilizar el nombre de un partido.');
        }

        $Coalicion = Coalicion::find($id);
        if ($Coalicion->name_small != $r->name_small) {
            $Col2 = Coalicion::where('name_small', $r->name_small)->get();
            if (count($Col2) > 0) {
                return redirect()
                    ->route('coalicion.edit', $id)
                    ->with('divs', $DIVS)
                    ->withInput()
                    ->with('error', 'El *Nombre corto* ya se encuentra registrado');
            }
        }

        if ($Coalicion->name != $r->name) {
            $Col = Coalicion::where('name', $r->name)->get();
            if (count($Col) > 0) {
                return redirect()
                    ->route('coalicion.edit', $id)
                    ->with('divs', $DIVS)
                    ->withInput()
                    ->with('error', 'El *Nombre* ya se encuentra registrado');
            }
        }

        foreach ($r->except('_token', 'name_small', 'name', '_method') as $y => $i) {
            foreach ($Coalicion->partidos as $cp){
                echo $cp->id.'<br>';
                if ($i == $cp->id){
                    return redirect()
                        ->route('coalicion.edit', $id)
                        ->withInput()
                        ->with('divs', $DIVS)
                        ->with('error', 'Un partido solo puede existir una sola vez en la coalición');
                }
            }
            $FLAG = true;
            $FLAG2 = 1;
            foreach ($r->except('_token', 'name_small', 'name', '_method') as $y_ => $i_) {
                if ($y !== $y_){
                    echo $i.' --> '.$i_.'<br>';
                    echo $y.' --> '.$y_.'<br>';
                    if (!$FLAG){
                        echo $i.'==='.$i_;

                        if ($i === $i_){
                            return redirect()
                                ->route('coalicion.edit', $id)
                                ->withInput()
                                ->with('divs', $DIVS)
                                ->with('error', 'Un partido solo puede existir una sola vez en la coalición');
                        }
                        if (count($Coalicion->partidos) > 0) {
                            foreach ($Coalicion->partidos as $item) {
                                if ($item->id == $i_){
                                    return redirect()
                                        ->route('coalicion.edit', $id)
                                        ->withInput()
                                        ->with('divs', $DIVS)
                                        ->with('error', 'Un partido solo puede existir una sola vez en la coalición');
                                }
                            }
                        }
                        $FLAG = true;
                    }else{
                        $FLAG = false;
                    }
                }
                $FLAG2 += 1;
            }
        }


        $I = FC::Instante();
        $Coalicion->update([
            'name'=>$r->name,
            'name_small'=>$r->name_small,
        ]);

        $FLAG = true;
        $MSG = ' <a href="'.route('coalicion.show', $id).'">Ver</a>';
        foreach ($r->except('_token', 'name_small', 'name', '_method') as $y => $i) {
            if ($FLAG) {
                $Coalicion->partidos()->attach($i);
                $FLAG = false;
            }else{
                $FLAG = true;
            }
        }

        Historial::create([
            'movimiento' => 'Coalición actualizada: <b>'.$r->name_small.'</b> ( <b>'.$r->name.'</b> ).'.$MSG,
            'fecha' => $I
        ]);

        return redirect()->route('coalicion.show', $id)->withInput()->with('divs', $DIVS);
    }

    public function destroy($id)
    {
        $C = Coalicion::find($id);
        if($C){
            $C->partidos()->detach();
            Historial::create([
                'movimiento' => 'Coalición <b>'.$C->name_small.'</b> ( <b>'.$C->name.'</b> ) eliminada.',
                'fecha' => FC::Instante()
            ]);
            $C->delete();
            return redirect()->route('coalicion.index')->with('ok', 'La coalición ha sido eliminada');
        }
        return redirect()->route('coalicion.index')->with('error', 'No se ha encontrado la coalición y no ha sido eliminada.');

    }

    public function detach(Request $r)
    {
        Coalicion::find($r->coalicion)->partidos()->detach($r->relacion);
        return back()->with('ok', 'El partido ha sido eliminado de la coalición.');
    }

    public function block(Request $r)
    {
        $P = Coalicion::find($r->partido);
        $P->oculto = 'Y';
        Historial::create([
            'movimiento' => 'La coalición <b> '.$P->name.' ( '.$P->name_small.' )</b> ahora se encuentra oculta.',
            'fecha' => FC::Instante()
        ]);
        $P->save();
        return back();
    }

    public function unblock(Request $r)
    {
        $P = Coalicion::find($r->partido);
        $P->oculto = 'N';
        Historial::create([
            'movimiento' => 'La coalición <b> '.$P->name.' ( '.$P->name_small.' )</b> ahora se encuentra visible.',
            'fecha' => FC::Instante()
        ]);
        $P->save();
        return back();
    }
}