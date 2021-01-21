@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h5>Nuevo Militante</h5>
        </div>
        @include('-helpers-.errors')
        <form action="{{ route('militantes.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sample4" name="lider" required>
                    <option selected></option>
                    @php($e = App\Lider::all())
                    @php($a = App\Anio::where('id', '>', 0)->orderby('name', 'DESC')->get())
                    @php($s = App\Seccion::where('id', '>', 0)->orderby('name', 'ASC')->get())
                    @foreach($a as $An)
                            <optgroup label="{{ $An->name }}">
                            @foreach($s as $Se)
                                    @foreach($e as $i)
                                        @if($An->id == $i->colonia->seccion->municipio->distrito->anio_id && $Se->id == $i->colonia->seccion_id)
                                            @if($i->lider == '')
                                                <option value="{{ $i->id }}">{{ $i->name }} {{ $i->apat }} {{ $i->amat }} - {{ $i->colonia->name }} - Sección #{{ $i->colonia->seccion->name }} - {{ $i->colonia->seccion->municipio->name }}<!-- - {{ $i->colonia->seccion->municipio->distrito->name }} - {{ $i->colonia->seccion->municipio->distrito->estado->name }} ({{ $i->colonia->seccion->municipio->distrito->anio->name }}) --></option>
                                            @endif
                                        @endif
                                    @endforeach
                            @endforeach
                            </optgroup>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample4">Lider...</label>
            </div>

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

            @section('BackAction', route('militantes.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    @section('name', '#a-militantes')
    @include('-helpers-.scr_Focus')
@endsection