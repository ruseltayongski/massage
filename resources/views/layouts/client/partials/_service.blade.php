<style>
    /* CSS */
    .tag-price {
        position: absolute;
        top: 10px; 
        right: 5px; 
        background-color:red;
        padding:5px;
        transform: rotate(30deg);
    }

</style>
</style>
<!-- Service Start -->
<div class="container-fluid px-0">
    <div class="row mx-0 justify-content-center text-center">
        <div class="col-lg-6">
            <h6 class="d-inline-block bg-light text-primary text-uppercase py-1 px-2">Our Service</h6>
            <h1>Spa & Beauty Services</h1>
        </div>
    </div>
    <div class="owl-carousel service-carousel">
        @foreach($services as $service)
        <div class="service-item position-relative">
            <img class="img-fluid" src="{{ asset('/fileupload/services').'/'.$service->picture }}" alt="">
            <div class="service-text text-center">
                <h4 class="text-white font-weight-medium px-3">{{ $service->name }}</h4>
                <p class="text-white px-3 mb-3">{{ $service->description }}</p>
                <div class="w-100 bg-white text-center p-4" >
                    <a class="btn btn-primary" href="{{ route('therapist').'?spa='.$spa_id.'&service='.$service->id }}">Select Service</a>
                </div>
            </div>
            <div class="tag-price">
                <strong class="text-white">₱&nbsp;{{ $service->price }}</strong>
            </div>
        </div>
        @endforeach
    </div>
    <!-- <div class="row justify-content-center bg-appointment mx-0">
        <div class="col-lg-6 py-5">
            <div class="p-5 my-5" style="background: rgba(33, 30, 28, 0.7);">
                <h1 class="text-white text-center mb-4">Make Appointment</h1>
                <form>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control bg-transparent p-4" placeholder="Your Name" required="required" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email" class="form-control bg-transparent p-4" placeholder="Your Email" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="date" id="date" data-target-input="nearest">
                                    <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" placeholder="Select Date" data-target="#date" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="time" id="time" data-target-input="nearest">
                                    <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" placeholder="Select Time" data-target="#time" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select class="custom-select bg-transparent px-4" style="height: 47px;">
                                    <option selected>Select A Service</option>
                                    <option value="1">Service 1</option>
                                    <option value="2">Service 1</option>
                                    <option value="3">Service 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary btn-block" type="submit" style="height: 47px;">Make Appointment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
</div>
<!-- Service End -->