<!doctype html>
<html lang="es">
    <head>
        <title>SIMOP - Sistema de Monitoreo Partidario</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{env('LOGO')}}"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{env('LOGO')}}"/>

        <meta property="og:url" content="http://simop.luismcarballog.site" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Sistema de monitoreo partidario" />
		<meta property="og:description" content="Sistema de gestión del personal adjunto y simpatizantes." />
		<meta property="og:image" content="https://candymanx.com/gallery_gen/7e4f7f14d60556a82b4459935c67cf21_110x110.png" /-->
        
        <link rel="stylesheet" href="{{ env('PUB') }}bootstrap-3.3.7/css/bootstrap.css">
        <script type="text/javascript" src="{{ env('PUB') }}jquery/js/slim-min-3.2.1.js"></script>
        <script type="text/javascript" src="{{ env('PUB') }}bootstrap-3.3.7/js/bootstrap.js"></script>
    </head>
    <body class="text-center">
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        @yield('content')
    </body>
</html>