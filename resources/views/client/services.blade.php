@section('css')
    <style>
        /* CSS */
        .tag-price {
            position: absolute;
            top: 10px; 
            right: 5px; 
            background-color:red;
            padding:5px;
            transform: rotate(30deg);
        }
    </style>
@endsection
@extends('layouts.client.app_client')

@section('content')
    @if(!empty(session('spa_id')))
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Services</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.dashboard') }}">Click here to go back to the SPA page</a></p>
                </div>
            </div>
        </div>
        
        <div class="container-fluid px-0">
            <div class="row mx-0 justify-content-center text-center">
                <div class="col-lg-6">
                    <h6 class="d-inline-block bg-light text-primary text-uppercase py-1 px-2">Our Service</h6>
                    <h1>Spa & Beauty Services</h1>
                </div>
            </div>
            <div class="owl-carousel service-carousel">
                @foreach($services as $service)
                <div class="service-item position-relative">
                    <img class="img-fluid" src="{{ asset('/fileupload/services').'/'.$service->picture }}" alt="">
                    <div class="service-text text-center">
                        <h4 class="text-white font-weight-medium px-3">{{ $service->name }}</h4>
                        <p class="text-white px-3 mb-3">{{ $service->description }}</p>
                        <div class="w-100 bg-white text-center p-4" >
                            <a class="btn btn-primary" href="{{ route('client.therapist').'?&service='.$service->id.'&price='.$service->price }}">Select Service</a>
                        </div>
                    </div>
                    <div class="tag-price">
                        <strong class="text-white">₱&nbsp;{{ $service->price }}</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Services Not Found</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.dashboard') }}">Please click here to select a spa first</a></p>
                </div>
            </div>
        </div>
    @endif
@endsection
