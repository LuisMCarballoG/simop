@extends('layouts.mdl')
@section('ScriptOnTop')
    <link type="text/css" rel="stylesheet" href="/grid/public/plugins/chartist-js-develop/dist/chartist.css">
    <script type="text/javascript" rel="script" src="/grid/public/plugins/chartist-js-develop/dist/chartist.js"></script>
    <link type="text/css" rel="stylesheet" href="/grid/public/plugins/jchartfx.7.5.5900/styles/Palettes/jchartfx.palette.css">
    <link type="text/css" rel="stylesheet" href="/grid/public/plugins/j">
@endsection
@section('content')
    <style>
        ul{
            list-style: none;
            padding: 5px;
        }
        ul ul{
            padding-left: 60px;
            border-left: 1px solid rgba(0,0,0,0.4);
        }
        ul ul ul{
            padding-left: 60px;
        }
        ul ul ul ul{
            padding-left: 60px;
        }
        ul ul ul ul ul{
            padding-left: 60px;
        }
        ul ul ul ul ul ul{
            padding-left: 60px;
        }
        ul ul ul ul ul ul ul{
            padding-left: 60px;
        }
    </style>
    @php($Anios = \App\Anio::where('id', '>', '0')->orderby('name', 'DESC')->get())
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <button id="top-general" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('top-general', 'ul-1')">
                <i class="material-icons">expand_less</i>
            </button>
            Desgloce general&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @if(count($Anios) > 0)
                <select name="anio" id="" onclick="" value="{{ old('anio') }}">
                    <option value="" onclick="window.location.href = '{{ route('home') }}'"></option>
                    @foreach($Anios as $A)

                        <option value="{{ $A->name }}" onclick="window.location.href = '{{ route('home.anio',  $A->name) }}'"
                        @if($Ans->name == $A->name)
                            selected
                        @endif
                        >{{ $A->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="mdl-cell mdl-cell--12-col">
            @php($MilitantesRegistrados = 0)
            @php($VotosObtenidos = 0)
            @php($VotosContrarios = 0)
            @if(count($Ans->distritos) > 0)
                @foreach($Ans->distritos as $d)
                    @if(count($d->municipios) > 0)
                        @foreach($d->municipios as $i)
                            @if(count($i->secciones) > 0)
                                @foreach($i->secciones as $S)
                                    @if(count($S->colonias) > 0)
                                        @foreach($S->colonias as $C)
                                            @if($C->lider != '')
                                                @if(count($C->lider->militantes) > 0)
                                                    @php($MilitantesRegistrados = $MilitantesRegistrados+count($C->lider->militantes))
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(count($S->resultados) > 0)
                                        @foreach($S->resultados as $R)
                                            @php($VotosObtenidos = $VotosObtenidos+$R->total)
                                        @endforeach
                                    @endif
                                    @if(count($S->otros) > 0)
                                        @foreach($S->otros as $O)
                                            @php($VotosContrarios = $VotosContrarios+$O->total)
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
            Militantes total: {{ $MilitantesRegistrados }}<br>
            Votos obtenidos: {{ $VotosObtenidos }}<br>
            Votos perdidos: {{ $VotosContrarios }}
            <?php
                $VotosObtYContras = $VotosObtenidos+$VotosContrarios;
                echo '<br>Votos tótales: '.$VotosObtYContras.'; Que son el 100%';

                if ($VotosObtYContras > 0){
                    $VotosObtPorc = (100/$VotosObtYContras)*$VotosObtenidos;
                }else{
                    $VotosObtPorc = 0;
                }
                echo '<br>% obtenidos: '.round($VotosObtPorc, 2).'%';

                if($VotosObtYContras > 0){
                    $VotosContrasPorc = (100/$VotosObtYContras)*$VotosContrarios;
                }else{
                    $VotosContrasPorc = 0;
                }
                echo '<br>% perdidos: '.round($VotosContrasPorc, 2).'%';

                if($VotosObtYContras > 0){
                    $MilitantesPorc = (100/$VotosObtYContras)*$MilitantesRegistrados;
                }else{
                    $MilitantesPorc = 0;
                }
                echo '<br>% esperados: '.round($MilitantesPorc, 2).'%';
            ?>
        </div>


            <ul id="ul-1" class="target mdl-list">
                <script>
                    var XYZC = '';
                    var XYZB = '';

                    var secciones_ul = '';
                    var secciones_b = '';
                </script>



                @foreach($Ans->all() as $A)
                    <script>
                        XYZC = XYZC+'.li-a{{ $A->id }}';
                        XYZB = XYZB+'.A-B{{ $A->id }}';
                    </script>
                    <li  onclick="Fade_InOut('li-a', 'top-general')">Año <b>{{ $A->name }}</b>
                        <button id="A-B{{ $A->id }}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('A-B{{ $A->id }}', 'li-a{{ $A->id }}')">
                            <i class="material-icons">expand_less</i>
                        </button>
                        <ul id="li-a{{ $A->id }}">

                            @if(count($A->distritos) > 0)
                                @foreach($A->distritos as $D)
                                    <li>
                                        <b>{{ $D->name }}</b>
                                        <ul>
                                            @if(count($D->municipios) > 0)
                                                <li>
                                                    @foreach($D->municipios as $M)
                                                        Municipio <b>{{ $M->name }}</b>
                                                        <ul>
                                                            @if(count($M->secciones) > 0)
                                                                @foreach($M->secciones as $S)
                                                                    <li>
                                                                        <script>
                                                                            secciones_ul = secciones_ul + '.ul-seccion-{{ $S->id }}';
                                                                            secciones_b = secciones_b + '.B-seccion-{{ $S->id }}';
                                                                        </script>
                                                                        <b>Sección #{{ $S->name }}</b>
                                                                        <button id="B-seccion-{{ $S->id }}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('B-seccion-{{ $S->id }}', 'ul-seccion-{{ $S->id }}')">
                                                                            <i class="material-icons">expand_less</i>
                                                                        </button>
                                                                        <ul id="ul-seccion-{{ $S->id }}">
                                                                            @if(count($S->colonias) > 0)
                                                                                @foreach($S->colonias as $C)
                                                                                    <li>
                                                                                       
                                                                                        <ul>
                                                                                            <li>
                                                                                                @if($C->lider != '')
                                                                                                    Lider <b>{{ $C->lider->name }} {{ $C->lider->apat }} {{ $C->lider->amat }}</b>
                                                                                                    <ul>

                                                                                                            @if(count($C->lider->militantes) > 0)
                                                                                                                @foreach($C->lider->militantes as $Mi)
                                                                                                                <li class="mdl-color--amber">
                                                                                                                    <b>{{ $Mi->name }} {{ $Mi->apat }} {{ $Mi->amat }}</b>
                                                                                                                </li>
                                                                                                                @endforeach
                                                                                                            @else
                                                                                                            <li>
                                                                                                                No hay militantes para mostrar
                                                                                                            </li>
                                                                                                            @endif

                                                                                                    </ul>
                                                                                                @else
                                                                                                    No hay lider para mostrar
                                                                                                @endif
                                                                                            </li>
                                                                                        </ul>
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li>
                                                                                    No hay colonias para mostrar
                                                                                    <ul>
                                                                                        <li></li>
                                                                                    </ul>
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->resultados) > 0)
                                                                                <li>Resultados
                                                                                    @foreach($S->resultados as $SR)
                                                                                        <ul>
                                                                                            <li>{{ $SR->total }}</li>
                                                                                        </ul>
                                                                                    @endforeach
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->otros) > 0)
                                                                                <li>Otros
                                                                                    @foreach($S->otros as $SO)
                                                                                        <ul>
                                                                                            <li>{{ $SO->total }}</li>
                                                                                        </ul>
                                                                                    @endforeach
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->otros) > 0 && count($S->resultados) > 0)
                                                                                <li class="mdl-color--blue-900 text-center mdl-color-text--white">Tótales (porcentaje por partido)
                                                                                    @foreach($S->resultados as $SR)
                                                                                        @foreach($S->otros as $SO)
                                                                                            @php($_X = $SR->total+$SO->total)
                                                                                            @php($_Y = (100/$_X)*$SR->total)
                                                                                            @php($_Z = (100/$_X)*$SO->total)
                                                                                            <ul>
                                                                                                <li class="mdl-color--green mdl-color-text--white text-center" style="font-family: 'Helvetica', 'Arial', sans-serif">{{ round($_Y, 2) }}% a favor</li>
                                                                                                <li class="mdl-color--red mdl-color-text--white text-center" style="font-family: 'Helvetica', 'Arial', sans-serif">{{ $SO->partido }}
                                                                                                    <br>{{ round($_Z,2) }}% en contra</li>
                                                                                            </ul>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->otros) > 0 && count($S->resultados) > 0)
                                                                                <li class="mdl-color--blue text-center mdl-color-text--white">Tótales (porcentaje general)
                                                                                    @php($_XXX = 0)
                                                                                    @php( $_YYY = 0)
                                                                                    @foreach($S->resultados as $SR)
                                                                                        @php($_XXX += $SR->total)
                                                                                    @endforeach
                                                                                    @foreach($S->otros as $SO)
                                                                                        @php($_YYY += $SO->total)
                                                                                    @endforeach

                                                                                    @php($_X2 = $_XXX + $_YYY)
                                                                                    @php($_Y2 = (100/$_X2)*$_XXX)
                                                                                    @php($_Z2 = (100/$_X2)*$_YYY)
                                                                                    <ul>
                                                                                        <li class="mdl-color--green mdl-color-text--white text-center" style="font-family: 'Helvetica', 'Arial', sans-serif">{{ round($_Y2, 2) }}% a favor</li>
                                                                                        <li class="mdl-color--red mdl-color-text--white text-center" style="font-family: 'Helvetica', 'Arial', sans-serif">{{ round($_Z2,2) }}% en contra</li>
                                                                                    </ul>
                                                                                </li>
                                                                            @endif
                                                                            <li class="mdl-color--blue text-center mdl-color-text--white">Tótales (porcentaje general)
                                                                                @if(count($S->resultados) > 0 && count($S->colonias) > 0)
                                                                                    @php($_XXX2 = 0)
                                                                                    @php( $_YYY2 = 0)
                                                                                    @foreach($S->resultados as $SR)
                                                                                        @php($_XXX2 += $SR->total)
                                                                                    @endforeach
                                                                                    <br>Resultados : {{ $_XXX2 }}<br>

                                                                                    @foreach($S->colonias as $C)
                                                                                        @if($C->lider != '')
                                                                                            @php($_YYY2 += count($C->lider->militantes))
                                                                                        @endif
                                                                                    @endforeach
                                                                                    Esperados: {{ $_YYY2 }} <br>

                                                                                    @if($_YYY2 == 0 && $_XXX2 == 0)
                                                                                        @php($_Y22 = $_XXX2)
                                                                                    @elseif($_XXX2 == 0)
                                                                                        @php($_Y22 = $_YYY2)
                                                                                    @elseif($_YYY2 == 0)
                                                                                        @php($_Y22 = $_YYY2)
                                                                                    @else
                                                                                        @php($_Y22 = (100/$_YYY2)*$_XXX2)
                                                                                    @endif
                                                                                    <ul>
                                                                                        <li class="mdl-color--green mdl-color-text--white text-center" style="font-family: 'Helvetica', 'Arial', sans-serif">
                                                                                            El porcentaje tótal de votantes esperados es de
                                                                                            <br>
                                                                                            {{ round($_Y22, 2) }}%
                                                                                        </li>
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    No hay secciones registradas
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    @endforeach
                                                </li>
                                            @else
                                                <li>
                                                    No hay municipios registrados
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endforeach
            </ul>

    </div>
