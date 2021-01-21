@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Editar Municipio</h5>
        @include('-helpers-.errors')
        <form action="{{ route('municipios.update', $M->id) }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @method('PUT')
            @csrf

            <input type="hidden" id="distrito_id" name="distrito_id" value="{{ old('distrito_id', $M->distrito_id) }}">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sample5" name="distrito" required onchange="AsignaDistrito();">
                    @php($A = App\Anio::where('id', '>', 0)->orderby('name', 'DESC')->get())
                    @foreach($A as $i)
                        @foreach($i->distritos as $ii)
                            <option value="{{ $ii->id }}"
                            @if($M->distrito_id == $i->id)
                                selected
                            @endif
                            >{{ $ii->name }} <!--- {{ $ii->estado->name }} -->- {{ $i->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Distrito...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name', $M->name) }}" pattern="[A-ZÁ-Úa-zá-ú0-9 ]{1,150}">
                <label class="mdl-textfield__label" for="sample3">Nombre del municipio...</label>
            </div>

            @section('BackAction', route('municipios.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    <script>
        function AsignaDistrito() {
            $('#distrito_id').val($('#sample5').val());
        }
        $(function () {
            var a = $('#distrito_id');
            var b = $('#sample5');
            var x = a.val();
            var y = b.val();
            if (x.length > 0){
                b.val(x);
            }else{
                a.val(y);
            }
        });
    </script>
@section('name', '#a-municipios')
@include('-helpers-.scr_Focus')
@endsection