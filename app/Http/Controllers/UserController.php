<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FechaController as FC;
use App\User;
use App\Historial;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function MiHistorial()
    {
        //return abort(404);
        //return view('user.MiHistorial')->with('i', Historial::where('user_id', Auth::user()->id)->orderby('fecha', 'DESC')->get());
        return view('user.MiHistorial')->with('i', Historial::orderby('fecha', 'DESC')->get());
    }

    public function MiPerfil()
    {
        return view('user.MiPerfil');
    }

    public function MiPerfilUpdate(Request $r, $flag = true)
    {
        $u = User::find(Auth::user()->id);
        if (Hash::check($r->passwordA, $u->password)) {
            $mensaje = 'Cambio de información personal: ';
            if ($r->name == $u->name && $r->email == $u->email && $r->password == '' && $r->password_confirmation == ''){
                return back()->with('error', 'Para poder actualizar su información es necesario que modifique por lo menos un campo.');
            }

            if ($r->name != $u->name){
                $flag = false;
                $R = [
                    'name'          => 'required|string|max:150|min:3',
                ];
                $M = [
                    'name.required' => 'El *Nombre completo* es obligatorio.',
                    'name.string'   => 'El *Nombre completo* no puede estar vacio.',
                    'name.max'      => 'El *Nombre completo* no puede contener más de 150 caracteres.',
                    'name.min'      => 'El *Nombre completo* no puede contener menos de 3 caracteres..',
                ];
                $this->validate($r, $R, $M);
                $u->name = $r->name;
                $mensaje = $mensaje.'Nombre-><b>'.$r->name.'</b>; ';
            }

            if ($r->email != $u->email){
                $flag = false;
                $R = [
                    'email'         => 'required|email|max:150|unique:users',
                ];
                $M = [
                    'email.required'=> 'El *Correo* es obligatorio.',
                    'email.email'   => 'El *Correo* debe ser un correo valido.',
                    'email.max'     => 'El *Correo* solo puede contener 150 caracteres máximo.',
                    'email.unique'  => 'El *Correo* ya se encuentra en uso.',
                ];
                $this->validate($r, $R, $M);
                $u->email = $r->email;
                $mensaje = $mensaje.'Correo-><b>'.$r->email.'</b>; ';
            }

            if ($r->password != '' && $r->password_confirmation != ''){
                $flag = false;
                $R = [
                    'password'          => 'string|min:6|max:150|confirmed',
                ];
                $M = [
                    'password.string'   => 'La *Contraseña* no puede estar vacia.',
                    'password.min'      => 'La *Contraseña* debe contener minimo 6 caracteres.',
                    'password.max'      => 'La *Contraseña* solo puede contener 150 caracteres máximo.',
                    'password.confirmed'=> 'Las contraseñas no coinciden.',
                ];
                $this->validate($r, $R, $M);
                $u->password = Hash::make($r->password);
                $mensaje = $mensaje.'<b>Contraseña</b>; ';
            }

            if ($flag) {
                return back()->with('error', 'Para poder actualizar su información es necesario que modifique por lo menos un campo.');
            }

            $u->save();
            Historial::create([
                'user_id'       => Auth::user()->id,
                'movimiento'    => $mensaje,
                'fecha'         => FC::Instante(),
            ]);
            return redirect()->route('user.MiPerfil')->with('ok', 'Su información ha sido actualizada.');
        }
        return redirect()->route('user.MiPerfil')->with('error', 'La contraseña ingresada es erronea.')->withInput();
    }
}