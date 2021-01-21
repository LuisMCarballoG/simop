@extends('layouts.mdl')
@section('content')
	@php( $u = App\User::where('id', '!=', Auth::user()->id)->get())
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
		@if(count($u) > 1)
			@include('-helpers-.inpt_SearchInTable')
		@endif

		@section('btn-AddAction', route('user.create'))
		@include('-helpers-.btn_AddNew')

		<div class="mdl-cell mdl-cell--12-col">
			@include('-helpers-.ok')
			@include('-helpers-.error')
			<h4>Usuarios registrados</h4>
			<table id="tabla" class="table  mdl-cell mdl-cell--12-col">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Estatus</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					@if(count($u))
						@foreach($u as $i)
							@if($i->id != Auth::user()->id)
								<tr>
									<td>{{ $i->name }}</td>
									<td>{{ $i->email }}</td>
									<td>
										@if($i->aceptado == 'Y')
											<button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--green" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="El usuario <b>{{ $i->name }}</b> ya ha sido aceptado.">
												<i class="material-icons">check</i>
											</button>
										@else
											<button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="El usuario <b>{{ $i->name }}</b> se encuentra bloqueado.">
												<i class="material-icons">block</i>
											</button>
										@endif
									</td>
									<td>
										@section('ShowMoreAction'.$i->id, route('user.show', $i->id))
										@include('-helpers-.btn_ShowMore')

										<!-- Colored icon button -->
										<button id="btn-history-{{ $i->id }}" onclick="window.location.href = '{{ route('user.Historial', $i->id) }}'" class="mdl-button mdl-js-button mdl-button--icon">
										  <i class="material-icons mdl-color-text--blue">list</i>
										</button>
										<div class="mdl-tooltip" data-mdl-for="btn-history-{{ $i->id }}">
											Historial
										</div>

										<!-- Edit Button  -->
										@section('EditAction'.$i->id, route('user.edit', $i->id))
										@section('EditName'.$i->id, $i->name)
										@include('-helpers-.btn_Edit')

										<!-- Button to delete a register -->
										@section('msg-ToDelete'.$i->id, 'usuario de <b>'.$i->name.'</b>')
										@section('form-ActionDelete'.$i->id, route('user.destroy', $i->id))
										@section('inpt-Extra'.$i->id)
											<input type="hidden" name="name" value="{{ $i->name }}">
										@endsection
										@include('-helpers-.btn_Delete')
									</td>
								</tr>
							@endif
						@endforeach
					@else
						<tr>
							<td>
								No hay usuarios registrados
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
	</script>
	@include('-helpers-.script_SearchOrderTable')
	@section('name', '#a-usuarios')
	@include('-helpers-.scr_Focus')
@endsection