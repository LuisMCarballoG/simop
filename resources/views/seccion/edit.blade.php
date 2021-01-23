@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Editar la Sección</h5>
        @include('-helpers-.errors')
        <form action="{{ route('secciones.update', $S->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <input type="hidden" name="municipio_id" id="municipio_id" value="{{ old('municipio_id', $S->municipio_id) }}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sample5" name="municipio" required onchange="AsignaMunicipio()">
                    @php($A = App\Municipio::where('id', '>', 0)->orderby('name', 'DESC')->get())
                    @foreach($A as $i)
                        <option value="{{ $i->id }}"
                                @if($S->municipio_id == $i->id)
                                selected
                                @endif
                        >{{ $i->name }} - {{ $i->distrito->name }} - {{ $i->distrito->estado->name }} - {{ $i->distrito->anio->name }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Municipio...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name', $S->name) }}" pattern="[A-ZÁ-Úa-zá-ú0-9 ]{1,150}">
                <label class="mdl-textfield__label" for="sample3">Número de la Sección...</label>
            </div>

            @section('BackAction', route('secciones.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
@section('name', '#a-secciones')
@include('-helpers-.scr_Focus')
<script>
    function AsignaMunicipio() {
        $('#municipio_id').val($('#sample5').val());
    }
    $(function () {
        var i = $('#municipio_id');
        var x = $('#sample5');
        var y = i.val();
        if (y.length > 0){
            x.val(i.val());
        }else{
            i.val(x.val());
        }
    });
</script>
@endsection