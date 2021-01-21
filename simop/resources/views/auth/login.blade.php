@extends('layouts.mp')
@section('content')
    <form class="form-signin col-md-4 col-md-offset-4" method="POST" action="{{ route('login') }}">
        @include('-helpers-.errors')
        @csrf
        <img class="mb-4" src="{{  env('PUB') }}img/SIMOP-G.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
        <label for="inputEmail" class="sr-only">Correo</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Correo" required autofocus name="email" value="{{ old('email') }}">
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="remember-me">Recordar incio de sesión
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

            <a class="btn btn-link mdl-cell mdl-cell--3-offset mdl-cell--3-col" href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
@endsection