<!-- Team Start -->
<div class="container-fluid ">
    <div class="container ">
        <!-- <div class="row justify-content-center text-center">
            <div class="col-lg-6">
                <h6 class="d-inline-block bg-light text-primary text-uppercase py-1 px-2">Store</h6>
                <h1 class="mb-5">Spa Store</h1>
            </div>
        </div> -->
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
<!-- Team End -->