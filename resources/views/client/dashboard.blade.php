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
    <div class="container-fluid ">
        <div class="container ">
            <div class="row">
                @foreach($spas as $spa)
                <div class="col-lg-3 col-md-6">
                    <div class="team position-relative overflow-hidden mb-5" style="cursor:pointer;">
                        <img class="img-fluid" src="{{ asset('/fileupload/spa').'/'.$spa->picture }}" alt="">
                        <div class="position-relative text-center">
                            <div class="team-text bg-primary text-white">
                                <h5 class="text-white text-uppercase">{{ $spa->name }}</h5>
                                <p class="m-0">{{ $spa->description }}</p>
                            </div>
                            <div class="team-social bg-dark text-center">
                                <a class="btn btn-outline-primary btn-square" href="{{ route('services').'?spa='.$spa->id }}" style="width:100px;">SELECT</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
