<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mercado Pago - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Scripts -->
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            const mp = new MercadoPago("{{ getenv('MERCADO_PAGO_PUBLIC_KEY') }}", {
                locale: 'pt-BR',
            });
        </script>
    </head>
    <body class="bg-light bg-gradient">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-8 border-bootstrap box-shadow shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
                    @section('header')
                        <div class="text-center mb-5 display-1">
                            <h1 class="display-6">Mercado Pago <br><small class="text-muted lead">Exemplo de pagamento</small></h1>
                        </div>
                    @show


                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>
