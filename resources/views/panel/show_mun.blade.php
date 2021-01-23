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
	  	<li>
	  		<a href="{{ route('home.anio', $a->id) }}">Año {{ $a->id }}</a>
	  	</li>
	  	<li class="active mdl-color-text--white">
	  		{{ $mun }}
	  	</li>
	</ol>

	@php($A = App\Anio::all())
	
	<div class="mdl-cell mdl-cell--12-col">
		@if (count($A) > 0)
			<div class="dropdown col-md-1">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Año 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					@foreach ($A as $i)
						@if ($i->id == $a->id)
							<li class="text-center active"><a href="#">{{ $i->id }}</a></li>
						@else
							<li class="text-center"><a href="{{ route('home.anio', $i->id) }}">{{ $i->id }}</a></li>
						@endif
					@endforeach
				</ul>
			</div>
			<div class="dropdown col-md-1">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Municipio 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					@php($Municipios = '[')
					@php($Els = App\Eleccion::where('anios_id', $a->id)->get())
					@php($id = 0)
					@php($ids = '')
					@php($Mns = App\Municipio::where('id', '>', '0')->orderBy('name', 'ASC')->get())
					@foreach ($Els as $i)
						@php($Flg = true)
						@foreach ($Mns as $ii)
							@if ($ii->id == $i->seccion->municipios_id && $id != $ii->id)

								@php($IdsExp = explode(',', $ids))
								@php($IdsCon = count($IdsExp))
								@for ($ix = 0; $ix < $IdsCon; $ix++)
									@if ($IdsExp[$ix] == $ii->id)
										@php($Flg = false)
									@endif
								@endfor

								@if ($Flg)
									@php($Municipios = $Municipios.'"'.$ii->name.'",')
									@php($_Carbon1 = str_replace(' ', '-', $i->seccion->municipio->name))
									@php($_Carbon2 = str_replace('Á', 'A', $_Carbon1))
									@php($_Carbon3 = str_replace('É', 'E', $_Carbon2))
									@php($_Carbon4 = str_replace('Í', 'I', $_Carbon3))
									@php($_Carbon5 = str_replace('Ó', 'O', $_Carbon4))
									@php($_Carbon6 = str_replace('Ú', 'U', $_Carbon5))
									@php($_Carbon7 = str_replace('Ñ', 'N', $_Carbon6))
									@if ($mun == $_Carbon7 )
										<li class="text-center active"><a href="{{ route('home.anio.mun', [$a->id, $_Carbon7]) }}">{{ $i->seccion->municipio->name }}</a></li>
									@else
										<li class="text-center"><a href="{{ route('home.anio.mun', [$a->id, $_Carbon7]) }}">{{ $i->seccion->municipio->name }}</a></li>
									@endif
									@php($Flg = true)
									@php($id = $ii->id)
									@php($ids = $ids.$ii->id.',')
								@endif
							@endif
						@endforeach
					@endforeach
					@php($Municipios = $Municipios.']')

				</ul>
			</div>

		@endif
	</div>

{{--
	@if (count($a->adscritos) <= 0 && count($a->elecciones) <= 0)
		<script type="text/javascript">
			alertify.alert('No hay información registrada', 'Debe crear por lo menos un registro para poder mostrar la información.');
		</script>
	@else
		@php($_C = '[')
		@php($_E = '[')
		@php($_Pe = '[')
		@php($Candidatos = App\Partido::all())
		@foreach ($Candidatos as $i)
			@php($Flag = true)
			@php($Flag2 = false)
			@php($E1 = 0)
			@php($E2 = 0)
			@foreach ($i->elecciones as $e)

				@if ($e->anio->name == $a->name)
					@php($Flag2 = true)
					@if($Flag)
						@php($_C = $_C.'"'.$i->name.'",')
						@php($Flag = false)
					@endif
					@if ($e->partidos_id == $i->id)
						@php($E1 += $e->total)
					@endif
				@endif
				
			@endforeach
			@if ($Flag2)
				@php($_E = $_E.$E1.',')
			@endif			
		@endforeach

		@php($_E2 = str_replace('[', '', $_E))
		@php($_E3 = str_replace(']', '', $_E2))
		
		@php($_E4 = explode(',', $_E3))
		@php($_E5 = count($_E4))

		@php($_E6 = 0)
		@php($Global = 0)
		@for ($i = 0; $i < $_E5; $i++)
			@php($_E6 += (int)$_E4[$i] )
		@endfor
		@if ($_E6 > 0)
			@php($Global = 100/$_E6)
		@endif


		@for ($i = 0; $i < $_E5; $i++)
			@php($_E7 = $Global*(int)$_E4[$i] )
			@php($_Pe = $_Pe.'"'.round($_E7, 2).'",')
		@endfor

		@php($_C = $_C.']')
		@php($_E = $_E.']')
		@php($_Pe = $_Pe.']')	

		<div class="mdl-cell mdl-cell--12-col mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<canvas id="myChart3" width="800" height="400"></canvas>
			</div>
		</div>
		
		<div class="mdl-cell mdl-cell--12-col mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<canvas id="myChart2" width="800" height="400"></canvas>
			</div>
		</div>

		<script>

		   	var ctx3 = $("#myChart3");
		    var myChart2 = new Chart(ctx3, {
		        type: 'horizontalBar',
		        data:{
		            labels: {!! $Municipios !!},
		            datasets:[{
		                fill: false,
		                label: 'Votos',
		                data: {!! $_E !!},
		                backgroundColor: 'rgba(33, 150, 243,1.0)',
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

		   var ctx2 = $("#myChart2");
		    var myChart2 = new Chart(ctx2, {
		        type: 'horizontalBar',
		        data:{
		            labels: {!! $Municipios !!},

		            datasets:[{
		                fill: false,
		                label: 'Porcentaje',
		                data: {!! $_Pe !!},
		                backgroundColor: 'rgba(158, 158, 158,1.0)',
		                borderColor: 'rgba(158, 158, 158,1.0)',
		                borderWidth: 5
		            },{
		                fill: false,
		                label: 'Porcentaje',
		                data: {!! $_Pe !!},
		                backgroundColor: 'rgba(178, 178, 178,1.0)',
		                borderColor: 'rgba(178, 178, 178,1.0)',
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
		</script>
	@endif
	--}}

	@section('name', '#a-inicio')
	@include('-helpers-.scr_Focus')
	
@endsection