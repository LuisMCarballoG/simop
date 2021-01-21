@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <h5>{{ $M->name }} {{ $M->apat }} {{ $M->amat }}</h5>
            <h6 style="color: rgba(0,0,0,0.44); font-size: 15px;">{{ $M->lider->name }} {{ $M->lider->apat }} {{ $M->lider->amat }} - {{ $M->lider->colonia->seccion->municipio->name }} - {{ $M->lider->colonia->seccion->municipio->name }} - {{ $M->lider->colonia->seccion->municipio->name }} - {{ $M->lider->colonia->seccion->municipio->distrito->name }} - {{ $M->lider->colonia->seccion->municipio->distrito->estado->name }} - {{ $M->lider->colonia->seccion->municipio->distrito->anio->name }}</h6>
        </div>
        @include('-helpers-.errors')
        <form action="{{ route('militantes.update', $M->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sample4" name="lider" required>
                    @php($e = App\Lider::all())
                    @foreach($e as $i)
                        <option value="{{ $i->id }}"
                        @if($i->id == $M->lider_id)
                            selected
                        @endif
                        >{{ $i->name }} - {{ $i->colonia->name }} - {{ $i->colonia->seccion->name }} - {{ $i->colonia->seccion->municipio->name }} - {{ $i->colonia->seccion->municipio->distrito->name }} - {{ $i->colonia->seccion->municipio->distrito->estado->name }} ({{ $i->colonia->seccion->municipio->distrito->anio->name }})</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample4">Lider...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name', $M->name) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Nombre(s)...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="apa" required value="{{ old('apa', $M->apat) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Paterno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ama" required value="{{ old('ama', $M->amat) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{3,150}">
                <label class="mdl-textfield__label" for="sample3">Apellido Materno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="ife" required value="{{ old('ife', $M->ife) }}" pattern="[A-ZÁ-Ú-a-zá-ú ]{5,150}">
                <label class="mdl-textfield__label" for="sample3">IFE / INE...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <textarea class="mdl-textfield__input" type="text" rows= "5" id="sample5" name="dir" required minlength="10" maxlength="500">{{ old('dir', $M->dir) }}</textarea>
                <label class="mdl-textfield__label" for="sample5">Dirección...</label>
            </div>

            @section('BackAction', route('militantes.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
@endsection