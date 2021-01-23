<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller as C;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as V;
use Illuminate\Foundation\Auth\RegistersUsers;

    class RegisterController extends C
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        //Descomentar estas lineas al subir al servidor
        //return abort(404);
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return V::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);
    }
}