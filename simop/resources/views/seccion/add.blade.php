@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Registrar Sección</h5>
        @include('-helpers-.errors')
        <form action="{{ route('seccion.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @csrf

            <input type="hidden" name="municipio_id" id="municipio_id" value="{{ old('municipio_id') }}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sample5" name="municipio"  required>
                    @php($M = App\Municipio::where('id', '>', 0)->orderby('name', 'ASC')->get())
                    @foreach($M as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Municipio...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" required value="{{ old('name') }}" pattern="[0-9]{1,4}">
                <label class="mdl-textfield__label" for="sample3">Número de la Sección...</label>
            </div>

            @section('BackAction', route('seccion.index'))
            @include('-helpers-.btn_Back')

            @include('-helpers-.btn_Submit')
        </form>
    </div>
    <script type="text/javascript">



        $('#sample5').on('change', function(){
            $('#municipio_id').val($(this).val());
        });

        $(function(){
            $('#sample5').val($('#municipio_id').val());
        });
    </script>

    @section('name', '#a-secciones')
    @include('-helpers-.scr_Focus')
@endsection