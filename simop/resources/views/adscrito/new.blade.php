@extends('layouts.mdl')
@section('content')
	<div class="demo-charts mdl-color--white mdl-shadow--3dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid" style="border-radius: 10px; padding: 25px;">
		<h5 class="mdl-cell mdl-cell--12-col" style="font-weight: 800;">Seleccione un lider</h5>

		@include('-helpers-.errors')

		<form action="{{ route('anio.index') }}" method="POST" class="mdl-cell mdl-cell--12-col">
			@include('-helpers-.error')
			@include('-helpers-.ok')
		  	@csrf

            @php($L = App\Lider::where('id', '>', 0)->orderby('name', 'DESC')->get())
            @if (count($L) >= 1)
			  	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	                <select class="mdl-textfield__input" id="sample4" name="lider" required>
	                    <option selected></option>
	                    @foreach($L as $i)
                            <option value="{{ $i->id }}">{{ $i->name }} {{ $i->apat }} {{ $i->amat }}</option>
	                    @endforeach
	                </select>
	                <label class="mdl-textfield__label" for="sample4">Lider...</label>
	            </div>

	            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
	                <input class="mdl-checkbox__input" type="checkbox" id="checkbox-1" name="remember" {{ old('remember') ? 'checked' : '' }}>
	                <span class="mdl-checkbox__label os-light">Registrar nuevo</span>
	            </label>

            @endif

			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="sample3" name="name" pattern="(19|20){1}[0-9]{2}" value="{{ old('name') }}" required>
				<label class="mdl-textfield__label" for="sample3"></label>
			</div>

			@section('BackAction', route('adscritos.index'))
			@include('-helpers-.btn_Back')


			<button id="next1" class="mdl-cell mdl-cell--5-offset mdl-color-text--white mdl-color--indigo mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
			  	<i class="material-icons">
					arrow_forward
				</i>
			</button>

			<div class="mdl-tooltip" data-mdl-for="next1">
				Siguiente
			</div>
		</form>

	</div>
	@section('name', '#a-anios')
	@include('-helpers-.scr_Focus')
@endsection