@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Registrar Municipio</h5>
        @include('-helpers-.errors')
        <form action="{{ route('municipio.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @csrf        

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name') }}" pattern="[A-ZÁ-Úa-zá-ú0-9 ]{1,150}">
                <label class="mdl-textfield__label" for="sample3">Municipio...</label>
            </div>

            @section('BackAction', route('municipio.index'))
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