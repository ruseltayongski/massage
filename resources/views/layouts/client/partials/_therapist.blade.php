<style>
    *{
        margin: 0;
        padding: 0;
    }
    .rate {
        float: left;
        height: 46px;
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
<div class="container-fluid ">
    <div class="container ">
        <div class="row">
            @foreach($therapists as $therapist)
            <div class="col-lg-3 col-md-6">
                <div class="team position-relative overflow-hidden mb-5" style="cursor:pointer;">
                    <img class="img-fluid" src="{{ asset('/fileupload/therapist/profile').'/'.$therapist->picture }}" alt="">
                    <div class="position-relative text-center">
                        <div class="team-text bg-primary text-white">
                            <h5 class="text-white text-uppercase">{{ $therapist->fname.' '.$therapist->lname }}</h5>
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4"/><label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="text">1 star</label>
                            </div>
                        </div>
                        <div class="team-social bg-dark text-center">
                            <a class="btn btn-outline-primary btn-square" href="{{ route('booking').'?spa='.$spa_id.'&service='.$service_id.'&therapist='.$therapist->id }}" style="width:100px;">SELECT</i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
