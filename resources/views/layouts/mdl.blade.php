<!doctype html>
<html lang="es">
    <head>
        <title>SIMOP</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"  content="IE=edge">
        <meta name="viewport"               content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <meta name="csrf-token"             content="{{ csrf_token() }}">
        <?php /*
        <!--meta property="og:url"             content="https://candymanx.com/simop" />
        <meta property="og:type"            content="product" />
        <meta property="og:locale"          content="es_MX" />
        <meta property="og:title"           content="Sistemas a medida para el monitoreo, almacenamiento y computación de datos." />
        <meta property="og:description"     content="Los problemas comunes con apariencia dificultosa se pueden eliminar con una plataforma de apoyo para tu negocio." /-->
        */?>
        <meta property="og:image"           content="https://candymanx.com/simop/simop/public/plugins/img/SIMOP-G.png" />
        <meta property="og:site_name"       content="CandyManX - SIMOP" />
        <?php /*
        <!--meta property="article:published_time" content="2018-06-09T05:59:00+01:00" />
        <meta property="article:modified_time" content="2018-06-09T19:08:47+01:00" />
        <meta property="article:section"    content="Sección del artículo" />
        <meta property="article:tag"        content="Etiqueta del artículo" />
        <meta property="fb:admins"          content="ID numérico de Facebook" />

        <meta name="twitter:card"           content="summary">
        <meta name="twitter:site"           content="https://candymanx.com">
        <meta name="twitter:title"          content="CandyManX - SIMOP">
        <meta name="twitter:description"    content="Los problemas comunes con apariencia dificultosa se pueden eliminar con una plataforma de apoyo para tu negocio.">
        <meta name="twitter:creator"        content="CandyManX">
        <meta name="twitter:image"          content="https://candymanx.com/simop/simop/public/plugins/img/SIMOP-G.png">
        <meta name="twitter:image:src"      content="https://candymanx.com/simop/simop/public/plugins/img/SIMOP-G.png">

        <meta itemprop="name"               content="CandyManX">
        <meta itemprop="description"        content="Los problemas comunes con apariencia dificultosa se pueden eliminar con una plataforma de apoyo para tu negocio.">
        <meta itemprop="image"              content="https://candymanx.com/simop/simop/public/plugins/img/SIMOP-G.png"-->
        */

        $cssMicons = "mdl-color-text--blue-grey-400 material-icons";
        $cssNavLinks = "mdl-navigation__link mdl-color-text--blue-grey-600";
        $dinamicIcon = 'class=&quot;'.$cssMicons.'&quot; role="presentation"';

        ?>

        <link rel="icon" type="image/png" href="{{ env('LOGO') }}"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{ env('LOGO') }}"/>
        
        @yield('CssOnTop')
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}bootstrap-3.3.7/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}alertifyjs/css/alertify.min.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}alertifyjs/css/themes/default.min.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}mdl/css/grid.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}mdl/css/dash.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}mdl/font/css.css">
        <link type="text/css" rel="stylesheet" href="{{ env('PUB') }}css/css.css">
                
        @yield('ScriptOnTop')
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}jquery/js/slim-min-3.2.1.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}bootstrap-3.3.7/js/bootstrap.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}ajax/js/js-2.2.4.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}alertifyjs/alertify.min.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}tablesorter-master/jquery.tablesorter.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}jquey-rotate/jquery-rotate.js"></script>
        <script type="text/javascript" rel="script" src="{{ env('PUB') }}jquery-livefilter/jquery.liveFilter.js"></script>
    </head>
    <body>
        <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title date-title">{{ \App\Http\Controllers\FechaController::DMA() }} - Bienvenido {{ Auth::user()->email }}</span>
                    <div class="mdl-layout-spacer"></div>
                    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                        <li class="mdl-menu__item" onclick="window.location.href = '{{ route('user.MiPerfil') }}'">Mi perfil</li>
                        <li class="mdl-menu__item" onclick="document.getElementById('logout-form').submit();">Salir</li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </ul>
                </div>
            </header>
            <div class="demo-drawer mdl-layout__drawer">
                <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-900">
                    <a id="a-inicio" class="{{ $cssNavLinks }}" href="{{ route('home') }}">
                        <i class="{{ $cssMicons }}" role="presentation">equalizer</i>Historico
                    </a>

                    <a id="a-eleccion" class="{{ $cssNavLinks }}" href="{{ route('elecciones.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">query_stats</i>Resultados
                    </a>

                    <a id="a-lideres" class="{{ $cssNavLinks }}" href="{{ route('lider.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">person_pin</i>Activistas
                    </a>

                    <a id="a-addsc" class="{{ $cssNavLinks }}" href="{{ route('adscritos.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">group_add</i>Simpatizantes
                    </a>

                    <a id="a-partido" class="{{ $cssNavLinks }}" href="{{ route('partido.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">outlined_flag</i>Partidos
                    </a>

                    <a id="a-coalicion" class="{{ $cssNavLinks }}" href="{{ route('coalicion.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">transform</i>Coaliciones
                    </a>

                    <a id="a-secciones" class="{{ $cssNavLinks }}" href="{{ route('seccion.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">how_to_vote</i>Casillas
                    </a>

                    <a id="a-secciones" class="{{ $cssNavLinks }}" href="{{ route('seccion.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">extension</i>Secciones
                    </a>

                    <a id="a-municipios" class="{{ $cssNavLinks }}" href="{{ route('municipio.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">crop_free</i>Municipios
                    </a>

                    <a id="a-anios" class=" hidden {{ $cssNavLinks }}" href="{{ route('anio.index') }}">
                        <i class="{{ $cssMicons }}" role="presentation">timeline</i>Años
                    </a>
                </nav>
            </div>
            <div class="mdl-layout__content mdl-color--grey-100">
                <div class="mdl-grid demo-content">
                    @yield('content')
                </div>
            </div>
        </div>
        <script src="{{ env('PUB') }}mdl/js/grid.js"></script>
        @yield('ScriptOnBottom')
    </body>
</html>