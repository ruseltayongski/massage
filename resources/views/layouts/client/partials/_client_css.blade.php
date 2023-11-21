<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Free HTML Templates" name="keywords">
<meta content="Free HTML Templates" name="description">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Favicon -->
<link href="{{ asset('favicon.ico') }}" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />

<!-- Libraries Stylesheet -->
<link href="{{ asset('client/lib/animate/animate.min.css') }}" rel="stylesheet">
<link href="{{ asset('client/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('client/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('client/css/style.css') }}" rel="stylesheet">

<!-- LOBIBOX -->
<link rel="stylesheet" href="{{ asset('plugin/lobibox/dist/css/LobiBox.min.css') }}">

@yield('css')