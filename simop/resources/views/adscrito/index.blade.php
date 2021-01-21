@extends('layouts.mdl')

@section('content')
    <div class="col-md-12">
        @include('-helpers-.errors')
        @include('-helpers-.error')
        @include('-helpers-.ok')
    </div>

    <div id="form-result" class="hidden demo-charts mdl-color--white mdl-shadow--2dp mdl-cell--4-offset mdl-cell mdl-cell--4-col mdl-grid">
        <button id="btn-hide" class="mdl-button mdl-js-button mdl-button--icon" onclick="hide()">
            <i class="material-icons">keyboard_arrow_up</i>
        </button>
        Simpatizante
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


        <form  action="{{ route('adscritos.store') }}" method="POST" class="mdl-cell mdl-cell--12-col">
            @csrf

            <input type="hidden" id="lid_h" name="lid_h" value="{{ old('lid_h') }}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="lid_id" name="lideres_id" onchange="AsignaLider()" required>
                    <option value="-" disabled="true"  selected="true">Seleccione un activista</option>
                    @foreach($Lid as $i)
                        <option value="{{ $i->id }}">{{ $i->name }} {{ $i->apat }} {{ $i->amat }}</option>
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Activista</label>
            </div>

            <input type="hidden" id="sec_h" name="sec_h" value="{{ old('lid_h') }}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="sec_id" name="secciones_id" onchange="AsignaSeccion()" required>
                    <option value="-" disabled="true"  selected="true">Seleccione una sección</option>
                    @foreach($Mun as $i)
                        @foreach($i->secciones as $s)
                            <option value="{{ $s->id }}">{{ $s->municipio->name }} - {{ $s->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <label class="mdl-textfield__label" for="sample5">Sección</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="nom" value="{{ old('nom') }}" required>
                <label class="mdl-textfield__label" for="sample3">Nombre(s)...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="apa" value="{{ old('apa') }}" required>
                <label class="mdl-textfield__label" for="sample3">Apellido Paterno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="ama" value="{{ old('ama') }}" required>
                <label class="mdl-textfield__label" for="sample3">Apellido Materno...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="ife" value="{{ old('ife') }}" required>
                <label class="mdl-textfield__label" for="sample3">IFE / INE...</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="dir" value="{{ old('dir') }}" required>
                <label class="mdl-textfield__label" for="sample3">Dirección...</label>
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
            <br><br>
            
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
            alertify.confirm('Confirme para continuar...', 'Por favor verifique la información, ya que no se podrá modificar o eliminar una vez que la guarde. <br>Desea continuar?', 
                function(){
                    $('#btn-sub').click();
                },
                function(){});
        }

        function AsignaLider() {
            $('#lid_h').val($('#lid_id').val());
        }

        function AsignaSeccion() {
            $('#sec_h').val($('#sec_id').val());
        }

        
        $(function () {
            ModCheck();
            var a = $('#lid_h');
            var b = $('#lid_id');
            var x = a.val();
            var y = b.val();
            if (x.length > 0){
                b.val(x);
            }else{
                a.val(y);
            }

            var a_ = $('#sec_h');
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
        @if(count($Ads) > 1)
            @include('-helpers-.inpt_SearchInTable')
        @endif
        <button id="btn-show" type="button" class=" mdl-button mdl-js-button mdl-raised-button mdl-color--blue mdl-color-text--white" onclick="show()">
            Agregar
        </button>
        <div class="mdl-cell mdl-cell--12-col">
            <h4>Simpatizantes</h4>

            <div class="col-md-12 text-center"> {{ $Ads->links() }} </div>
            <table id="tabla" class="table mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <th>Municipio</th>
                        <th>Sección</th>
                        <th>Activista</th>
                        <th>Simpatizante</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($Ads) > 0)
                        @foreach($Ads as $i)
                            <tr>
                                <td>{{ $i->seccion->municipio->name }}</td>
                                <td>{{ $i->seccion->name }}</td>
                            
                                <td> {{ $i->lider->name }} {{ $i->lider->apat }} {{ $i->lider->amat }} </td>
                                <td> {{ $i->militante->name }} {{ $i->militante->apat }} {{ $i->militante->amat }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                No hay adscritos registrados
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 text-center"> {{ $Ads->links() }} </div>

        </div>
    </div>
    @include('-helpers-.script_SearchOrderTable')

    @section('name', '#a-addsc')
    @include('-helpers-.scr_Focus')

    @if(session('script'))
        <script type="text/javascript">
            $('#btn-show').click();
        </script>
    @endif
@endsection