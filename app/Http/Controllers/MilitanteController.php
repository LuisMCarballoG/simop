<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FechasController as FC;
use Illuminate\Support\Facades\Auth;
use App\Historial;
use App\Militante;
use App\Lider;

class MilitanteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {return abort(404);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('militante.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->master == 'Y' || Auth::user()->crear == 'Y'){
            return view('militante.add');
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->master == 'Y' || Auth::user()->crear == 'Y'){
            $regla = [
                'name' => 'required|string|max:150|min:3',
                'apa' => 'required|string|max:150|min:3',
                'ama' => 'required|string|max:150|min:3',
                'ife' => 'required|string|max:150|min:5',
                'dir' => 'required|string|max:500|min:10',
            ];
            $msg = [
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
            $this->validate($r, $regla, $msg);

            $LidE = Militante::where('name', $r->name)->
            where('apat', $r->apa)->
            where('amat', $r->ama)->
            where('ife', $r->ife)->
            where('lider_id', $r->lider)->get();
            if (count($LidE) > 0){
                return redirect()->route('militantes.create')->with('error', 'Esta persona ya se encuentra registrada.')->withInput();
            }

            $Fi = FC::FechaInstante();
            Militante::create(['lider_id'=>$r->lider,'name'=>$r->name,'apat'=>$r->apa,'amat'=>$r->ama,'ife'=>$r->ife,'dir'=>$r->dir,'created_at'=>$Fi,'updated_at'=>$Fi]);
            $MilId = Militante::where('name', $r->name)->
            where('apat', $r->apa)->
            where('amat', $r->ama)->
            where('ife', $r->ife)->
            where('created_at', $Fi)->
            where('lider_id', $r->lider)->get();
            $Mensaje = 'Militante registrado: <b>'.$r->name.' '.$r->apa.' '.$r->ama.'</b>
                        , con el lider <b>'.$MilId[0]->lider->name.' '.$MilId[0]->lider->amat.' '.$MilId[0]->lider->ama.'</b>;
                         En la colonia: <b>'.$MilId[0]->lider->colonia->name.'</b>. 
                         <a href="'.route('militantes.show', $MilId[0]->id).'">Ver</a>';
            Historial::create(['user_id'=>Auth::user()->id, 'movimiento'=>$Mensaje,'fecha'=>$Fi]);
            return redirect()->route('militantes.index')->with('ok', 'Militante registrado exitosamente.');
        }
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $M = Militante::find($id);
        if (!$M){
            return redirect()->route('militantes.index')->with('error', 'El militante que busca no ha sido encontrado.');
        }
        return view('militante.show')->with('M', $M);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->master == 'Y' || Auth::user()->editar == 'Y'){
            $Mil = Militante::find($id);
            if (!$Mil){
                return redirect()->route('militantes.index')->with('error', 'El militante que busca no ha sido encontrado.');
            }
            return view('militante.edit')->with('M', $Mil);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if (Auth::user()->master == 'Y' || Auth::user()->editar == 'Y'){
            $regla = [
                'name' => 'required|string|max:150|min:3',
                'apa' => 'required|string|max:150|min:3',
                'ama' => 'required|string|max:150|min:3',
                'ife' => 'required|string|max:150|min:5',
                'dir' => 'required|string|max:500|min:10',
            ];
            $msg = [
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
            $this->validate($r, $regla, $msg);

            $Mili = Militante::find($id);
            if ($Mili->lider_id == $r->lider && $Mili->name == $r->name && $Mili->apat == $r->apa && $Mili->amat == $r->ama && $Mili->ife == $r->ife && $Mili->dir == $r->dir){
                return redirect()->route('militantes.edit', $id)->with('error', 'Debe modificar por lo menos un campo para poder actualizar la información.')->withInput();
            }

            $LidE = Militante::where('name', $r->name)->
            where('apat', $r->apa)->
            where('amat', $r->ama)->
            where('ife', $r->ife)->
            where('lider_id', $r->lider)->get();
            if (count($LidE) > 0){
                return redirect()->route('militantes.edit', $id)->with('error', 'Esta persona ya se encuentra registrada.')->withInput();
            }

            $Mensaje = 'Militante actualizado: ';
            if ($Mili->name != $r->name || $Mili->apat != $r->apa || $Mili->amat != $r->ama){
                $Mensaje = $Mensaje.'<b>'.$Mili->name.' '.$Mili->apat.' '.$Mili->amat.'</b> -> <b>'.$r->name.' '.$r->apa.' '.$r->ama.'</b>; ';
                $Mili->name = $r->name;
                $Mili->apat = $r->apa;
                $Mili->amat = $r->ama;
            }else{$Mensaje = $Mensaje.'<b>'.$Mili->name.' '.$Mili->apat.' '.$Mili->amat.'</b>; ';}
            if ($Mili->ife != $r->ife){
                $Mensaje = $Mensaje.'IFE / INE: <b>'.$Mili->ife.'</b> -> <b>'.$r->ife.'</b>; ';
                $Mili->ife = $r->ife;
            }
            if ($Mili->dir != $r->dir){
                $Mensaje = $Mensaje.'Dirección: <b>'.$Mili->dir.'</b> -> <b>'.$r->dir.'</b> ;';
                $Mili->dir = $r->dir;
            }
            if ($Mili->lider_id != $r->lider){
                $L = Lider::find($r->lider);
                $Mensaje = $Mensaje.'Lider: <b>'.$Mili->lider->name.' '.$Mili->lider->apat.' '.$Mili->lider->amat.'</b> -> <b>'.$L->name.' '.$L->apat.' '.$L->amat.'</b>; ';
                $Mili->lider_id = $r->lider;
            }
            $Fi = FC::FechaInstante();
            $Mili->updated_at = $Fi;
            $Mili->save();
            $Mensaje = $Mensaje.'<a href="'.route('militantes.show', $id).'">Ver</a>';
            Historial::create(['user_id'=>Auth::user()->id,'movimiento'=>$Mensaje,'fecha'=>$Fi]);
            return redirect()->route('militantes.index')->with('ok', 'El militante ha sido actualizado exitosamente.');
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->master == 'Y' || Auth::user()->borrar == 'Y'){
            $Mil = Militante::find($id);
            Historial::create(['user_id'=>Auth::user()->id,
                'movimiento'=>'Militante eliminado: <b>'.$Mil->name.' '.$Mil->apat.' '.$Mil->amat.'</b>; Adjunto al lider <b>'.$Mil->lider->name.' '.$Mil->lider->apat.' '.$Mil->lider->amat.'</b>.', 'fecha'=>FC::FechaInstante()]);
            $Mil->delete();
            return redirect()->route('militantes.index')->with('ok', 'El militante ha sido eliminado exitosamente.');
        }
        return abort(404);
    }
}
