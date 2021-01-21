@extends('layouts.mdl')
@section('content')
    @php($MilitantesRegistrados = 0)
    @php($VotosObtenidos = 0)
    @php($VotosContrarios = 0)
    <style>ul{list-style: none;}</style>
    @php($Anios = \App\Anio::where('id', '>', '0')->orderby('name', 'DESC')->get())
    <div class="mdl-cell mdl-cell--12-col">
        @include('-helpers-.error')

    </div>

    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <button id="top-general" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('top-general', 'ul-1')">
                <i class="material-icons">expand_less</i>
            </button>
            Desgloce general&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @if(count($Anios) > 0)
                <select>
                    <option value="" selected></option>
                    @foreach($Anios as $A)
                        <option value="{{ $A->name }}" onclick="window.location.href = '{{ route('home.anio',  $A->name) }}'">{{ $A->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        @if(count($Anios) > 0)
            <ul id="ul-1" class="target mdl-list">
                <script>
                    var ArrAnios = [];
                    var NumArrAnios = 0;
                    var OperaEspera = '';
                    var OperaResulta = '';
                    var OperaPerdido = '';
                    var vars = '';
                    var varanio = '';
                    var anios = '';
                    var recibidos = '';
                    var esperados = '';
                    var perdidos = '';
                    var XYZB = '';
                    var XYZC = '';
                    var distritos_ul = '';
                    var distritos_b = '';
                    var municipios_ul = '';
                    var municipios_b = '';
                    var secciones_ul = '';
                    var secciones_b = '';
                    var colonias_ul = '';
                    var colonias_b = '';
                    var lideres_ul = '';
                    var lideres_b = '';
                </script>
                @foreach($Anios as $A)
                    @if($A->id == $Ans->id)
                        <script>
                            vars += '.varanio{{ $A->name }}';
                            varanio{{$A->name}} = '-->{{ $A->name }}';
                            recibidos += '|';
                            perdidos += '|';
                            anios = anios+'.{{ $A->name }}';
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
                                                @foreach($D->municipios as $M)
                                                    <li>
                                                        Municipio <b>{{ $M->name }}</b>
                                                        <script>
                                                            municipios_ul = municipios_ul + '.ul-municipio-{{ $M->id }}';
                                                            municipios_b = municipios_b + '.B-municipio-{{ $M->id }}';
                                                        </script>
                                                        <button id="B-municipio-{{ $M->id }}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('B-municipio-{{ $M->id }}', 'ul-municipio-{{ $M->id }}')">
                                                            <i class="material-icons">expand_less</i>
                                                        </button>
                                                        <ul id="ul-municipio-{{ $M->id }}">
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
                                                                                    <script>
                                                                                        colonias_ul = colonias_ul + '.ul-colonias-{{ $C->id }}';
                                                                                        colonias_b = colonias_b + '.B-colonias-{{ $C->id }}';
                                                                                    </script>
                                                                                    <li>
                                                                                        Colonia <b>{{ $C->name }}</b>
                                                                                        <button id="B-colonias-{{ $C->id }}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('B-colonias-{{ $C->id }}', 'ul-colonias-{{ $C->id }}')">
                                                                                            <i class="material-icons">expand_less</i>
                                                                                        </button>
                                                                                        <ul id="ul-colonias-{{ $C->id }}">
                                                                                            @if($C->lider != '')
                                                                                                <li>
                                                                                                    <script>
                                                                                                        lideres_ul = lideres_ul + '.ul-lider-{{ $C->lider->id }}';
                                                                                                        lideres_b = lideres_b + '.B-lider-{{ $C->lider->id }}';
                                                                                                    </script>
                                                                                                    Lider <b>{{ $C->lider->name }} {{ $C->lider->apat }} {{ $C->lider->amat }}</b>
                                                                                                    <button id="B-lider-{{ $C->lider->id }}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onclick="Fade_InOut('B-lider-{{ $C->lider->id }}', 'ul-lider-{{ $C->lider->id }}')">
                                                                                                        <i class="material-icons">expand_less</i>
                                                                                                    </button>
                                                                                                    <ul id="ul-lider-{{ $C->lider->id }}">
                                                                                                        @if(count($C->lider->militantes) > 0)
                                                                                                            @php($MilitantesRegistrados += count($C->lider->militantes))
                                                                                                            <script>
                                                                                                                OperaEspera += '{{ $A->name }}.{{count($C->lider->militantes)}}';
                                                                                                                esperados += '|{{count($C->lider->militantes)}}';
                                                                                                            </script>
                                                                                                            <li>Personas en tótal: <b>{{ count($C->lider->militantes) }}</b></li>
                                                                                                            @foreach($C->lider->militantes as $Mi)
                                                                                                                <li class="mdl-color--blue mdl-color-text--white text-center" style="margin: 10px; border-radius: 5px;">
                                                                                                                    <b>{{ $Mi->name }} {{ $Mi->apat }} {{ $Mi->amat }}</b>
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        @else
                                                                                                            <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                                                                                                No hay militantes registrados
                                                                                                            </li>
                                                                                                        @endif
                                                                                                    </ul>
                                                                                                </li>
                                                                                            @else
                                                                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                                                                                    No hay lider registrado
                                                                                                </li>
                                                                                            @endif
                                                                                        </ul>
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                                                                    No hay colonias registradas
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->resultados) > 0)
                                                                                <li>Votos a favor
                                                                                    <ul>
                                                                                        @foreach($S->resultados as $RF)
                                                                                            <li class="mdl-color--green mdl-color-text--white text-center" style="border-radius: 5px; margin: 10px;">
                                                                                                {{ $RF->total }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px; margin: 15px;">
                                                                                    No hay votos a favor registrados
                                                                                </li>
                                                                            @endif
                                                                            @if(count($S->otros) > 0)
                                                                                <li>Votos en contra
                                                                                    <ul>
                                                                                        @foreach($S->otros as $RF)
                                                                                            <li class="mdl-color--red mdl-color-text--white mdl-shadow--2dp text-center" style="border-radius: 5px; margin: 10px;">
                                                                                                {{ $RF->partido }}
                                                                                                {{ $RF->total }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px; margin: 15px;">
                                                                                    No hay oponentes registrados
                                                                                </li>
                                                                            @endif
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                                                    No hay secciones registradas
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                                    No hay municipios registrados
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endforeach
                            @else
                                <li class="mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                                    No hay distritos registrados
                                </li>
                            @endif
                        </ul>
                    </li>
                        @break
                    @endif
                @endforeach
            </ul>
        @else
            <ul id="ul-1">
                <li class="nx mdl-color--amber text-center mdl-shadow--2dp" style="border-radius: 13px">
                    No hay años registrados
                </li>
            </ul>
        @endif
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
        $('#top-general').click();
        var lid_ul = lideres_ul.split(".");
        var lid_bu = lideres_b.split(".");
        for (var Ix = 1; Ix < lid_ul.length; Ix++){
            var _X_x = $('#'+lid_bu[Ix]+' i');
            $('#'+lid_ul[Ix]).hide();
            _X_x.text('expand_more');
        }

        var sec_ul = secciones_ul.split(".");
        var sec_bu = secciones_b.split(".");
        for (var I = 1; I < sec_ul.length; I++){
            var _X_ = $('#'+sec_bu[I]+' i');
            $('#'+sec_ul[I]).hide();
            _X_.text('expand_more');
        }

        var mun_ul = municipios_ul.split(".");
        var mun_bu = municipios_b.split(".");
        for (var zI = 1; zI < mun_ul.length; zI++){
            var _X_z = $('#'+mun_bu[zI]+' i');
            $('#'+mun_ul[zI]).hide();
            _X_z.text('expand_more');
        }

        var cant = XYZC.split(".");
        var canb = XYZB.split(".");
        for (var i = 1; i < cant.length; i++){
            var _X = $('#'+canb[i]+' i');
            $('#'+cant[i]).hide('slow');
            _X.text('expand_more');
        }
    });
