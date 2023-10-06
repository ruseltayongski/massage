<?php
    use App\Models\Testimonials;
    use Illuminate\Support\Facades\DB;
    
    $testimonials = Testimonials::select(
                        DB::raw("concat(users.fname,' ',users.lname) as name"),
                        'users.picture as user_profile',
                        'users.roles',
                        'testimonials.description'
                    )
                    ->leftJoin('users','users.id','=','testimonials.user_id')
                    ->get();
?>
<!-- Testimonial Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <img class="img-fluid w-100" src="{{ asset('client/img/testimonial.jpg') }}" alt="">
            </div>
            <div class="col-lg-6">
                <h6 class="d-inline-block text-primary text-uppercase bg-light py-1 px-2">Testimonial</h6>
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
                        <p class="m-0">{{ $testimonial->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->