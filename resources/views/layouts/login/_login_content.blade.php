<section class="p-0">
    <div class="row m-0">
        <div class="col-md-6 p-0 d-none d-md-block">
            <img src="{{ asset('client/img/about.jpg') }}" alt="login form" class="img-fluid h-100 w-100"/>
        </div>
        <div class="col-md-6 d-flex align-items-center card" style="background-color: rgb(244, 225, 244); min-height: 100vh;">
            <div class="card-body text-black">
                <form>
                <div class="d-flex justify-content-center align-items-center">
                    <img class="w-25" src="{{ asset('client/img/logo.png') }}" alt="logo">
                </div>
                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                <div class="form-outline mb-4">
                    <input type="email" id="form2Example17" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example17">Email address</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="password" id="form2Example27" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Password</label>
                </div>
                <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="button">Login</button>
                </div>
                <a class="small text-muted" href="#!">Forgot password?</a>
                <div class="row">
                    <p class="mb-5 pb-lg-2 px-2" style="color: #393f81;">Don't have an account? Register here as</p>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">User</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="register.html" class="dropdown-item">Client</a>
                            <a href="register.html" class="dropdown-item">Spa Owner</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>