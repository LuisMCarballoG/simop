<button id="btn-edit-{{ $i->id }}" onclick="window.location.href = '@yield('EditAction'.$i->id)'" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons mdl-color-text--amber">create</i></button>
<div class="mdl-tooltip" data-mdl-for="btn-edit-{{ $i->id }}">Editar <br> @yield('EditName'.$i->id)</div>