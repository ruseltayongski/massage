<?php
    use App\Models\Testimonials;
    use App\Models\Ratings;
    use Illuminate\Support\Facades\DB;
    
    $testimonials = Testimonials::select(
                        DB::raw("concat(users.fname,' ',users.lname) as name"),
                        'users.picture as user_profile',
                        'users.roles',
                        'testimonials.description'
                    )
                    ->leftJoin('users','users.id','=','testimonials.user_id')
                    ->get();


    $spaFeedback = Ratings::select(
                        DB::raw("concat(users.fname, ' ',users.lname) as name"),
                        'users.picture as user_profile',
                        'users.roles',
                        'ratings.feedback',
                        'spa.name as spa_name',
                        
                    )
                    ->where('therapist_id', null)
                    ->leftJoin('users', 'users.id', '=', 'ratings.feedback_by')
                    ->leftJoin('spa', 'spa.id', '=', 'ratings.spa_id')
                    ->get();

    $therspistFeedback = Ratings::select(
        DB::raw("concat(users.fname, ' ',users.lname) as name"),
        DB::raw("concat(therapist.fname, ' ',therapist.lname) as therapist_name"),
        'users.picture as user_profile',
        'users.roles',
        'ratings.therapist_feedback',
        
    )
    ->where('ratings.spa_id', null)
    ->leftJoin('users', 'users.id', '=', 'ratings.feedback_by')
    ->leftJoin('users as therapist', 'therapist.id', '=', 'ratings.therapist_id')
    ->get();

?>
<style>
    .feedback-holder {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .indicator-arrow {
        display: inline-block;
        margin-left: 20px; 
        font-size: 100px;
    }

    .spa-holder p {
        text-align: center;
    }
    
</style>
<!-- Testimonial Start -->
@if(request()->route()->getName() === '/')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('client/img/testimonial.jpg') }}" alt="">
            </div>
            <div class="col-lg-6">
                <h6 class="d-inline-block text-primary text-uppercase bg-light py-1 px-2">Testimonials</h6>
                <h1 class="mb-4">What Our Clients Say!</h1>
                <div class="owl-carousel testimonial-carousel">
                  
                    @foreach($testimonials as $testimonial)
                    <div class="position-relative">
                        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
                        <div class="d-flex align-items-center mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('fileupload/client/profile').'/'.$testimonial->user_profile }}" style="width: 60px; height: 60px;" alt="">
                            <div class="ml-3">
                                <h6 class="text-uppercase">{{ $testimonial->name }}</h6>
                                <span>{{ ucfirst(strtolower($testimonial->roles)) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(request()->route()->getName() === 'client.dashboard')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('client/img/testimonial.jpg') }}" alt="">
            </div>
            <div class="col-lg-6">
                <h6 class="d-inline-block text-primary text-uppercase bg-light py-1 px-2">Feedback</h6>
                <h1 class="mb-4">What Our Clients Say on our SPA!</h1>
                <div class="owl-carousel testimonial-carousel">
                  
                    @foreach($spaFeedback as $feedback)
                    <div class="position-relative">
                        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
                        <div class="d-flex align-items-center mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('fileupload/client/profile').'/'.$feedback->user_profile }}" style="width: 60px; height: 60px;" alt="">
                            <div class="ml-3">
                                <h6 class="text-uppercase">{{ $feedback->name }}</h6>
                                <span>{{ ucfirst(strtolower($feedback->roles)) }}</span>
                            </div>
                        </div>
                        <div class="feedback-holder">
                            <p class="m-0">{{ $feedback->feedback }}</p>
                            <div class="indicator-arrow">&#8594;</div>
                            <div class="spa-holder">
                                <span class="m-0 text-center">SPA Name</span>
                                <h5 class="m-0">{{ $feedback->spa_name }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(request()->route()->getName() === 'client.therapist')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('client/img/testimonial.jpg') }}" alt="">
            </div>
            <div class="col-lg-6">
                <h6 class="d-inline-block text-primary text-uppercase bg-light py-1 px-2">Feedback</h6>
                <h1 class="mb-4">What Our Clients Say on our Therapist!</h1>
                <div class="owl-carousel testimonial-carousel">
                    @foreach($therspistFeedback as $feedback)
                    <div class="position-relative">
                        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
                        <div class="d-flex align-items-center mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('fileupload/client/profile').'/'.$feedback->user_profile }}" style="width: 60px; height: 60px;" alt="">
                            <div class="ml-3">
                                <h6 class="text-uppercase">{{ $feedback->name }}</h6>
                                <span>{{ ucfirst(strtolower($feedback->roles)) }}</span>
                            </div>
                        </div>
                        <div class="feedback-holder">
                            <p class="m-0">{{ $feedback->therapist_feedback }}</p>
                            <div class="indicator-arrow">&#8594;</div>
                            <div class="spa-holder">
                                <span class="m-0 text-center">Therapist Name</span>
                                <h5 class="m-0">{{ $feedback->therapist_name }}</h5>
                            </div>
                        </div>
                        
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(request()->route()->getName() === 'client.services')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('client/img/testimonial.jpg') }}" alt="">
            </div>
            <div class="col-lg-6">
                <h6 class="d-inline-block text-primary text-uppercase bg-light py-1 px-2">Feedback</h6>
                <h1 class="mb-4">What Our Clients Say</h1>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Testimonial End -->