@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h5>{{ $L->name }}</h5>
            <!--<h6 style="color: rgba(0,0,0,0.44); font-size: 15px;">Sección #{{ $L->colonia->seccion->name }} - {{ $L->colonia->seccion->municipio->name }} - {{ $L->colonia->seccion->municipio->distrito->name }} - {{ $L->colonia->seccion->municipio->distrito->estado->name }} -  ({{ $L->colonia->seccion->municipio->distrito->anio->name }})</h6>-->
        </div>
        @include('-helpers-.errors')
        <form action="{{ route('lideres.update', $L->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <!--input type="hidden" name="anio" value="{{ $L->colonia->seccion->municipio->distrito->anio->id }}"-->
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name', $L->name) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Nombre...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="apa" required value="{{ old('apa', $L->apat) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Paterno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ama" required value="{{ old('ama', $L->amat) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Materno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ife" required value="{{ old('ife', $L->ife) }}" pattern="[A-ZÁ-Ú-a-zá-ú0-9 ]{5,150}">
                <label class="mdl-textfield__label" for="sample3">IFE...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <textarea class="mdl-textfield__input" type="text" rows= "5" id="sample5" name="dir" required minlength="10" maxlength="500">{{ old('dir', $L->dir) }}</textarea>
                <label class="mdl-textfield__label" for="sample5">Dirección...</label>
            </div>

            @section('BackAction', route('lideres.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    @section('name', '#a-lideres')
    @include('-helpers-.scr_Focus')
@endsection