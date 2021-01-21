@extends('layouts.mdl')

@section('content')
	<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
		<h5>Registrar Partido</h5>

		@include('-helpers-.errors')

		<form action="{{ route('partido.store') }}" method="POST" class="mdl-cell mdl-cell--12-col" enctype="multipart/form-data" autocomplete="off">
			@include('-helpers-.error')
			@include('-helpers-.ok')
		  	@csrf

			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="sample3" name="name_small" value="{{ old('name_small') }}" pattern="[A-Z]+((-|_){1}[A-Z]+)*" required>
				<label class="mdl-textfield__label" for="sample3">Nombre corto</label>
			</div>

			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}" pattern="[A-ZÁ-Ú]+[a-zá-ú]+([ ][A-ZÁ-Ú]+[a-zá-ú]+)*" required>
				<label class="mdl-textfield__label" for="sample3">Nombre completo</label>
			</div>

			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
				<input class="mdl-textfield__input" accept="image/png, .jpeg, .jpg, image/gif" type="file" id="sample3" name="foto" value="{{ old('foto') }}" required>
			</div>

			@section('BackAction', route('partido.index'))
			@include('-helpers-.btn_Back')
			@include('-helpers-.btn_Submit')
		</form>
	</div>

	@section('name', '#a-partido')
	@include('-helpers-.scr_Focus')
@endsection