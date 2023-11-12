<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5 pb-5">
    <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#header-carousel" data-slide-to="1"></li>
            <li data-target="#header-carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item position-relative active" style="min-height: 100vh;">
                <img class="position-absolute w-100 h-100" src="{{ asset('client/img/carousel-1.jpg') }}" style="object-fit: cover;">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h6 class="text-white text-uppercase mb-3 animate__animated animate__fadeInDown" style="letter-spacing: 3px;">Spa & Beauty Center</h6>
                        <h3 class="display-3 text-capitalize text-white mb-3">Massage Treatment</h3>
                        {{-- <p class="mx-md-5 px-5">Lorem rebum magna dolore amet lorem eirmod magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum labore diam</p> --}}
                        <a class="btn btn-outline-light py-3 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ route('client.dashboard') }}">Make Appointment</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item position-relative" style="min-height: 100vh;">
                <img class="position-absolute w-100 h-100" src="{{ asset('client/img/carousel-2.jpg') }}" style="object-fit: cover;">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h6 class="text-white text-uppercase mb-3 animate__animated animate__fadeInDown" style="letter-spacing: 3px;">Spa & Beauty Center</h6>
                        <h3 class="display-3 text-capitalize text-white mb-3">Facial Treatment</h3>
                       {{--  <p class="mx-md-5 px-5">Lorem rebum magna dolore amet lorem eirmod magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum labore diam</p> --}}
                        <a class="btn btn-outline-light py-3 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ route('client.dashboard') }}">Make Appointment</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item position-relative" style="min-height: 100vh;">
                <img class="position-absolute w-100 h-100" src="{{ asset('client/img/carousel-3.jpg') }}" style="object-fit: cover;">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h6 class="text-white text-uppercase mb-3 animate__animated animate__fadeInDown" style="letter-spacing: 3px;">Spa & Beauty Center</h6>
                        <h3 class="display-3 text-capitalize text-white mb-3">Cellulite Treatment</h3>
                        {{-- <p class="mx-md-5 px-5">Lorem rebum magna dolore amet lorem eirmod magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum labore diam</p> --}}
                        <a class="btn btn-outline-light py-3 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ route('client.dashboard') }}">Make Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->