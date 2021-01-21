@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @include('-helpers-.inpt_SearchInTable')
        <div class="mdl-cell mdl-cell--12-col">
            <h4>Historial de movimientos</h4>
            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                <tr>
                    <th>Movimiento</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                @if(count($i) > 0)
                    @foreach($i as $h)
                        <tr>
                            <td>{!! $h->movimiento !!}</td>
                            <td>{{ $h->fecha }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">
                            No hay registros disponibles para mostrar
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('-helpers-.script_SearchOrderTable')
@endsection