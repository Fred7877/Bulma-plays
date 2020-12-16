<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit game</title>

    @stack('css')

    @livewireStyles
    @routes
</head>
<body>

<div class="container">
    @yield('content')
</div>

@livewireScripts

<script src="{{ asset('js/app.js') }}"></script>
@stack('js')

</body>
</html>
