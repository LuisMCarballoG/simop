@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @include('-helpers-.ok')

            <h4>Años</h4>

            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Oculto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @if($CA > 0)
                        @foreach($A as $i)
                            <tr>
                                <td>{{ $i->id }}</td>
                                <td>
                                    @if ($i->oculto === 'Y')
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" checked onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>
                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('anio.unblock') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $i->id }}">
                                        </form>
                                    @else
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>
                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('anio.block') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $i->id }}">
                                        </form>
                                    @endif
                                    <div class="mdl-tooltip" data-mdl-for="switch-{{ $i->id }}">
                                        {{ $i->oculto }}
                                    </div>
                                </td>
                                <td>
                                    <button id="btn-show-more{{ $i->id }}" onclick="window.location.href = '{{ route('anio.show', $i->id) }}'" class="mdl-button mdl-js-button mdl-button--icon">
                                        <i class="material-icons mdl-color-text--blue">more_horiz</i>
                                    </button>
                                    <div class="mdl-tooltip" data-mdl-for="btn-show-more{{ $i->id }}">
                                        Ver más del año {{ $i->id }}
                                    </div>

                                    @section('msg-ToDelete'.$i->id, 'el año <b>'.$i->id.'</b>. Tome en cuenta que las <b>Elecciones</b> y los <b>Adscritos</b> de este año serán eliminados')
                                    @section('form-ActionDelete'.$i->id, route('anio.destroy', $i->id))
                                    @include('-helpers-.btn_Delete')
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                No hay años registrados
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-anios')
    @include('-helpers-.scr_Focus')
@endsection