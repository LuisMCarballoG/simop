@extends('layouts.mdl')

@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var BA = $('#btnAdd');
            var BD = $('#btnDel');
            BA.click(function() {
                var num = $('.clonedInput').length;
                var IN = $('#input' + num);
                //var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                var newNum  = num + 1;      // the numeric ID of the new input field being added
                // create the new element via clone(), and manipulate it's ID using newNum value
                var newElem = IN.clone().attr('id', 'input' + newNum);
                // manipulate the name/id values of the input inside the new element
                newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
                // insert the new element after the last "duplicatable" input field
                IN.after(newElem);
                // enable the "remove" button
                BD.attr('disabled','');
                // business rule: you can only add 5 names
                if (newNum === 5)
                    BA.attr('disabled','disabled');
            });

            BD.click(function() {
                var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                $('#input' + num).remove();     // remove the last element
                // enable the "add" button
                BA.attr('disabled','');
                // if only one element remains, disable the "remove" button
                if (num-1 === 1)
                    BD.attr('disabled','disabled');
            });

            BD.attr('disabled','disabled');
        });
    </script>
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
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
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <h5>Agregar Aliados</h5>
        @include('-helpers-.errors')

        <form action="{{ route('coalicion.store') }}" method="POST" class="mdl-cell mdl-cell--12-col" autocomplete="off">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            @csrf

            <div id="input1" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label clonedInput">
                <select class="mdl-textfield__input" name="partido" id="partido" onchange="alertify.success(this+' ');">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre de la coalición...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="name_small" value="{{ old('name_small') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre corto...</label>
            </div>

            @section('BackAction', route('coalicion.index'))
            @include('-helpers-.btn_Back')
            @include('-helpers-.btn_Submit')
        </form>
        <button id="btnAdd">AddOther</button>
        <button id="btnDel">RemoveLast</button>
    </div>

@section('name', '#a-partido')
@include('-helpers-.scr_Focus')
@endsection