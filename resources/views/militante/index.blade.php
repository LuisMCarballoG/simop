@extends('layouts.mdl')
@section('content')
    @php( $e = App\Militante::where('id', '>', '0')->orderby('name', 'ASC')->get())
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @if(count($e) > 0)
            @include('-helpers-.inpt_SearchInTable')
        @endif
            @section('btn-AddAction', route('militante.create'))
            @include('-helpers-.btn_AddNew')
        
        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.error')
            @include('-helpers-.ok')
            <h4>Militantes registrados</h4>
            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        
                        <th>Año</th>
                        <th>IFE / INE</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($e) > 0)
                        @foreach($e as $i)
                            <tr>
                                <td>{{ $i->id }}</td>
                                <td>{{ $i->name }} {{ $i->apat }} {{ $i->amat }}</td>
                                
                                <td>{{ $i->ife }}</td>
                                <td>
                                <!--
                                    @section('ShowMoreAction'.$i->id, route('militante.show', $i->id))
                                    @include('-helpers-.btn_ShowMore')
                                    -->

                                        @section('EditAction'.$i->id, route('militante.edit', $i->id))
                                        @include('-helpers-.btn_Edit')

                                        @section('msg-ToDelete'.$i->id, 'a <b>'.$i->name.' '.$i->apat.' '.$i->amat.'</b>')
                                        @section('form-ActionDelete'.$i->id, route('militante.destroy', $i->id))
                                        @include('-helpers-.btn_Delete')
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                No hay militantes registrados
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('-helpers-.script_SearchOrderTable')
    @section('name', '#a-militantes')
    @include('-helpers-.scr_Focus')
@endsection