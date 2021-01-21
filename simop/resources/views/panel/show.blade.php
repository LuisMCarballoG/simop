@extends('layouts.mdl')

@section('ScriptOnTop')
	<script type="text/javascript" rel="script" src="{{ env('PUB') }}Chartjs-master/Chart.js"></script>
@endsection

@section('content')
	@if ($a->id == 2018)
		@php($CountAds = count($a->adscritos))
	@else
		@php($CountAds = 0)
	@endif
	
	@php($CountEls = count($a->elecciones))
	
	<ol class="breadcrumb mdl-color--indigo mdl-cell mdl-cell--12-col">
	  	<li>
	  		<a href="{{ route('home') }}">Historico</a>
	  	</li>
	  	<li class="active mdl-color-text--white">
	  		Año {{ $a->id }}
	  	</li>
	</ol>
	
	<div class="mdl-cell mdl-cell--12-col">
		@include('-helpers-.error')

		<!-- Dropdown Years -->
		<div class="dropdown col-md-1">
			<button class="btn btn-default dropdown-toggle" type="button" id="ddM1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Año&nbsp;<span class="caret"></span>
			</button>

			<ul class="dropdown-menu" aria-labelledby="ddM1">
				@foreach ($A as $i)
					@php($I = $i->id)
					@if ($I == $a->id)
						<li class="text-center active">
							<a href="#">{{ $I }}</a>
						</li>
					@else
						<li class="text-center">
							<a href="{{ route('home.anio', $I) }}">{{ $I }}</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
		
		@if ($CountEls > 0)
			<!-- Dropdown Municipies -->
			<div class="hidden dropdown col-md-1">
				<button class="btn btn-default dropdown-toggle" type="button" id="ddM2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Municipio&nbsp;<span class="caret"></span>
				</button>

				<ul class="dropdown-menu" aria-labelledby="ddM2">
					@php($mid = 0)
					@php($Muns = '')
					@foreach ($Mn as $m)

						@php($mex = $m->seccion->municipios_id)
						@php($nam = $m->seccion->municipio->name)						
						@if ($mid != $mex)
							@php($Muns = $Muns.'"'.$nam.'",')
							@php($mid = $mex)
							@php($X = App\Http\Controllers\HomeController::StrReplace($nam))
							<li class="text-center"><a href="{{ route('home.anio.mun', [$a->id, $X]) }}">{{ $nam }}</a></li>
						@endif
					@endforeach
				</ul>
			</div>
		@endif
	</div>		

	@if ($CountAds <= 0 && $CountEls <= 0)

		<script type="text/javascript">
			alertify.alert('No hay información registrada', 'Debe crear por lo menos un registro para poder mostrar la información.');
		</script>

	@else
		
		@php($_C = '')
		@foreach ($Pt as $p)
			@if($p->partido_id != '')
				@php($_C = $_C.'"'.$p->partido->name_small.'",')
			@endif
			@if($p->coalicion_id != '')
				@php($_C = $_C.'"'.$p->coalicion->name_small.'",')
			@endif
		@endforeach

		@php($TotMn =  count($Mn))
		@php($T1 =  1)
		@php($T2 =  0)
		@php($T3 =  0)
		@php($E1 = '')

		@foreach ($E as $e)

			@php($T2 +=  $e->total)
			@php($T3 +=  $e->total)
			@if ($T1 == $TotMn)
				
				@php($T1 =  1)
				@php($E1 = $E1.$T2.',')
				@php($T2 =  0)
			@else
				@php($T1 +=  1)
			@endif
		@endforeach

		@php($E4 = explode(',', $E1))
		@php($E5 = count($E4))
		@php($G = 0)
		@if ($T3 > 0)
			@php($G = 100/$T3)
		@endif

		@php($_Pe = '')
		@for ($i = 0; $i < $E5; $i++)
			@php($_E7 = $G*(int)$E4[$i] )
			@php($_Pe = $_Pe.'"'.round($_E7, 2).'",')
		@endfor


		<div id="charts">
			<div class="c2">
				<canvas class=" charts" id="myChart3"></canvas>
			</div>
		</div>

		<div id="charts">
			<div class="c2">
				<canvas class=" charts" id="myChart2"></canvas>
			</div>
		</div>

		<div class="text-center" style="width: 100%">
		{{ $Sec->links() }}</div>
		<table id="tabla" class="table mdl-cell mdl-cell--12-col">
			<thead>
				<tr>
					<th>Municipio</th>
					<th>Sección</th>
					<th>Partido</th>
					<th>Coalición</th>
					<th>Tótal</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($Sec as $s)
					{{-- expr --}}
					<tr>
						<td>{{ $s->seccion->municipio->name }}</td>
						<td>{{ $s->seccion->id }}</td>
						<td>
							@if($s->partido_id != '')
							{{ $s->partido->name }}
							@endif
						</td>
						<td>
							@if($s->coalicion_id != '')
							{{ $s->coalicion->name }}
							@endif
						</td>
						<td>{{ $s->total }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="text-center" style="width: 100%">
		{{ $Sec->links() }}</div>

		<script>
		   	var ctx2 = $("#myChart2");
		    var myChart2 = new Chart(ctx2, {
		        type: 'horizontalBar',
		        data:{
		            labels: [{!! $_C !!}],

		            datasets:[{
		                fill: false,
		                label: 'Porcentaje',
		                data: [{!! $_Pe !!}],
		                backgroundColor: 'rgba(158, 158, 158,1.0)',
		                borderColor: 'rgba(158, 158, 158,1.0)',
		                borderWidth: 5
		            }]
		        },
		        options:{
		            title:{
		                display: true,
		                text: 'Porcentaje obtenido por partido'
		            },
		            scales:{
		                xAxes:[{
		                    ticks:{
		                        suggestedMin: 0,
		                        suggestedMax: 100
		                    },
		                    display: true,
		                    scaleLabel:{
		                        display: true,
		                        labelString: 'Porcentaje de votos'
		                    }
		                }],
		                yAxes:[{
		                    display: true,
		                    scaleLabel:{
		                        display: false,
		                        labelString: 'Partidos'
		                    }
		                }]
		            }
		        }
		    });

		   	var ctx3 = $("#myChart3");
		    var myChart2 = new Chart(ctx3, {
		        type: 'horizontalBar',
		        data:{
		            labels: [{!! $_C !!}],
		            datasets:[{
		                fill: false,
		                label: 'Votos',
		                data: [{!! $E1 !!}],
		                backgroundColor: 'rgba(30, 150, 243,1.0)',
		                borderColor: 'rgba(33, 150, 243,1.0)',
		                borderWidth: 5,
		            }]
		        },
		        options:{
		            title:{
		                display: true,
		                text: 'Tótal de votos por partido'
		            },
		            scales:{
		                xAxes:[{
		                    ticks:{
		                        suggestedMin: 0,	                        
		                        suggestedMax: 100		                        
		                    },
		                    display: true,
		                    scaleLabel:{
		                        display: true,
		                        labelString: 'Número de votos'
		                    }
		                }],
		                yAxes:[{
		                    display: true,
		                    scaleLabel:{
		                        display: false,
		                        labelString: 'Partidos'
		                    }
		                }]
		            }
		        }
		    });
		</script>
	@endif

	@include('-helpers-.script_SearchOrderTable')
	@section('name', '#a-inicio')
	@include('-helpers-.scr_Focus')
	
@endsection