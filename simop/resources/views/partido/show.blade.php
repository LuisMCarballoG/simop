@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid text-center">
        @include('-helpers-.ok')

        <div class="mdl-cell mdl-cell--12-col">
            <style>
                img{
                    width: 100%;
                    height: auto;
                }
            </style>
            <img src="{{ env('ST').$P->foto }}" alt="Logo">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                {{ $P->name_small }}
                <br>
                {{ $P->name }}
            </div>

            <div>
                <button onclick="DoSome(true)" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-color-text--amber">
                    <i class="material-icons">create</i>
                </button>

                <button onclick="DoSome(false)" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-color-text--red">
                    <i class="material-icons">clear</i>
                </button>
                <form id="F_del" action="{{ route('partido.destroy', $P->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        function DoSome(x){
            if(x) {
                window.location = '{{ route('partido.edit', $P->id) }}'
            }else{
                alertify.confirm('Confirmar acción...', 'Esta a punto de eliminar el partido <b>{{ $P->name }}</b>', function(){$('#F_del').submit();}, '');
            }
        }
    </script>

    @section('name', '#a-partido')
    @include('-helpers-.scr_Focus')
@endsection