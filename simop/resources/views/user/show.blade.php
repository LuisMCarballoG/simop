@extends('layouts.mdl')
@section('content')
    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <!-- Accent-colored raised button with ripple -->
        @section('BackAction', route('user.index'))
        @include('-helpers-.btn_Back')

        <div class="mdl-cell mdl-cell--12-col">
            @include('-helpers-.ok')
            @include('-helpers-.error')
            <h4>{{ $U->name }}</h4>
            <table class="table  mdl-cell mdl-cell--12-col">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Aceptado</td>
                        <td>
                            @if($U->aceptado == 'Y')
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--green" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso concedido.">
                                    <i class="material-icons">check</i>
                                </button>
                            @else
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso denegado.">
                                    <i class="material-icons">block</i>
                                </button>
                            @endif
                        </td>
                        <td>
                            @if($U->aceptado == 'Y')
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                                    <input type="checkbox" id="switch-1" class="mdl-switch__input" checked onclick="Asigna('Bloquear', 'Acceder al sistema', 'aceptado', 'N', 'switch-1', '');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @else
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                                    <input type="checkbox" id="switch-1" class="mdl-switch__input" onclick="Asigna('Conceder', 'Acceder al sistema', 'aceptado', 'Y', 'switch-1', '');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Registrar</td>
                        <td>
                            @if($U->crear == 'Y')
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--green" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso concedido.">
                                    <i class="material-icons">check</i>
                                </button>
                            @else
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso denegado.">
                                    <i class="material-icons">block</i>
                                </button>
                            @endif
                        </td>

                        <td>
                            @if($U->crear == 'Y')
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                                    <input type="checkbox" id="switch-2" class="mdl-switch__input" checked onclick="Asigna('retirar', 'Registrar', 'crear', 'N', 'switch-2');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @else
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                                    <input type="checkbox" id="switch-2" class="mdl-switch__input" onclick="Asigna('otorgar', 'Registrar', 'crear', 'Y', 'switch-2');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Actualizar</td>
                        <td>
                            @if($U->editar == 'Y')
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--green" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso concedido.">
                                    <i class="material-icons">check</i>
                                </button>
                            @else
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso denegado.">
                                    <i class="material-icons">block</i>
                                </button>
                            @endif
                        </td>
                        <td>
                            @if($U->editar == 'Y')
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
                                    <input type="checkbox" id="switch-3" class="mdl-switch__input" checked onclick="Asigna('retirar', 'actualizar', 'editar', 'N', 'switch-3');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @else
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
                                    <input type="checkbox" id="switch-3" class="mdl-switch__input" onclick="Asigna('otorgar', 'actualizar', 'editar', 'Y', 'switch-3');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Eliminar</td>
                        <td>
                            @if($U->borrar == 'Y')
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--green" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso concedio.">
                                    <i class="material-icons">check</i>
                                </button>
                            @else
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red" data-placement="bottom" data-toggle="popover" data-trigger="focus" data-html="true" data-content="Permiso denegado.">
                                    <i class="material-icons">block</i>
                                </button>
                            @endif
                        </td>
                        <td>
                            @if($U->borrar == 'Y')
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-4">
                                    <input type="checkbox" id="switch-4" class="mdl-switch__input" checked onclick="Asigna('retirar', 'eliminar', 'borrar', 'N', 'switch-4');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @else
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-4">
                                    <input type="checkbox" id="switch-4" class="mdl-switch__input" onclick="Asigna('otorgar', 'eliminar', 'borrar', 'Y', 'switch-4');">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form_Permiso" action="{{ route('user.Permisos', $U->id) }}" method="post">
        @csrf
        <input id="permiso" type="hidden" name="permiso">
        <input id="grant" type="hidden" name="grant">
    </form>
    <script>
        function Asigna(x,a,b,c,d) {
            alertify.confirm("Confirme para continuar...","Esta a punto de <b>"+x+"</b> el permiso de <b>"+a+"</b>. Desea continuar ?",
                function(){
                    $('#permiso').val(b);
                    $('#grant').val(c);
                    $('#form_Permiso').submit();
                },
                function(){
                    $('#'+d).click();
                });
        }
        function Acepta(x,a,b,c,d) {
            alertify.confirm("Confirme para continuar...","Esta a punto de <b>"+x+"</b> el permiso de <b>"+a+"</b>. Desea continuar ?",
                function(){
                    $('#permiso').val(b);
                    $('#grant').val(c);
                    $('#form_Permiso').submit();
                },
                function(){
                    $('#'+d).click();
                });
        }
    </script>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>
    @section('name', '#a-usuarios')
    @include('-helpers-.scr_Focus')
@endsection