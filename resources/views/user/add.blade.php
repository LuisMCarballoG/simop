@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--2-offset mdl-cell mdl-cell--8-col mdl-grid">
        <h5>Nuevo Usuario</h5>
        @include('-helpers-.errors')
        <form method="POST" action="{{ route('user.store') }}" class="mdl-cell mdl-cell--12-col">
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre completo...</label>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="email" id="sample-mail" name="email" value="{{ old('email') }}" required>
                <label class="mdl-textfield__label" for="sample-mail">Correo...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="sample-password" name="password" value="{{ old('name') }}" required>
                <label class="mdl-textfield__label" for="sample-password">Contraseña...</label>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="password-confirm" name="password_confirmation" required>
                <label class="mdl-textfield__label" for="password-confirm">Confirmar Contraseña...</label>
            </div>

            <!-- Button back  -->
            @section('BackAction', route('user.index'))
            @include('-helpers-.btn_Back')

            <!-- Submit Button -->
            @include('-helpers-.btn_Submit')
        </form>
    </div>
    @section('name', '#a-usuarios')
    @include('-helpers-.scr_Focus')
@endsection