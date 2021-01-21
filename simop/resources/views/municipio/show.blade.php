@extends('layouts.mdl')
@section('ScriptOnTop')
    <script>
        $(function(){
            $('#Estados').liveFilter('#buscador','li');
        });
    </script>
@endsection
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @section('BackAction', route('municipio.index'))
        @include('-helpers-.btn_Back')
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @include('-helpers-.inpt_SearchInTable')
        <div class="mdl-cell mdl-cell--12-col mdl-grid">
            <h5>Municipio: {{ $m->name }}</h5>
            <h6 style="color: rgba(0,0,0,0.44)">&nbsp;&nbsp;{{ $m->name }}</h6>
        </div>
        <ul id="Estados">
            {{--
            @if(count($m->secciones) > 0)
                @foreach($m->secciones as $S)

                        <li>Sección #{{ $S->name }}
                            @if(count($S->colonias) > 0)
                                <ul>
                                    @foreach($S->colonias as $C)
                                    <li>{{ $C->name }}
                                        <ul>
                                            @if($C->lider != '')
                                                <li> {{ $C->lider->name }} {{ $C->lider->apat }} {{ $C->lider->amat }}
                                                    <ul>
                                                        @if(count($C->lider->militantes) > 0)
                                                            @foreach($C->lider->militantes as $CLM)
                                                                <li>
                                                                    {{ $CLM->name }} {{ $CLM->apat }} {{ $CLM->amat }}
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                No hay militantes registrados
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    No hay lider registrado
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul>
                                    <li>
                                        No hay colonias para mostrar
                                    </li>
                                </ul>
                            @endif
                        </li>
                @endforeach
            @else
                <li>No hay registros para mostrar</li>
            @endif
            --}}
        </ul>
    </div>
@section('name', '#a-municipios')
@include('-helpers-.scr_Focus')
@endsection