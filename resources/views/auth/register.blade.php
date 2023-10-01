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
                <a href="{{ route('/') }}">
                    <img class="img-fluid h-100 w-100" src="{{ asset('client/img/about.jpg') }}" alt="login form">
                </a>
            </div>
            <div class="col-md-6 d-flex align-items-center card" style="background-color: rgb(244, 225, 244); min-height: 100%;">
                <div class="text-black">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="roles" id="roles">
                        <div class="d-flex justify-content-center align-items-center mb-0">
                            <img class="w-25" src="{{ asset('client/img/logo.png') }}" alt="logo">
                        </div>
                    
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register</h5>

                        <div class="row gx-5">
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="fname">Firstname</label>
                                <input type="text" id="fname" name="fname" value="{{ old('fname') }}" class="form-control form-control-lg @error('fname') is-invalid @enderror"/>
                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="lname">Lastname</label>
                                <input type="text" id="lname" name="lname" value="{{ old('lname') }}" class="form-control form-control-lg @error('lname') is-invalid @enderror"/>
                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row gx-5">
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="mobile">Mobile Number</label>
                                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control form-control-lg @error('mobile') is-invalid @enderror"/>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror"/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row gx-5">
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"/>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 form-outline">
                                <label class="form-label" for="password-confirm">Confirm Password</label>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-lg"/>
                            </div>
                        </div>
                    
                        <div class="pt-1 mb-4 mt-3">
                            <button class="btn btn-dark btn-lg btn-block" type="submit" id="registerButton">Register</button>
                        </div>
                        <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="{{ route('login') }}" style="color: #393f81;">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
<script>
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
        var results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    var type = getUrlParameter('type').toUpperCase();
    $("#roles").val(type);
    
    if(!type || (type != 'CLIENT' && type != 'OWNER') ) {
        alert("Please select a user type");
        window.location.href="{{ route('login') }}";
    }
</script>
@endsection   