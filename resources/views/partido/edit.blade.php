@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Actualizar Partido</h5>
        @include('-helpers-.errors')
        <form action="{{ route('partido.update', $P->id) }}" method="POST" class="mdl-cell mdl-cell--12-col" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name_small" value="{{ old('name_small', $P->name_small) }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre corto</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name', $P->name) }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre del partido</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" accept="image/png, .jpeg, .jpg, image/gif" type="file" id="sample3" name="foto" value="{{ old('foto') }}">
            </div>

            @section('BackAction', route('partido.show', $P->id))
            @include('-helpers-.btn_Back')
            @include('-helpers-.btn_Submit')
        </form>
    </div>

    @section('name', '#a-partido')
    @include('-helpers-.scr_Focus')
@endsection