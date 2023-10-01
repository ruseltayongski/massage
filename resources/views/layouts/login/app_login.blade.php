<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.client.partials._client_css')
</head>
<body>    
    @yield('content')
    
    @include('layouts.client.partials._client_js')
</body>
</html>
