<style>
    #div-banned-user{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 100000000000000000000000000000;
    }
</style>
<div id="div-banned-user" class="text-center mdl-color-text--white">
    <h2>Bienvenido</h2>
    <br>
    <h6>
    Por ahora usted no puede hacer uso de este portal. Le invitamos a cerrar su sesión. <br>
    Gracias <br>
    </h6>
    <!-- Primary-colored flat button -->
    <button class="mdl-button mdl-js-button mdl-button--primary" onclick="document.getElementById('logout-form').submit();">
        Aceptar
    </button>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>