<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="env" content="{{ env('APP_ENV') }}">
    @stack('styles')
    <title>@yield('title')</title>
</head>

<body>
    @yield('body')
    @stack('scripts')
</body>

</html>
