@section('css')
    <style>
        .img-account-profile {
            height: 220px;
            width: 100px;
        }

        *{
            margin: 0;
            padding: 0;
        }
        .rate-container {
            display: grid;
            place-content: center;
        }
        .rate {
            height: 70px;
            padding: 0 10px;
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
            font-size:40px;
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
    @if(isset($therapist))
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">{{ $therapist->fname.' '.$therapist->lname }}</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-white" href="">Rate</a></p>
                    <i class="far fa-circle px-3"></i>
                    <p class="m-0">Therapist</p>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="container-xl px-3">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                @if(empty($therapist->picture))
                                    <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                @else
                                    <img
                                        class="img-account-profile rounded-circle mb-2 w-75" 
                                        src="{{ asset('/fileupload/therapist/profile/').'/'. $therapist->picture }}" 
                                        alt=""
                                        id="picture"
                                        name="picture"
                                        >
                                @endif
                            </div>
                            <form id="ratingForm">
                                <div class="rate-container">
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5"/><label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" checked/><label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </form>                            
                            {{-- <form id="ratingForm">
                                <div class="rate-container">
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="5 stars">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" /><label for="star4" title="4 stars">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="3 stars">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="2 stars">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="1 star">1 star</label>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="header card-header">
                                <span>Account Details</span>
                            </div>
                            
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">First name</label>
                                        <p class="text-info"><strong>{{ $therapist->fname }}</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Last name</label>
                                        <p class="text-info"><strong>{{ $therapist->lname }}</strong></p>
                                    </div>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Mobile Number</label>
                                        <p class="text-info"><strong>{{ $therapist->mobile }}</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Address</label>
                                        <p class="text-info"><strong>{{ $therapist->address }}</strong></p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <p class="text-info"><strong>{{ $therapist->email }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Therapist Not Selected</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.booking.history') }}">Please select therapist first</a></p>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ratingForm = document.getElementById("ratingForm");

        ratingForm.addEventListener("click", function (event) {
            // Prevent the default form submission behavior
            event.preventDefault();
        });
    });

    // const averageRating = 4.5;
    // const starContainer = document.querySelector(".rate");

    // // Calculate the number of full stars and half stars
    // const fullStars = Math.floor(averageRating);
    // const hasHalfStar = averageRating % 1 !== 0;

    // // Set the full stars
    // for (let i = 1; i <= 5; i++) {
    //     const starInput = document.getElementById(`star${i}`);
    //     const starLabel = starInput.nextElementSibling;

    //     if (i <= fullStars) {
    //         starInput.checked = true;
    //     } else {
    //         starInput.checked = false;
    //     }
    // }

    // // Add half-star if needed
    // if (hasHalfStar) {
    //     const halfStar = document.createElement("span");
    //     halfStar.className = "half-star";
    //     starContainer.appendChild(halfStar);
    // }
    
</script>
@endsection
