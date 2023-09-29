@extends('layouts.register.app_register')

@section('content')
    <style>
        .pricing-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black background */
            z-index: 1; /* Ensure the overlay appears above other content */
            }
    </style>
    <section class="p-0">
        <div class="row m-0">
            <div class="col-md-6 p-0 d-none d-md-block">
                <img class="img-fluid h-100 w-100" src="{{ asset('client/img/about.jpg') }}" alt="login form">
            </div>
            <div class="col-md-6 d-flex align-items-center card" style="background-color: rgb(244, 225, 244); min-height: 100%;">
                <div class="text-black">
                    <form>
                    <div class="d-flex justify-content-center align-items-center mb-0">
                        <img class="w-25" src="{{ asset('client/img/logo.png') }}" alt="logo">
                    </div>
                
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register</h5>
                    <div class="row gx-5">
                        <div class="col-lg-6 form-outline">
                            <input type="email" id="form2Example17" class="form-control form-control-lg" />
                            <label class="form-label" for="form2Example17">Email address</label>
                        </div>
                        <div class="col-lg-6 form-outline">
                            <input type="password" id="form2Example27" class="form-control form-control-lg" />
                            <label class="form-label" for="form2Example27">Password</label>
                        </div>
                    </div>
                
                    <div class="pt-1 mb-4">
                        <button class="btn btn-dark btn-lg btn-block" type="button" id="registerButton">Register</button>
                    </div>
                    <a class="small text-muted" href="#!">Forgot password?</a>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="login.html" style="color: #393f81;">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="pricing-overlay" id="pricing-plans">
                <div class="col-lg-7 pt-5 pb-lg-5 mx-auto">
                    <div class="pricing-text bg-light p-4 p-lg-5 my-lg-5">
                        <div class="d-flex justify-content-end">
                            <i class="fas fa-times" id="closePayment"></i>
                        </div>
                        <p>Note: </p>
                        <span>For payment, just upload receipt of gcash<p>Gcash number: 09457163995</p></span>
                        <div class="owl-carousel pricing-carousel">
                            <div class="bg-white">
                                <div class="d-flex align-items-center justify-content-between border-bottom border-primary p-4">
                                    <h1 class="display-4 mb-0">
                                        <small class="align-top text-muted font-weight-medium" style="font-size: 22px; line-height: 45px;">$</small>49<small class="align-bottom text-muted font-weight-medium" style="font-size: 16px; line-height: 40px;">/Mo</small>
                                    </h1>
                                    <h5 class="text-primary text-uppercase m-0">Basic Plan</h5>
                                </div>
                                <div class="p-4">
                                    <p><i class="fa fa-check text-success mr-2"></i>Full Body Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Deep Tissue Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Hot Stone Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Tissue Body Polish</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Foot & Nail Care</p>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Pay Now!
                                    </button>
                                </div>
                            </div>
                            <div class="bg-white">
                                <div class="d-flex align-items-center justify-content-between border-bottom border-primary p-4">
                                    <h1 class="display-4 mb-0">
                                        <small class="align-top text-muted font-weight-medium" style="font-size: 22px; line-height: 45px;">$</small>99<small class="align-bottom text-muted font-weight-medium" style="font-size: 16px; line-height: 40px;">/Mo</small>
                                    </h1>
                                    <h5 class="text-primary text-uppercase m-0">Family Plan</h5>
                                </div>
                                <div class="p-4">
                                    <p><i class="fa fa-check text-success mr-2"></i>Full Body Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Deep Tissue Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Hot Stone Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Tissue Body Polish</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Foot & Nail Care</p>
                                    <a href="" class="btn btn-primary my-2">Order Now</a>
                                </div>
                            </div>
                            <div class="bg-white">
                                <div class="d-flex align-items-center justify-content-between border-bottom border-primary p-4">
                                    <h1 class="display-4 mb-0">
                                        <small class="align-top text-muted font-weight-medium" style="font-size: 22px; line-height: 45px;">$</small>149<small class="align-bottom text-muted font-weight-medium" style="font-size: 16px; line-height: 40px;">/Mo</small>
                                    </h1>
                                    <h5 class="text-primary text-uppercase m-0">VIP Plan</h5>
                                </div>
                                <div class="p-4">
                                    <p><i class="fa fa-check text-success mr-2"></i>Full Body Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Deep Tissue Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Hot Stone Massage</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Tissue Body Polish</p>
                                    <p><i class="fa fa-check text-success mr-2"></i>Foot & Nail Care</p>
                                    <a href="" class="btn btn-primary my-2">Order Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload proof of payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
