@include('js-localization::head')
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Bulma-playz</title>
    @yield('js-localization.head')

    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900'
        rel='stylesheet' type='text/css'>

    <style>
        p, span.icon {
            font-size: 14px;
        }

        body {
            background: #222939;
            font-family: Roboto, serif;
            margin: 0;
            padding: 0;
        }

        .img-content {
            background: white;
        }

        label {
            color: #3273dc;
        }

        .block-filters {
            background: #323a45;
        }

        .pointer {
            cursor: pointer;
        }

        .loader-wrapper {
            transition: opacity .3s;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 6px;
        }

        .loader {
            height: 80px;
            width: 80px;
        }

        .is-active {
            opacity: 1;
            z-index: 1;
        }

        .word-break {
            word-break: break-all;
        }

        .has-display-none {
            display: none;
            visibility: hidden;
        }

        .cookie-consent {
            position: fixed;
            bottom: 0;
            z-index: 999;
            color: white;
            background-color: #0c525d;
            padding: 5px;
            font-weight: bold;
        }

        #wrap {
            min-height: 100%;
            width: 100%;
        }

        #footer {
            position: relative;
            bottom: 0;
            width: 100%;
            font-family: Roboto, sans-serif;
        }
    </style>

    @stack('css')

    @livewireStyles
    @routes
</head>
<body>
@include('frontend.partials.nav-bar-top')

<div id="wrap">
    <div class="container mx-auto ">
        @yield('content')
    </div>
</div>

@include('footer')
@include('cookieConsent::index')

@livewireScripts

<script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
@stack('js')

</body>
</html>
