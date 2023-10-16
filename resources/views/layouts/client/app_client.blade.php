<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.client.partials._client_css')
</head>
<body>
    <input type="hidden" id="asset" value="{{ asset('/') }}">
    <?php $user = Auth::user(); ?>
    @include('layouts.client.partials._topbar')
    @include('layouts.client.partials._navbar')
    
    @yield('content')
   
    @if(request()->route()->getName() !== 'client.profile')
        @include('layouts.client.partials._testimonial')
    @endif
    @include('layouts.client.partials._footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    @include('layouts.client.partials._client_js')
</body>
</html>