</script>
@php($Global = $MilitantesRegistrados+$VotosObtenidos+$VotosContrarios)
@if($Global > 0)
    @php($_P_Global = 100/$Global)
@else
    @php($_P_Global = 0)
@endif
@php($_X_Anios = '[')
@php($_X_Esperados = '[')
@php($_X_Recibidos = '[')
@php($_X_Perdidos = '[')
@php($_X_P_Esperados = '[')
@php($_X_P_Recibidos = '[')
@php($_X_P_Perdidos = '[')
@foreach($Anios as $Ans)
    @php($_X_Anios = $_X_Anios.$Ans->name.',')
    @php($_Esperados = 0)
    @php($_Recibidos = 0)
    @php($_Perdidos = 0)
    @if(count($Ans->distritos) > 0)
        @foreach($Ans->distritos as $d)
            @if(count($d->municipios) > 0)
                @foreach($d->municipios as $i)
                    @if(count($i->secciones) > 0)
                        @foreach($i->secciones as $S)
                            @if(count($S->colonias) > 0)
                                @foreach($S->colonias as $C)
                                    @if($C->lider != '')
                                        @php($_Esperados += count($C->lider->militantes))
                                    @endif
                                @endforeach
                            @endif
                            @if(count($S->resultados) > 0)
                                @foreach($S->resultados as $R)
                                    @php( $_Recibidos += $R->total)
                                @endforeach
                            @endif
                            @if(count($S->otros) > 0)
                                @foreach($S->otros as $O)
                                    @php( $_Perdidos += $O->total)
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif

    @if($_P_Global > 0)
        @php($_X_P_Esperados = $_X_P_Esperados.round(($_Esperados*$_P_Global),0).',')
        @php($_X_P_Recibidos = $_X_P_Recibidos.round(($_Recibidos*$_P_Global),0).',')
        @php($_X_P_Perdidos = $_X_P_Perdidos.round(($_Perdidos*$_P_Global),0).',')
    @else
        @php($_X_P_Esperados = $_X_P_Esperados.$_Esperados.',')
        @php($_X_P_Recibidos = $_X_P_Recibidos.$_Recibidos.',')
        @php($_X_P_Perdidos = $_X_P_Perdidos.$_Perdidos.',')
    @endif
    @php($_X_Esperados = $_X_Esperados.$_Esperados.',')
    @php($_X_Recibidos = $_X_Recibidos.$_Recibidos.',')
    @php($_X_Perdidos = $_X_Perdidos.$_Perdidos.',')
