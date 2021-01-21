@extends('layouts.mp')

@section('content')

    <form class="form-signin col-md-4 col-md-offset-4" method="POST" action="{{ route('password.email') }}">
        @include('-helpers-.errors')
        @csrf
        <img class="mb-4" src="{{  env('PUB') }}img/SIMOP-G.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Reestablecer contraseña</h1>
        <label for="inputEmail" class="sr-only">Correo</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Correo" required autofocus name="email" value="{{ old('email') }}">
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Solicitar Cambio</button>

        <a class="btn btn-link mdl-cell mdl-cell--3-offset mdl-cell--3-col" href="{{ route('login') }}">Iniciar sesión</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>

@endsection
