<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/error.css') }}">
    <script src="{{ asset('js/error.js') }}" defer></script>
</head>
<body>
    <main>
        <div class="container">

                @yield('image')

            <div class="info">
                @yield('content')
            </div>
        </div>
        <div class="ebck">
            <div>
                @yield('error')
            </div>
        </div>
    </main>
</body>
</html>
