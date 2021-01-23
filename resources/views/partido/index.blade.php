@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @include('-helpers-.inpt_SearchInTable')
        @section('btn-AddAction', route('partido.create'))
        @include('-helpers-.btn_AddNew')

        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            <h4>Partidos</h4>

            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Partido</th>
                        <th>Coaliciones</th>
                        <th>
                            Oculto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($CP > 0)
                        @foreach($P as $i)
                            <tr>
                                <td>
                                    <a href="{{ route('partido.show', $i->id) }}" id="partido{{ $i->id }}">
                                        @if($i->foto != '')
                                            <img src="simop/storage/app/public/{{ $i->foto }}" width="20" height="20" alt="Logo">
                                        @endif

                                        <span>
                                            {{ $i->name_small }}
                                        </span>
                                    </a>
                                    <div class="mdl-tooltip" data-mdl-for="partido{{ $i->id }}">
                                        {{ $i->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ count($i->coaliciones) }}
                                </td>
                                <td>
                                    @if ($i->oculto === 'Y')
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" checked onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>
                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('partido.unblock') }}">
                                            @csrf
                                            <input type="hidden" name="partido" value="{{ $i->id }}">
                                        </form>
                                    @else
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>
                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('partido.block') }}">
                                            @csrf
                                            <input type="hidden" name="partido" value="{{ $i->id }}">
                                        </form>
                                    @endif
                                    <div class="mdl-tooltip" data-mdl-for="switch-{{ $i->id }}">
                                        {{ $i->oculto }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                No hay partidos registrados
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-partido')
    @include('-helpers-.scr_Focus')
@endsection