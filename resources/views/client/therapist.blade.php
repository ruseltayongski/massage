@extends('layouts.client.app_client')

@section('content')
    @if(isset($spa_id))
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Therapist</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-white" href="">Select</a></p>
                    <i class="far fa-circle px-3"></i>
                    <p class="m-0">Therapist</p>
                </div>
            </div>
        </div>
        @include('layouts.client.partials._therapist') 
    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Therapist Not Found</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client') }}">Please click here to select a spa first</a></p>
                </div>
            </div>
        </div>
    @endif
@endsection
