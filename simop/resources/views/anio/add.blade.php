@extends('layouts.mdl')

@section('content')
	<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
		<h5>
            Registrar Año
        </h5>

		@include('-helpers-.errors')

		<form action="{{ route('anio.store') }}" method="POST" class="mdl-cell mdl-cell--12-col" autocomplete="off">
			@include('-helpers-.error')
			@include('-helpers-.ok')
		  	@csrf

			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="sample3" name="name" maxlength="4" minlength="4" pattern="(20){1}(09|1[0-9]|2[0-9]){1}" value="{{ old('name') }}" autofocus required>
				<label class="mdl-textfield__label" for="sample3">Año</label>
			</div>

			@section('BackAction', route('anio.index'))
			@include('-helpers-.btn_Back')
			@include('-helpers-.btn_Submit')
		</form>
	</div>

	@section('name', '#a-anios')
	@include('-helpers-.scr_Focus')
@endsection