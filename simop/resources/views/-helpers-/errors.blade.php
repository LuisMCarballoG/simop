@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mdl-color--red mdl-color-text--white mdl-cell mdl-cell--12-col" role="alert">
        <button type="button" class="close mdl-color-text--white" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Por favor corrija los siguientes errores</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif