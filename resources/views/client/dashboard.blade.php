@extends('layouts.client.app_client')

@section('content')
    <div class="jumbotron jumbotron-fluid bg-jumbotron">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Spa Store</h3>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="">Select</a></p>
                <i class="far fa-circle px-3"></i>
                <p class="m-0">Spa</p>
            </div>
        </div>
    </div>
    {{--
    @include('layouts.client.partials._about')
    @include('layouts.client.partials._service')
    @include('layouts.client.partials._openhours')
    @include('layouts.client.partials._pricingstart')
    --}}
    @include('layouts.client.partials._spa') 
@endsection