@section('name', '#a-inicio')
@include('-helpers-.scr_Focus')
<script>
    function Fade_InOut(x, y) {
        var Y = $('#'+y);
        var X = $('#'+x);
        var _X = $('#'+x+' i');
        var a = _X.text();
        if (a === 'expand_less'){
            Y.hide('slow');
            _X.text('expand_more');
        }else{
            Y.show('slow');
            _X.text('expand_less');
        }
    }

    $(function () {
        var sec_ul = secciones_ul.split(".");
        var sec_bu = secciones_b.split(".");
        for (var I = 1; I < sec_ul.length; I++){
            var _X_ = $('#'+sec_bu[I]+' i');
            //$('#'+sec_ul[I]).hide();
            //_X_.text('expand_more');
        }

        var cant = XYZC.split(".");
        var canb = XYZB.split(".");
        for (var i = 1; i < cant.length; i++){
            var _X = $('#'+canb[i]+' i');
            //$('#'+cant[i]).hide('slow');
            //_X.text('expand_more');
        }
    });
</script>
<style>
    .ct-series-a .ct-bar {
        stroke: blue !important;
        stroke-width: 35px!important;
    }
</style>
<div id="Graph-1" class="ct-chart ct-perfect-fourth"></div>
<script>
    new Chartist.Bar('#Graph-1', {
        labels: ['Registrados', 'Obtenidos', 'Perdidos',],
        series: [
            [{{ $MilitantesRegistrados }}, {{ $VotosObtenidos }},  {{ $VotosContrarios }},],
            [{{ $MilitantesRegistrados }}, {{ $VotosObtenidos }},  {{ $VotosContrarios }},]
        ]},
    {
        width: 500,
        height: 500,
        axisY: {
        onlyInteger: true
        },
    }
    );
    $('.ct-series-a.ct-bar').click(function () {
        alert($(this).text());
    });
</script>
@endsection