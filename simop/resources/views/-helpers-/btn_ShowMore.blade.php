<button id="btn-show-more{{ $i->id }}" onclick="window.location.href = '@yield('ShowMoreAction'.$i->id)'" class="mdl-button mdl-js-button mdl-button--icon">
    <i class="material-icons mdl-color-text--blue">more_horiz</i>
</button>
<div class="mdl-tooltip" data-mdl-for="btn-show-more{{ $i->id }}">
    Ver más de <br>
    {{ $i->name }}
</div>
