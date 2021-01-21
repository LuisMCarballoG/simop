@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--2-offset mdl-cell mdl-cell--8-col mdl-grid">
        <h5>Mi perfil</h5>

        @include('-helpers-.errors')

        <form method="POST" action="{{ route('user.MiPerfilUpdate') }}" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre completo...</label>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="email" id="sample-mail" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                <label class="mdl-textfield__label" for="sample-mail">Correo...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="sample-password" name="password">
                <label class="mdl-textfield__label" for="sample-password">Cambiar Contraseña...</label>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="password-confirm" name="password_confirmation">
                <label class="mdl-textfield__label" for="password-confirm">Confirmar Contraseña...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="sample-password-A" name="passwordA" required>
                <label class="mdl-textfield__label" for="sample-password-A">Contraseña actual...</label>
            </div>
            <br>
            <!-- Submit Button -->
            @include('-helpers-.btn_Submit')
        </form>
    </div>
@endsection