@endforeach
@php($_X_Anios = $_X_Anios.']')
@php($_X_Esperados = $_X_Esperados.']')
@php($_X_Recibidos = $_X_Recibidos.']')
@php($_X_Perdidos = $_X_Perdidos.']')
@php($_X_P_Esperados = $_X_P_Esperados.']')
@php($_X_P_Recibidos = $_X_P_Recibidos.']')
@php($_X_P_Perdidos = $_X_P_Perdidos.']')

<script type="text/javascript" rel="script" src="/grid/public/plugins/Chartjs-master/Chart.js"></script>
<div class="mdl-cell mdl-cell--12-col mdl-grid">
    <div class="mdl-cell mdl-cell--6-col">
        <canvas id="myChart" width="800" height="800"></canvas>
    </div>
    <div class="mdl-cell mdl-cell--6-col">
        <canvas id="myChart2" width="800" height="800"></canvas>
    </div>
</div>

<script>
    var ctx = $("#myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $_X_Anios !!},

            datasets: [
                {
                    fill: false,
                    label: 'Esperados',
                    data: {!! $_X_Esperados !!},
                    backgroundColor: ['rgba(10, 0, 219, 0.2)'],
                    borderColor: ['rgba(10, 0, 219, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(10, 0, 219, 0.2)',
                    pointBorderColor: 'rgba(10, 0, 219, 1)',
                    pointHoverRadius: 7
                },{
                    fill: false,
                    label: 'Recibidos',
                    data: {!! $_X_Recibidos !!},
                    backgroundColor: ['rgba(21, 219, 0, 0.2)'],
                    borderColor: ['rgba(21, 179, 0, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(21, 219, 0, 0.2)',
                    pointBorderColor: 'rgba(21, 179, 0, 1)',
                    pointHoverRadius: 7
                },{
                    fill: false,
                    label: 'Perdidos',
                    data: {!! $_X_Perdidos !!},
                    backgroundColor: ['rgba(219, 3, 10, 0.3)'],
                    borderColor: ['rgba(219, 3, 10, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(219, 3, 10, 0.3)',
                    pointBorderColor: 'rgba(219, 3, 10, 1)',
                    pointHoverRadius: 7
                }]
        },
        options: {
            title: {
                display: true,
                text: 'Tótal de votos por año'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Año'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Número de personas'
                    }
                }]
            }
        }
    });
    var ctx2 = $("#myChart2");
    var myChart2 = new Chart(ctx2, {
        type: 'horizontalBar',
        data: {
            labels: {!! $_X_Anios !!},

            datasets: [
                {
                    fill: false,
                    label: 'Esperados',
                    //data: [2, 9, 13, 15, 12, 13],
                    data: {!! $_X_P_Esperados !!},
                    backgroundColor: 'rgba(10, 0, 219, 0.2)',
                    borderColor: 'rgba(10, 0, 219, 1)',
                    borderWidth: 5,


                },{
                    fill: false,
                    label: 'Recibidos',
                    //data: [12, 19, 3, 5, 2, 3],
                    data: {!! $_X_P_Recibidos !!},
                    backgroundColor: 'rgba(21, 219, 0, 0.2)',
                    borderColor: 'rgba(21, 179, 0, 1)',
                    borderWidth: 5,

                },{
                    fill: false,
                    label: 'Perdidos',
                    data: {!! $_X_P_Perdidos !!},
                    backgroundColor: 'rgba(219, 3, 10, 0.3)',
                    borderColor: 'rgba(219, 3, 10, 1)',
                    borderWidth: 5,

                }]
        },
        options: {
            min:0,
            max:100,

            title: {
                display: true,
                text: 'Porcentaje por año'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    },
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Porcentaje'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Año'
                    }
                }]
            }
        }
    });
</script>
@endsection