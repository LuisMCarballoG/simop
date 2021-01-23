<button id="btn-clear-{{ $i->id }}" onclick="alertify.confirm('Confirme para continuar...','Está a punto de eliminar @yield('msg-ToDelete'.$i->id). Desea continuar?',function(){$('#delete-{{ $i->id }}').submit();},function(){});" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons mdl-color-text--red">clear</i></button>
<div class="mdl-tooltip" data-mdl-for="btn-clear-{{ $i->id }}">Eliminar</div>
<form id="delete-{{ $i->id }}" action="@yield('form-ActionDelete'.$i->id)" class="hidden" method="post">
    @method('DELETE')
    @csrf
    @yield('inpt-Extra'.$i->id)
</form>