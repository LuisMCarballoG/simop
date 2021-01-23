@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @include('-helpers-.inpt_SearchInTable')
        @section('btn-AddAction', route('coalicion.create'))
        @include('-helpers-.btn_AddNew')

        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            <h4>Coaliciones</h4>

            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Coalicion</th>
                        <th>Partidos</th>
                        <th>Oculto</th>
                    </tr>
                </thead>
                <tbody>
                    @if($CP > 0)
                        @foreach($C as $i)
                            <tr>
                                <td>
                                    <a href="{{ route('coalicion.show', $i->id) }}">
                                        <span id="coalicion{{ $i->id }}">
                                            {{ $i->name_small }}
                                        </span>
                                    </a>
                                    <div class="mdl-tooltip" data-mdl-for="coalicion{{ $i->id }}">
                                        {{ $i->name }}
                                    </div>
                                </td>
                                <td>
                                    @foreach($i->partidos as $P)
                                        <img src="{{ env('APP_URL') }}storage/app/public/{{ $P->foto }}" width="20" height="20" alt="Logo" id="foto_{{ $i->id }}_{{ $P->id }}">
                                        <div class="mdl-tooltip" data-mdl-for="foto_{{ $i->id }}_{{ $P->id }}">
                                            {{ $P->name }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($i->oculto === 'Y')
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" checked onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>

                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('coalicion.unblock') }}">
                                            @csrf
                                            <input type="hidden" name="partido" value="{{ $i->id }}">
                                        </form>
                                    @else
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-{{ $i->id }}">
                                            <input type="checkbox" id="switch-{{ $i->id }}" class="mdl-switch__input" onchange="$('#change_{{ $i->id }}').submit()">
                                            <span class="mdl-switch__label"></span>
                                        </label>
                                        <form id="change_{{ $i->id }}" class="hidden" method="POST" action="{{ route('coalicion.block') }}">
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
                                No hay coaliciones registradas
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function AddAliado(){
            alertify.confirm('Agregar nuevo aliado', 'Lista de aliados', );
        }
    </script>

    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-coalicion')
    @include('-helpers-.scr_Focus')
@endsection