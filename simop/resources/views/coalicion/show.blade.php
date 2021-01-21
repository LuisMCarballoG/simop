@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid text-center">
        @include('-helpers-.ok')

        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                {{ $C->name_small }}
                <br>
                {{ $C->name }}
            </div>

            @foreach($C->partidos as $i)
                <img id="img_{{ $i->id }}" src="{{ env('ST').$i->foto }}" alt="Logo" width="40" height="40">
                <div class="mdl-tooltip" data-mdl-for="img_{{ $i->id }}">
                    {{ $i->name }}
                </div>
            @endforeach

            <div>
                <br>
                <button onclick="DoSome(true)" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-color-text--amber">
                    <i class="material-icons">create</i>
                </button>

                <button onclick="DoSome(false)" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-color-text--red">
                    <i class="material-icons">clear</i>
                </button>
                <form id="F_del" action="{{ route('coalicion.destroy', $C->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        function DoSome(x){
            if(x) {
                window.location = '{{ route('coalicion.edit', $C->id) }}'
            }else{
                alertify.confirm('Confirmar acción...', 'Esta a punto de eliminar la coalición <b>{{ $C->name }}</b>', function(){$('#F_del').submit();}, '');
            }
        }
    </script>

@section('name', '#a-coalicion')
@include('-helpers-.scr_Focus')
@endsection