@extends('layouts.mdl')

@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @section('BackAction', route('anio.index'))
        @include('-helpers-.btn_Back')
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @include('-helpers-.inpt_SearchInTable')

        <div class="mdl-cell mdl-cell--12-col mdl-grid">
            <h5>{{ $a->id }}</h5>
        </div>
        <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Municipio</th>
                        <th>Sección</th>
                        <th>Partido</th>
                        <th>Coalición</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($a->elecciones) > 0)
                        @foreach($a->elecciones as $i)
                        <tr>
                            <td>{{ $i->seccion->municipio->name }}</td>
                            <td>{{ $i->seccion_id }}</td>
                            <td>
                                @if($i->partido_id != '')
                                {{ $i->partido->name_small }}
                                @endif
                            </td>
                            <td>
                                @if($i->coalicion_id != '')
                                {{ $i->coalicion->name_small }}
                                @endif
                            </td>
                            <td>{{ $i->total }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center;">No hay datos para mostrar</td>
                        </tr>
                    @endif
                </tbody>
            </table>
    </div>

    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-anios')
    @include('-helpers-.scr_Focus')
@endsection