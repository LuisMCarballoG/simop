@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h5>Sección #{{ $S->name }}</h5>
            <h6 style="color: rgba(0,0,0,0.44); font-size: 15px;">{{ $S->municipio->name }} - {{ $S->municipio->distrito->name }} - {{ $S->municipio->distrito->estado->name }} - {{ $S->municipio->distrito->anio->name }}</h6>
        </div>
        @include('-helpers-.errors')
        <form action="{{ route('secciones.StoreColonia', $S->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre de la colonia...</label>
            </div>

            @section('BackAction', route('secciones.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    @section('name', '#a-secciones')
    @include('-helpers-.scr_Focus')
@endsection