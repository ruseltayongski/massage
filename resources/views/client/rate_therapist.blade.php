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

        .rate-container-for-submit {
            float: left;
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

    /* #half-stars-example {
        .rating-group {
            display: inline-flex;
        }

        .rating__icon {
            pointer-events: none;
        }

        .rating__input {
            position: absolute !important;
            left: -9999px !important;
        }

        .rating__label {
            cursor: pointer;
            padding: 0 0.1em;
            font-size: 2rem;
        }

        .rating__label--half {
            padding-right: -30px;
            margin-right: -20px;
            z-index: 2;
        }

        .rating__icon--star {
            color: orange;
        }

        .rating__icon--none {
            color: #eee;
        }

        .rating__input--none:checked + .rating__label .rating__icon--none {
        color: red;
        }

        .rating__input:checked ~ .rating__label .rating__icon--star {
        color: #ddd;
        }

        .rating-group:hover .rating__label .rating__icon--star,
        .rating-group:hover .rating__label--half .rating__icon--star {
            color: orange;
        }

        .rating__input:hover ~ .rating__label .rating__icon--star,
        .rating__input:hover ~ .rating__label--half .rating__icon--star {
        color: #ddd;
        }

        .rating-group:hover .rating__input--none:not(:hover) + .rating__label .rating__icon--none {
        color: #eee;
        }

        .rating__input--none:hover + .rating__label .rating__icon--none {
        color: red;
        }
    } */

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
                                        <input type="radio" value="5" {{ checkRatings(5,$ratings) }}/><label title="text">5 stars</label>
                                        <input type="radio" value="4" {{ checkRatings(4,$ratings) }}/><label title="text">4 stars</label>
                                        <input type="radio" value="3" {{ checkRatings(3,$ratings) }}/><label title="text">3 stars</label>
                                        <input type="radio" value="2" {{ checkRatings(2,$ratings) }}/><label title="text">2 stars</label>
                                        <input type="radio" value="1" {{ checkRatings(1,$ratings) }}/><label title="text">1 star</label>
                                    </div>
                                </div>
                            </form>
                            <div class="header card-header">
                                <span>Feedback History</span>
                            </div>
                            <ul class="list-group">
                                @foreach($feedbacks as $feedback)
                                <li class="list-group-item">
                                    <strong>{{ $feedback->feedback_by }}</strong>
                                    <small class="card-text">{{ $feedback->therapist_feedback }}</small>
                                </li>
                                @endforeach
                            </ul>
                            {{-- <div id="half-stars-example">
                                <div class="rating-group">
                                    <input class="rating__input rating__input--none" checked name="rating2" id="rating2-0" value="0" type="radio">
                                    <label aria-label="0 stars" class="rating__label" for="rating2-0">&nbsp;</label>
                                    <label aria-label="0.5 stars" class="rating__label rating__label--half" for="rating2-05"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-05" value="0.5" type="radio">
                                    <label aria-label="1 star" class="rating__label" for="rating2-10"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-10" value="1" type="radio">
                                    <label aria-label="1.5 stars" class="rating__label rating__label--half" for="rating2-15"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-15" value="1.5" type="radio">
                                    <label aria-label="2 stars" class="rating__label" for="rating2-20"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-20" value="2" type="radio">
                                    <label aria-label="2.5 stars" class="rating__label rating__label--half" for="rating2-25"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-25" value="2.5" type="radio" checked>
                                    <label aria-label="3 stars" class="rating__label" for="rating2-30"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-30" value="3" type="radio">
                                    <label aria-label="3.5 stars" class="rating__label rating__label--half" for="rating2-35"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-35" value="3.5" type="radio">
                                    <label aria-label="4 stars" class="rating__label" for="rating2-40"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-40" value="4" type="radio">
                                    <label aria-label="4.5 stars" class="rating__label rating__label--half" for="rating2-45"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-45" value="4.5" type="radio">
                                    <label aria-label="5 stars" class="rating__label" for="rating2-50"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-50" value="5" type="radio">
                                </div>
                            </div> --}}

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
                        
                        <div class="card mb-4">
                            <div class="header card-header">
                                <span>Feedback and Rating</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="feedback">Your Feedback</label>
                                    <textarea class="form-control" id="therapist_feedback" name="therapist_feedback" rows="4" required></textarea>
                                </div>
                                <strong>How would you rate your overall experience?</strong>
                                <form id="ratingFormSubmit">
                                    <div class="rate-container-for-submit">
                                        <div class="rate">
                                            <input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" /><label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="text">1 star</label>
                                        </div>
                                    </div>
                                </form>
                                <br><br><br>
                                <button type="button" class="btn btn-primary" onclick="submitFeedback()">Submit</button>
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
    var rating = 0;
    document.addEventListener("DOMContentLoaded", function () {
        var ratingForm = document.getElementById("ratingForm");
        ratingForm.addEventListener("click", function (event) {
            // Prevent the default form submission behavior
            event.preventDefault();
        });

        var ratingFormSubmit = document.getElementById("ratingFormSubmit");
        ratingFormSubmit.addEventListener("click", function (event) {
            if (event.target.tagName === "LABEL") {
                var associatedRadio = document.getElementById(event.target.getAttribute("for"));
                associatedRadio.checked = true;
                rating = associatedRadio.value;
            }
            event.preventDefault();
        });
    });

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
        var results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function submitFeedback() {
        const feedback = $("#therapist_feedback").val();
        if(!feedback) {
            alert("Feedback is required!");
            return;
        }
        else if(!rating) {
            alert("Rating is required!");
            return;
        }

        const url = "{{ route('client.rate.therapist.save') }}";
        var formData = new FormData();
        formData.append('therapist_id', getUrlParameter('therapist_id'));
        formData.append('therapist_feedback', feedback);
        formData.append('rate', rating);

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (result) {
                if(result) {
                    window.location.href="{{ route('client.booking.history') }}";
                    //location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endsection
