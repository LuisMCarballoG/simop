@extends('layouts.mdl')

@section('content')
    @php($CPC = count($C->partidos))
    @php($TCPC = 5-$CPC)

    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid text-center">
        @include('-helpers-.ok')
        @include('-helpers-.error')

        <form method="post" class="mdl-cell mdl-cell--12-col" action="{{ route('coalicion.update', $C->id) }}">
            @csrf
            @method('put')
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name_small" value="{{ old('name_small', $C->name_small) }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre corto</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name', $C->name) }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre completo</label>
            </div>

            @if($TCPC > 0)
                <div id="input1" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label clonedInput">
                    <input type="hidden" name="partido_H" id="partido_H" value="{{ old('partido_H') }}">
                    <select class="mdl-textfield__input" name="partido" id="partido" onchange="Assign(this)">
                        @if($CP > 0)
                            <option disabled value="" selected="true">Seleccione una opción</option>
                            @foreach($P as $i)
                                <option value="{{ $i->id }}">{{ $i->name_small }}</option>
                            @endforeach
                        @else
                            <option value="">Debe teber registrados un minimo de 2 partidos</option>
                        @endif
                    </select>
                </div>


                {!! session('divs') !!}

                @if($TCPC > 1)
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                        <a href="#" id="btnAdd" class="mdl-color-text--green-500">
                            <i class="material-icons">add</i>
                        </a>
                        <div class="mdl-tooltip" for="btnAdd">Agregar Partido</div>

                        &nbsp;

                        <a href="#" id="btnDel" class="mdl-color-text--red">
                            <i class="material-icons">clear</i>
                        </a>
                        <div class="mdl-tooltip" for="btnDel">Eliminar ultimo Partido</div>
                    </div>
                @endif

            @endif

            @include('-helpers-.btn_Submit')

        </form>

        <table class="table table-striped">
            <thead>
            <tr>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody>
                @foreach($C->partidos as $i)
                    <tr>
                        <td>
                            <img id="img_{{ $i->id }}" src="{{ env('ST').$i->foto }}" alt="Logo" width="40" height="40">
                            <div class="mdl-tooltip" data-mdl-for="img_{{ $i->id }}">
                                {{ $i->name }}
                            </div>
                        </td>
                        <td>
                            <a href="#" id="{{ $i->id }}__del" onclick="$('#delete_relacion_{{ $i->id }}').submit();">
                                <i class="material-icons mdl-color-text--red">clear</i>
                            </a>
                            <div class="mdl-tooltip" data-mdl-for="{{ $i->id }}__del">
                                Eliminar de la coalición
                            </div>
                            <form id="delete_relacion_{{ $i->id }}" action="{{ route('coalicion.detach') }}" method="post" class="hidden">
                                @csrf
                                <input type="hidden" name="coalicion" value="{{ $C->id }}">
                                <input type="hidden" name="relacion" value="{{ $i->id }}">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function Assign(x){
            var ElementH = $('#'+x['id']+'_H');
            ElementH.val(x['value']);
        }
        $(function() {
            var BA = $('#btnAdd');
            var BD = $('#btnDel');
            var numL = $('.clonedInput').length;
            if (numL === {{ $TCPC }}) {
                BA.addClass('hidden');
            }

            if (numL === 1) {
                BD.addClass('hidden');
            }

            $('select').each(function () {
                var ElementH = $('#'+this['id']+'_H');
                this['value'] = ElementH.val();
            });

            BA.click(function() {
                var num = $('.clonedInput').length;
                var IN = $('#input' + num);
                var newNum  = num + 1;
                var newElem = IN.clone().prop('id', 'input' + newNum);
                newElem.children(':last').prop('id', 'partido' + newNum).prop('name', 'partido'+newNum);
                newElem.children(':first').prop('id', 'partido'+newNum+'_H').prop('name', 'partido'+newNum+'_H');
                IN.after(newElem);
                BD.removeClass('hidden');
                if (newNum === {{ $TCPC }}) {
                    BA.addClass('hidden');
                }
            });

            BD.click(function() {
                var num = $('.clonedInput').length;
                $('#input' + num).remove();
                BA.removeClass('hidden');
                if (num-1 === 1) {
                    BD.addClass('hidden');
                }
            });
        });
    </script>

    @section('name', '#a-coalicion')
    @include('-helpers-.scr_Focus')
@endsection