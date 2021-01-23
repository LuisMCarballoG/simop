@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @include('-helpers-.inpt_SearchInTable')
        @section('BackAction', route('lider.index'))
        @include('-helpers-.btn_Back')
        <div class="mdl-cell mdl-cell--12-col"><h4>{{ $L->name }}</h4>
            <!--h6>{{ $L->colonia->seccion->name }} {{$L->colonia->seccion->municipio->name }} - {{ $L->colonia->seccion->municipio->distrito->name }}</h6--></div>
        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.ok')
            @include('-helpers-.error')
            <table id="tabla" class="table  mdl-cell mdl-cell--12-col">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Municipio</th>
                    <th>Cabecera</th>
                    <th>Secciones</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('-helpers-.script_SearchOrderTable')
@endsection