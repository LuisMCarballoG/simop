@extends('layouts.mdl')

@section('content')

    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">

        @include('-helpers-.inpt_SearchInTable')
        @section('btn-AddAction', route('lider.create'))
        @include('-helpers-.btn_AddNew')

        <div class="mdl-cell mdl-cell--12-col">

            @include('-helpers-.error')
            @include('-helpers-.ok')

            <h4>Activistas</h4>

            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Simpatizantes</th>
                        <!--th>Info</th-->
                    </tr>
                </thead>
                <tbody>
                    @php( $e = App\Lider::where('id', '>', '0')->orderby('name', 'ASC')->get())
                    @if(count($e) > 0)
                        @foreach($e as $i)
                            <tr>
                                <td>
                                    <script type="text/javascript">
                                        function Lid{{ $i->id }}(){
                                            alertify.alert(
                                                "{{ $i->name }} {{ $i->apat }} {{ $i->amat }}",
                                                "<label>Dirección:</label><br>"+
                                                "{{ $i->dir }}<hr>"+
                                                "<label>IFE / INE:</label><br>"+
                                                "{{ $i->ife }}"
                                                ,function(){}
                                            ).set({transition:'flipy', 'startMaximized':false, 'maximizable':false}).show();
                                        }
                                    </script>
                                    <a href="#" onclick="Lid{{ $i->id }}()">{{ $i->name }} {{ $i->apat }} {{ $i->amat }}</a>
                                </td>
                                <td>
                                    <script type="text/javascript">
                                        function Mils{{ $i->id }}(){
                                            alertify.alert(
                                                "{{ $i->name }} {{ $i->apat }} {{ $i->amat }}",
                                                "<table class='table-striped'>"+
                                                "        <thead>"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   <label>Simpatizantes</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Sección</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Municipio</label>"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "        </thead>"+
                                                "        <tbody>"+
                                                "@foreach ($i->adscritos as $a)"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   {{ $a->militante->name }} {{ $a->militante->apat }} {{ $a->militante->amat }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->name }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->municipio->name }}"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "@endforeach"+
                                                "        </tbody>"+
                                                "    </table>"
                                                ,function(){}
                                            ).set({transition:'zoom', 'startMaximized':false, 'maximizable':true}).show();
                                        }
                                    </script>
                                    <a href="#" onclick="Mils{{ $i->id }}()">{{ count($i->adscritos) }}</a>
                                </td>
                                <!--td>
                                    <script type="text/javascript">
                                        function Porcents{{ $i->id }}(){
                                            alertify.alert(
                                                "{{ $i->name }} {{ $i->apat }} {{ $i->amat }}",
                                                "<table class='table-striped'>"+
                                                "        <thead>"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   <label>Militantes</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Colonia</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Sección</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Municipio</label>"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "        </thead>"+
                                                "        <tbody>"+
                                                "@foreach ($i->adscritos as $a)"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   {{ $a->militante->name }} {{ $a->militante->apat }} {{ $a->militante->amat }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   "+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->name }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->municipio->name }}"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "@endforeach"+
                                                "        </tbody>"+
                                                "    </table>"+
                                                "<br>"+
                                                "<table class='table-striped'>"+
                                                "        <thead>"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   <label>Militantes</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Colonia</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Sección</label>"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   <label>Municipio</label>"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "        </thead>"+
                                                "        <tbody>"+
                                                "@foreach ($i->adscritos as $a)"+
                                                "            <tr>"+
                                                "                <td>"+
                                                "                   {{ $a->militante->name }} {{ $a->militante->apat }} {{ $a->militante->amat }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   "+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->name }}"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                                                "                </td>"+
                                                "                <td>"+
                                                "                   {{ $a->seccion->municipio->name }}"+
                                                "                </td>"+
                                                "            </tr>"+
                                                "@endforeach"+
                                                "        </tbody>"+
                                                "    </table>"
                                                ,function(){}
                                            ).set({transition:'zoom', 'startMaximized':false, 'maximizable':true}).show();
                                        }
                                    </script>
                                    <button class="mdl-button mdl-js-button mdl-button--icon" onclick="Porcents{{ $i->id }}()">
                                        <i class="material-icons mdl-color-text--blue">person</i>
                                    </button>
                                </td-->
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                No hay registros disponibles para mostrar
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-lideres')
    @include('-helpers-.scr_Focus')
@endsection