@extends('layouts.mdl')
@section('content')

	<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">

		@include('-helpers-.inpt_SearchInTable')
		@section('btn-AddAction', route('municipio.create'))
		@include('-helpers-.btn_AddNew')

		<div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
			@include('-helpers-.ok')

			<h4>Municipios</h4>

			<table id="tabla" class="table mdl-cell mdl-cell--12-col">
				<thead>
					<tr>
						<th>Municipio</th>
						<th class="text-center">Secciones</th>
						<th class="text-center">Tótal de Secciones</th>
						
						<th class="text-center">Simpatizantes</th>
					</tr>
				</thead>
				<tbody>
					@if($CM > 0)
						@php($A = 0)
						@foreach($M as $i)
							<tr>
								<td>{{ $i->name }}</td>
								<td class="text-center">
									@php($S1 = App\Seccion::where('municipio_id', $i->id)->orderBy('name', 'ASC')->take(1)->get())
									@php($S2 = App\Seccion::where('municipio_id', $i->id)->orderBy('name', 'DESC')->take(1)->get())
                                    @php($CS1 = count($S1))
                                    @php($CS2 = count($S2))
									@if ($CS1 > 0 && $CS2 > 0)
                                        @if($S1[0]->id == $S2[0]->id)
                                            {{ $S1[0]->id }}
                                        @else
										    {{ $S1[0]->id }} - {{ $S2[0]->id }}
                                        @endif
									@elseif ($CS1 > 0 && $CS2 <= 0)
										{{ $S1[0]->id }}
									@elseif ($CS1 <= 0 && $CS2 > 0)
										{{ $S2[0]->id }}
									@else
										<label>{{ __('Sin secciónes') }}</label>
									@endif
								</td>
								<td class="text-center">
									{{ count($i->secciones) }}
								</td>
								<td class="text-center">
                                    @php($TADS = 0)
                                    @foreach($i->secciones as $si)
                                        @php($TADS = $TADS + count($si->adscritos))
                                    @endforeach
                                    {{ $TADS }}
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td>
								No hay municipios registrados
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	@include('-helpers-.script_SearchOrderTable')
	@section('name', '#a-municipios')
	@include('-helpers-.scr_Focus')
@endsection