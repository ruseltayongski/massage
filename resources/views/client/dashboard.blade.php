@section('css')
<style>
    /* Add custom CSS styles */
    .team {
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out;
        cursor:pointer;
    }

    .team:hover {
        transform: scale(1.05);
    }

    .team img {
        width: 100%;
        height: auto;
    }

    .team-text {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
    }

    .team-text h5 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .team-text p {
        font-size: 14px;
        margin: 0;
    }

    .team-social {
        background-color: #343a40;
        padding: 10px;
    }

    .btn-square {
        width: 100px;
        border-radius: 0;
    }

    .tag-rating {
        position: absolute;
        top: 0; 
        right: 0; 
        background-color:white;
        padding:5px;
        /* transform: rotate(30deg); */
        z-index: 1;
        /* opacity: 0.8; */
        width: 100%
    }


    *{
        margin: 0;
        padding: 0;
    }

    .rate-container {
        display: grid;
        place-content: center;
    }

    .rate-container-for-submit {
        float: left;
    }

    .rate {
        height: 35px;
        padding: 0 10px;
        margin-top: -10px; 
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }

    .rate > input:checked ~ label {
        color: #ffc700; 
    }

    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
</style>
@endsection
@extends('layouts.client.app_client')

@section('content')
    <?php
        if (!function_exists('checkRatings')) {
            function checkRatings($value,$ratings) {
                return $value == $ratings ? 'checked' : '';
            }
        }
    ?>
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
       
        <div class="container">
            <form {{-- action="{{ route('owner/services') }}" --}} method="GET">
                <div class="input-group mb-3 mt-3">
                    <input type="search" id="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <div class="button-holder pl-3">
                        <button type="submit" name="search_button" class="btn btn-outline-primary">Search</button>
                        <button type="submit" name="reset_button" class="btn btn-outline-secondary">View All</button>
                    </div>
                </div>
            </form>
            <div class="row">
                @foreach($spas as $spa)
                <div class="col-lg-3 col-md-6">
                    <div class="team position-relative overflow-hidden mb-5">
                        <img class="img-fluid" src="{{ asset('/fileupload/spa').'/'.$spa->picture }}" alt="">
                        <div class="position-relative text-center">
                            <div class="team-text bg-primary text-white">
                                <h5 class="text-white text-uppercase">{{ $spa->name }}</h5>
                                <p class="m-0">{{ $spa->description }}</p>
                            </div>
                            <div class="team-social bg-dark text-center">
                                <a class="btn btn-outline-primary btn-square" href="{{ route('client.services').'?spa='.$spa->id }}">SELECT</i></a>
                            </div>
                        </div>
                        <div class="tag-rating">
                            <form id="ratingForm">
                                <div class="rate-container">
                                    <div class="rate">
                                        <input type="radio" value="5" {{ checkRatings(5,$spa->ratings_spa) }}/><label title="text">5 stars</label>
                                        <input type="radio" value="4" {{ checkRatings(4,$spa->ratings_spa) }}/><label title="text">4 stars</label>
                                        <input type="radio" value="3" {{ checkRatings(3,$spa->ratings_spa) }}/><label title="text">3 stars</label>
                                        <input type="radio" value="2" {{ checkRatings(2,$spa->ratings_spa) }}/><label title="text">2 stars</label>
                                        <input type="radio" value="1" {{ checkRatings(1,$spa->ratings_spa) }}/><label title="text">1 star</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
