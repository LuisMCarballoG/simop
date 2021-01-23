@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		@php($e = App\Seccion::where('id', '>', '0')->orderby('name', 'ASC')->paginate(100))
			@include('-helpers-.inpt_SearchInTable')
			@section('btn-AddAction', route('seccion.create'))
			@include('-helpers-.btn_AddNew')
		<div class="mdl-cell mdl-cell--12-col">
			@include('-helpers-.error')
			@include('-helpers-.ok')
			<h4>Secciones</h4>
			<div class="col-md-12 text-center">{{ $e->links() }}</div>
			<table id="tabla" class="table  mdl-cell mdl-cell--12-col">
				<thead>
					<tr>
						<th>Municipio</th>
						<th>Sección</th>
				  		<th>Simpatizantes</th>
					</tr>
			  	</thead>
			  	<tbody>
					@if(count($e) > 0)
						@foreach($e as $i)			  				
							<tr>
								<td>{{ $i->municipio->name }}</td>
								<td>{{ $i->name }}</td>
								<td>{{ count($i->adscritos) }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td>
								No hay registros para mostrar
							</td>
						</tr>
					@endif
		    	</tbody>
			</table>
			<div class="col-md-12 text-center">{{ $e->links() }}</div>
		</div>
	</div>
	@include('-helpers-.script_SearchOrderTable')
	@section('name', '#a-secciones')
	@include('-helpers-.scr_Focus')
@endsection