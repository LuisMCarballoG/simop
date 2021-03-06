@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h5>Nuevo Activista</h5>
        </div>
        @include('-helpers-.errors')
        <form action="{{ route('lider.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name') }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Nombre(s)...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="apa" required value="{{ old('apa') }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Paterno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ama" required value="{{ old('ama') }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Materno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ife" required value="{{ old('ife') }}" pattern="[A-ZÁ-Ú-a-zá-ú0-9 ]{5,150}">
                <label class="mdl-textfield__label" for="sample3">IFE / INE...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <textarea class="mdl-textfield__input" type="text" rows= "5" id="sample5" name="dir" required minlength="10" maxlength="500">{{ old('dir') }}</textarea>
                <label class="mdl-textfield__label" for="sample5">Dirección...</label>
            </div>

            @section('BackAction', route('lider.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    @section('name', '#a-lideres')
    @include('-helpers-.scr_Focus')
@endsection