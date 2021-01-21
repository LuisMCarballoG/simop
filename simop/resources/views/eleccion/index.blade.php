@extends('layouts.mdl')

@section('content')
    @php($An = App\Http\Controllers\FechaController::Anio())
    @php($E = App\Eleccion::where('anio_id', $An)->orderBy('seccion_id', 'ASC')->paginate(100))

    <div class="col-md-12">
        @include('-helpers-.errors')
        @include('-helpers-.error')
        @include('-helpers-.ok')
    </div>


    <div id="form-result" class=" hidden demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <button id="btn-hide" class="mdl-button mdl-js-button mdl-button--icon" onclick="hide()">
            <i class="material-icons">keyboard_arrow_up</i>
        </button>
        Registrar resultado
        <script type="text/javascript">
            function show(){
                $('#tb-1').addClass('hidden');
                $('#form-result').removeClass('hidden');
            }
            function hide(){
                $('#tb-1').removeClass('hidden');
                $('#form-result').addClass('hidden');
            }
        </script>

        <form  action="{{ route('elecciones.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            
            @csrf

            <input type="hidden" id="partido_h" name="partido_h" value="{{ old('partido_h') }}">
            <input type="hidden" id="coalicion_h" name="coalicion_h" value="{{ old('coalicion_h') }}">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="par_id" name="partidos_id" onchange="AsignaPartido()">
                    <option value="0" selected>Seleccione un partido</option>
                    @php($A = App\Partido::where('id', '>', 0)->orderby('name', 'ASC')->get())
                    @foreach($A as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Partido...</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="coa_id" name="coalicion_id" onchange="AsignaCoalicion()">
                    <option value="0" selected=>Seleccione una coalición</option>
                    @php($A = App\Coalicion::where('id', '>', 0)->orderby('name', 'ASC')->get())
                    @foreach($A as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Coalición...</label>
            </div>

            <input type="hidden" id="seccion_h" name="seccion_h" value="{{ old('seccion_h') }}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sec_id" name="secciones_id" onchange="AsignaSeccion()" required>
                    <option value="-" disabled="true"  selected="true">Seleccione una sección</option>
                    @php($A = App\Seccion::orderby('name', 'ASC')->get())
                    @foreach($A as $i)
                        <option value="{{ $i->id }}">{{ $i->municipio->name }} - {{ $i->name }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Sección...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="sample3" name="total" required value="{{ old('total') }}" pattern="[0-9 ]{1,150}">
                <label class="mdl-textfield__label" for="sample3">Tótal...</label>
            </div>
            
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
                <input type="checkbox" id="checkbox-1" name="remember" class="mdl-checkbox__input" {{ old('remember') ? 'checked' : '' }}>
                <span class="mdl-checkbox__label">Reutilizar información</span>
            </label>
            <br><br>

            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2">
                <input type="checkbox" id="checkbox-2" name="remember-q" class="mdl-checkbox__input" {{ old('remember-q') ? 'checked' : '' }}>
                <span class="mdl-checkbox__label">Guardar sin preguntar</span>
            </label>
            <br>
            <br>
            
            <button type="submit" id="btn-sub" class="hidden mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-A400">
                Guardar
            </button>
            <button type="button" id="btn-quest" onclick="question()" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-A400">
                Guardar
            </button>
            <button type="reset" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--red-A400">
                Borrar
            </button>
        </form>
    </div>
    <script>
        function ModCheck(){
            xx = $('#checkbox-2').is(':checked');
            if(xx){
                $('#btn-quest').addClass('hidden');
                $('#btn-sub').removeClass('hidden');
            }else{
                $('#btn-quest').removeClass('hidden');
                $('#btn-sub').addClass('hidden');
            }
        }
        $('#checkbox-2').on('click', function(){
            ModCheck();
        });

        function question(){
            alertify.confirm('Confirme para continuar...', 'Desea modificar algún campo? La información no se podrá modificar o eliminar una vez que la guarde. <br>Desea continuar?', 
                function(){
                    $('#btn-sub').click();
                },
                function(){});
        }

        function AsignaPartido() {
            $('#partido_h').val($('#par_id').val());
        }

        function AsignaCoalicion() {
            $('#coalicion_h').val($('#coa_id').val());
        }

        function AsignaSeccion() {
            $('#seccion_h').val($('#sec_id').val());
        }
        
        $(function () {
            ModCheck();
            var a = $('#partido_h');
            var b = $('#par_id');
            var x = a.val();
            var y = b.val();
            if (x.length > 0){
                b.val(x);
            }else{
                a.val(y);
            }

            var a = $('#coalicion_h');
            var b = $('#coa_id');
            var x = a.val();
            var y = b.val();
            if (x.length > 0){
                b.val(x);
            }else{
                a.val(y);
            }

            var a_ = $('#seccion_h');
            var b_ = $('#sec_id');
            var x_ = a_.val();
            var y_ = b_.val();
            if (x_.length > 0){
                b_.val(x_);
            }else{
                a_.val(y_);
            }
        });
    </script>



    <div id="tb-1" class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        @if(count($E) > 1)
            @include('-helpers-.inpt_SearchInTable')
        @endif
        <button id="btn-show" type="button" class=" mdl-button mdl-js-button mdl-raised-button mdl-color--blue mdl-color-text--white" onclick="show()">
            Agregar
        </button>
        
        <div class="mdl-cell mdl-cell--12-col">
            <h4>Resultados</h4>
            <div class="col-md-12 text-center">{{ $E->links() }}</div>
            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Municipio</th>
                        <th>Partido</th>
                        <th>Coalición</th>
                        <th>Sección</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($E) > 0)
                        @foreach($E as $i)
                            <tr>
                                <td>{{ $i->seccion->municipio->name }}</td>
                                <td>
                                    @if($i->partido_id != '')
                                        <span id="partido{{ $i->id }}">
                                            {{ $i->partido->name_small }}
                                        </span>
                                        <div class="mdl-tooltip" for="partido{{ $i->id }}">{{ $i->partido->name }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($i->coalicion_id != '')
                                        <span id="coalicion{{ $i->id }}">
                                            {{ $i->coalicion->name_small }}
                                        </span>
                                        <div class="mdl-tooltip" for="coalicion{{ $i->id }}">{{ $i->coalicion->name }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span id="seccion{{ $i->id }}">
                                        {{ $i->seccion->name }}
                                    </span>
                                    <div class="mdl-tooltip" for="seccion{{ $i->id }}">{{ $i->seccion->municipio->name }}</div>
                                </td>
                                <td>{{ $i->total }}</td>                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">
                                No hay resultados registrados
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 text-center">{{ $E->links() }}</div>
        </div>
    </div>
    @include('-helpers-.script_SearchOrderTable')

    @section('name', '#a-eleccion')
    @include('-helpers-.scr_Focus')


    @if(session('script'))
        <script type="text/javascript">
            $('#btn-show').click();
        </script>
    @endif
@endsection