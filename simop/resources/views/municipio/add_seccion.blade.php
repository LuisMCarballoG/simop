@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>{{ $m->name }}</h5><h6 style="color: rgba(0,0,0,0.44)">&nbsp;&nbsp; {{ $m->distrito->name }} - {{ $m->distrito->estado->name }} - {{ $m->distrito->anio->name }}</h6>
        @include('-helpers-.errors')
        <form action="{{ route('municipios.StoreSeccion', $m->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <input type="hidden" name="anio_name" value="{{ $m->distrito->anio->name }}">
            <input type="hidden" name="estado" value="{{ $m->distrito->estado->name }}">
            <input type="hidden" name="distrito" value="{{ $m->distrito->name }}">
            <input type="hidden" name="municipio" value="{{ $m->name }}">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required pattern="[0-9]{1,4}" value="{{ old('name') }}">
                <label class="mdl-textfield__label" for="sample3">Número de la sección...</label>
            </div>

            @section('BackAction', route('municipios.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
@section('name', '#a-municipios')
@include('-helpers-.scr_Focus')
@endsection