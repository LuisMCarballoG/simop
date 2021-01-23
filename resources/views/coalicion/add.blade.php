@extends('layouts.mdl')

@section('content')

    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Registrar Coalición</h5>
        @include('-helpers-.errors')

        <form action="{{ route('coalicion.store') }}" method="POST" class="mdl-cell mdl-cell--12-col" autocomplete="off">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            @csrf

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name_small" value="{{ old('name_small') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre corto...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre completo...</label>
            </div>

            <div id="input1" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label clonedInput">
                <input type="hidden" name="partido_H" id="partido_H" value="{{ old('partido_H') }}">
                <select class="mdl-textfield__input" name="partido" id="partido"onchange="Assign(this)" required>
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

            @section('BackAction', route('coalicion.index'))
            @include('-helpers-.btn_Back')
            @include('-helpers-.btn_Submit')
        </form>
    </div>

    @section('name', '#a-coalicion')
    @include('-helpers-.scr_Focus')
@endsection

@section('ScriptOnBottom')
    <script type="text/javascript">
        function Assign(x){
            var ElementH = $('#'+x['id']+'_H');
            ElementH.val(x['value']);
        }

        /*
        function DisableOption(){
            var Enableds = '';
            var IdEnableds = '';
            var Flag = true;
            var nu = $('select');
            nu.each(function () {
                if (this['value'] > 0) {
                    if (Flag) {
                        Enableds = Enableds + this['value'];
                        IdEnableds = IdEnableds + this['id'];
                        Flag = false;
                    } else {
                        Enableds = Enableds + ',' + this['value'];
                        IdEnableds = IdEnableds + ',' + this['id'];
                    }
                }
            });

            var EL = Enableds.length;
            var IL = IdEnableds.length;
            for (var i = 0; i < EL; i++){
                var EI = Enableds[i];
                if (EI !== ',') {
                    //console.log('Elemento seleccionado = ' +EI);
                }
            }

            nu.each(function () {
                //console.log(this['id']);
                //var IdSel = $('#'+this['id']).prop('id');
                $('#'+this['id']+' option').each(function (IdSel) {
                    //console.log('El ide actual es: '+IdSel);
                    var TID = this.parentNode['id'];
                    for (var i = 0; i < EL; i++){
                        if (EI !== ',') {
                            var EI = Enableds[i];
                            var II = IdEnableds[i];
                            if (TID === II){
                                if (EI !== this['value']) {
                                    this['disabled'] = false;
                                }else{
                                    this['disabled'] = true;
                                }
                            }else{
                                if (EI !== this['value']) {
                                    this['disabled'] = false;
                                }else{
                                    this['disabled'] = true;
                                }
                            }
                        }
                    }

                });
                //console.log(this['id']);
            });

            //console.log(Enableds);
        }
        */
        $(function() {
            var BA = $('#btnAdd');
            var BD = $('#btnDel');

            var numL = $('.clonedInput').length;
            if (numL === 5) {
                BA.addClass('hidden');
            }

            if (numL === 1) {
                BD.addClass('hidden');
            }
            /**/

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

                if (newNum === 5) {
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
            //BD.addClass('hidden');
        });
    </script>
@endsection