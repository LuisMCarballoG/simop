@if(session('ok'))
	<div class="alert alert-success alert-dismissible mdl-color--green mdl-color-text--black" role="alert">
		<button type="button" class="close mdl-color-text--black" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Listo!</strong> {!! session('ok') !!}
	</div>
@endif