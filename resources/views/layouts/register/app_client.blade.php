<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link href="{{ asset('client/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('client/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
</head>
<body>
   
    @include('layouts.register._register_content')
    
    @yield('content')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('client/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('client/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('client/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('client/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('client/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('client/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('client/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('client/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('client/js/main.js?v=').date('His') }}"></script>
</body>
</html>
