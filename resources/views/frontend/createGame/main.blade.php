<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Create custom game</title>

    <style>
        p, span {
            font-size: 14px;
        }

        body {
            background: #222939;
            font-family: Roboto, serif;
            padding-bottom: 35px;
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
    </style>

    @stack('css')

    @livewireStyles
    @routes
</head>
<body>

<div class="container">
    @yield('content')
</div>

@livewireScripts

<script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('js')

</body>
</html>
