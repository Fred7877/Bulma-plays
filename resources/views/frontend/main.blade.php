<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>My Games Sites</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>

    <style>
        body {
            background: #222939;
            font-family: Roboto, serif;
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
    </style>


    @stack('css')

    @livewireStyles
</head>
<body>
@include('frontend.partials.nav-bar-top')

<div class="container mx-auto">
    @yield('content')
</div>

@livewireScripts
<script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
</body>
</html>

@stack('js')
