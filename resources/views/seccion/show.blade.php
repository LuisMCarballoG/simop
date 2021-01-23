@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-grid">
            <h5>
                @section('BackAction', route('secciones.index'))
                @include('-helpers-.btn_Back')Sección #{{ $S->name }}</h5>
            <h6 style="color: rgba(0,0,0,0.44)">&nbsp;&nbsp;{{ $S->municipio->name }} - {{ $S->municipio->distrito->name }} - {{ $S->municipio->distrito->estado->name }} - {{ $S->municipio->distrito->anio->name }}</h6>
        </div>

        @php($Esperados = 0)
        @php($Recibidos = 0)
        @php($Perdidos = 0)
        @php($_P_Esperados = 0)
        @php($_P_Obtenidos = 0)
        @php($_P_Perdidos = 0)
        @foreach($S->colonias as $C)
            @if($C->lider != '')
                @if(count($C->lider->militantes) > 0)
                    @php($Esperados += count($C->lider->militantes))
                @endif
            @endif
        @endforeach
        Militantes : {{ $Esperados }}<br>
        @foreach($S->resultados as $R)
            @php($Recibidos += $R->total)
        @endforeach
        Votos obtenidos: {{ $Recibidos }}<br>
        @foreach($S->otros as $O)
            @php($Perdidos += $O->total)
        @endforeach
        Votos perdidos: {{ $Perdidos }}<br>

        @if($Esperados > 0 || $Recibidos > 0 || $Perdidos >  0)
            @php($PTPM = 100/($Esperados+$Recibidos+$Perdidos))
            @php($_P_Esperados = round(($Esperados*$PTPM), 2))
            @php($_P_Obtenidos = round(($Recibidos*$PTPM), 2))
            @php($_P_Perdidos = round(($Perdidos*$PTPM), 2))
        @endif
    </div>
    @section('name', '#a-secciones')
    @include('-helpers-.scr_Focus')


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
            labels: ['Esperados', 'Recibidos', 'Perdidos'],

            datasets: [
                {
                    fill: false,
                    label: 'Votos',
                    data: [{{ $Esperados }}, {{ $Recibidos }}, {{ $Perdidos }}],
                    backgroundColor: ['rgba(0, 0, 119, 0.2)'],
                    borderColor: ['rgba(0, 0, 119, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(0, 0, 119, 0.2)',
                    pointBorderColor: 'rgba(0, 0, 119, 1)',
                    pointHoverRadius: 7
                }/*,{
                    fill: false,
                    label: 'Recibidos',
                    data: [{{ $Recibidos }}],
                    backgroundColor: ['rgba(21, 219, 0, 0.2)'],
                    borderColor: ['rgba(21, 179, 0, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(21, 219, 0, 0.2)',
                    pointBorderColor: 'rgba(21, 179, 0, 1)',
                    pointHoverRadius: 7
                },{
                    fill: false,
                    label: 'Perdidos',
                    data: [{{ $Perdidos }}],
                    backgroundColor: ['rgba(219, 3, 10, 0.3)'],
                    borderColor: ['rgba(219, 3, 10, 1)'],
                    borderWidth: 5,
                    pointBackgroundColor: 'rgba(219, 3, 10, 0.3)',
                    pointBorderColor: 'rgba(219, 3, 10, 1)',
                    pointHoverRadius: 7
                }*/
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Tótal de votos en la Sección #{{ $S->name }}'
            },
            scales: {
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
            labels: ['#{{ $S->name }}'],
            datasets: [
                {
                    fill: false,
                    label: 'Esperados',
                    //data: [2, 9, 13, 15, 12, 13],
                    data: [{!! $_P_Esperados !!}],
                    backgroundColor: 'rgba(10, 0, 219, 0.2)',
                    borderColor: 'rgba(10, 0, 219, 1)',
                    borderWidth: 5,


                },
                {
                    fill: false,
                    label: 'Recibidos',
                    //data: [12, 19, 3, 5, 2, 3],
                    data: [{!! $_P_Obtenidos !!}],
                    backgroundColor: 'rgba(21, 219, 0, 0.2)',
                    borderColor: 'rgba(21, 179, 0, 1)',
                    borderWidth: 5,

                },
                {
                    fill: false,
                    label: 'Perdidos',
                    data: [{!! $_P_Perdidos !!}],
                    backgroundColor: 'rgba(219, 3, 10, 0.3)',
                    borderColor: 'rgba(219, 3, 10, 1)',
                    borderWidth: 5
                }
                ]
        },
        options: {
            min:0,
            max:100,

            title: {
                display: true,
                text: 'Porcentaje de la Sección #{{ $S->name }}'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        suggestedMin: 0,
                        max: 100
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
                        labelString: 'Sección'
                    }
                }]
            }
        }
    });
</script>
@endsection