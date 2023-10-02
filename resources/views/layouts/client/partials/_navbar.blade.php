<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="@if(Auth::check()){{ route('client') }}@else{{ route('/') }}@endif" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-primary"><span class="text-dark">SPA</span> Center</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav m-auto py-0">
                @if(Auth::check())  
                <a href="{{ route('client') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client' ? 'active' : '' }}">Spa</a>
                <a href="{{ route('services') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'services' ? 'active' : '' }}">Services</a>
                <a href="{{ route('therapist') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'therapist' ? 'active' : '' }}">Therapist</a>
                <a href="{{ route('booking') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'booking' ? 'active' : '' }}">Booking</a>
                <a href="{{ route('booking.history') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'booking.history' ? 'active' : '' }}">Booking History</a>
                @else
                    <a href="{{ route('/') }}" class="nav-item nav-link {{ Route::currentRouteName() == '/' ? 'active' : '' }}" style="float:left;">Home</a>
                @endif
                <!-- 
                <a href="#" class="nav-item nav-link {{ Route::currentRouteName() == 'spa' ? 'active' : '' }}" style="float:left;">Spa</a>
                <a href="#" class="nav-item nav-link {{ Route::currentRouteName() == 'services' ? 'active' : '' }}" style="float:left;">Services</a> -->
                <!-- <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <a href="price.html" class="nav-item nav-link">Pricing</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="appointment.html" class="dropdown-item">Appointment</a>
                        <a href="opening.html" class="dropdown-item">Open Hours</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a> -->  
            </div>
        </div>
        @if(Auth::check())
            <div class="nav-item dropdown" style="float:right;">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $user->fname.' '.$user->lname }}</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary d-none d-lg-block">Login</a>
        @endif  
    </nav>
</div>
<!-- Navbar End -->
@section('js')
<script>
$(document).ready(function() {
    $(".nav-item.dropdown").hover(
        function() {
            event.preventDefault();
            console.log("hahaha");
        },
        function() {
            event.preventDefault();
            console.log("hehhehe");
        }
    );
});
</script>
@endsection