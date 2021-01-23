@extends('layouts.mdl')

@section('ScriptOnTop')
	<script type="text/javascript" rel="script" src="{{ env('PUB') }}Chartjs-master/Chart.js"></script>
@endsection

@section('content')
    <ol class="breadcrumb mdl-color--indigo mdl-cell mdl-cell--12-col">
        <li class="active mdl-color-text--white">Historico</li>
    </ol>

    <div class="mdl-cell mdl-cell--12-col">
        @include('-helpers-.error')
        <div class="dropdown col-md-1">
            <button class="btn btn-default dropdown-toggle" type="button" id="ddM1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Año <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="ddM1">
                @php($_A = '')
                @foreach ($A as $i)
                    @php($_A = $_A.'"'.$i->id.'",')
                    <li class="text-center"><a href="{{ route('home.anio', $i->id) }}">{{ $i->id }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    @php($String = "")
    @foreach (App\Partido::where('oculto', 'N')->orderBy('name_small', 'ASC')->get() as $p)
        @php($Vals = "")
        @foreach ($A as $a)
            @php($Ints = 0)
            @foreach (App\Eleccion::where('partido_id', $p->id)->where('anio_id', $a->id)->get() as $e)
                @php($Ints += $e->total)
            @endforeach
            @php($Vals = $Vals."'".$Ints."',")
        @endforeach
        <?php
        $Hex = App\Http\Controllers\HomeController::hex();
        $Color1 = App\Http\Controllers\HomeController::hex2rgba($Hex, 0.2);
        $Color2 = App\Http\Controllers\HomeController::hex2rgba($Hex, 0.5);
        $String = $String."{".
            "fill: true,".
            "label: '".$p->name_small."',".
            "data: [".$Vals."],".
            "backgroundColor: ['".$Color1."'],".
            "borderColor: ['".$Color2."'],".
            "borderWidth: 5,".
            "pointBackgroundColor: '".$Color1."',".
            "pointBorderColor: '".$Color2."',".
            "pointHoverRadius: 6,".
            "lineTension: 0},";
        ?>
    @endforeach

    @php($Strings = "")
    @foreach (App\Coalicion::where('oculto', 'N')->orderBy('name_small', 'ASC')->get() as $p)
        @php($Vals = "")
        @foreach ($A as $a)
            @php($Ints = 0)
            @foreach (App\Eleccion::where('coalicion_id', $p->id)->where('anio_id', $a->id)->get() as $e)
                @php($Ints += $e->total)
            @endforeach
            @php($Vals = $Vals."'".$Ints."',")
        @endforeach
        <?php
        $Hex = App\Http\Controllers\HomeController::hex();
        $Color1 = App\Http\Controllers\HomeController::hex2rgba($Hex, 0.2);
        $Color2 = App\Http\Controllers\HomeController::hex2rgba($Hex, 0.5);
        $Strings = $Strings."{".
            "fill: true,".
            "label: '".$p->name_small."',".
            "data: [".$Vals."],".
            "backgroundColor: ['".$Color1."'],".
            "borderColor: ['".$Color2."'],".
            "borderWidth: 5,".
            "pointBackgroundColor: '".$Color1."',".
            "pointBorderColor: '".$Color2."',".
            "pointHoverRadius: 6,".
            "lineTension: 0},";
        ?>
    @endforeach

    <div id="charts">
        <div class="c2">
            <canvas class=" charts" id="myChartJS"></canvas>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>

    <div id="charts">
        <div class="c2">
            <canvas class=" charts" id="CoalicionGraph"></canvas>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">&nbsp;</div>

    <script>
        var ctx = $("#myChartJS");
        var myChartJS = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [{!! $_A !!}],
                datasets: [
                    {!! $String !!}
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Votos por Partido'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Año'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Votos'
                        }
                    }]
                }
            }
        });

        var ctx = $("#CoalicionGraph");
        var myChartJS = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [{!! $_A !!}],
                datasets: [
                    {!! $Strings !!}
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Votos por Partido'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Año'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Votos'
                        }
                    }]
                }
            }
        });
    </script>

    @section('name', '#a-inicio')
    @include('-helpers-.scr_Focus')
@endsection