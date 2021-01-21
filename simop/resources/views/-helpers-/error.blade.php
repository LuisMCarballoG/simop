@if(session('error'))
	<div class="alert alert-danger alert-dismissible mdl-color--red mdl-color-text--white" role="alert">
		<button type="button" class="close mdl-color-text--white" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Error!</strong> {{ session('error') }}
	</div>
@endif