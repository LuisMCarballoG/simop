@extends('layouts.mdl')
@section('content')
	@php($h = \App\Historial::where('user_id', $u->id)->get())
	<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		@section('BackAction', route('user.index'))
		@include('-helpers-.btn_Back')

		@if(count($h) > 0)
			@include('-helpers-.inpt_SearchInTable')
		@endif
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-cell mdl-cell--12-col">
				<h4>{{ $u->name }}</h4><h6 style="color: rgba(0,0,0,0.5);">Historial de movimientos</h6>
			</div>
			<table id="tabla" class="table mdl-cell mdl-cell--12-col">
				<thead>
				<tr>
					<th>Id</th>
					<th>Movimiento</th>
					<th>Fecha</th>
				</tr>
				</thead>
				<tbody>
				@if(count($h) > 0)
					@foreach($h as $i)
						<tr>
							<td>{{ $i->id }}</td>
							<td>{!! $i->movimiento !!}</td>
							<td>{{ $i->fecha }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td>
							No hay historial registrado
						</td>
					</tr>
				@endif
				</tbody>
			</table>
		</div>
	</div>
	@include('-helpers-.script_SearchOrderTable')
	@section('name', '#a-usuarios')
	@include('-helpers-.scr_Focus')
@endsection