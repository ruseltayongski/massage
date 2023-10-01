@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Therapist</h4>
                    <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal"
                        class="btn btn-success mb-3"
                    >Add
                    </button>
                </div>
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary">search</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($therapists as $therapist)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('/fileupload/owner/therapist/').'/'.$therapist->picture }}" alt="image"/>
                                    </td>
                                    <td>
                                        {{ $therapist->fname.' '.$therapist->lname }}
                                    </td>
                                    <td>
                                        {{ $therapist->email }}
                                    </td>
                                    <td>
                                        {{ $therapist->address }}
                                    </td>
                                    <td>
                                        {{ $therapist->mobile }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>    
            <div class="pl-5 pr-5">
                {!! $therapists->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Spa Management</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
    
        <form class="needs-validation" novalidate action="{{ route('owner.therapist.save') }}" method="POST"  enctype="multipart/form-data">
            <div class="modal-body"> 
                @csrf
              <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                        <div class="invalid-feedback">
                            Please enter firstname
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                        <div class="invalid-feedback">
                            Please enter lastname
                          </div>
                      </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address
                          </div>
                    </div>
                </div>
                 <div class="col">
                    <div class="form-group">
                        <label for="mobile">Phone Number</label>
                        <input type="number" class="form-control" id="mobile" name="mobile" required>
                        <div class="invalid-feedback">
                            Please enter phone number
                          </div>
                      </div>
                 </div>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">
                    Please enter a valid password
                  </div>
             </div>
             <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="password" required>
                <div id="msg"></div>
               {{--  <div class="invalid-feedback">
                    Confirm password doesn't match
                  </div> --}}
             </div>
              <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                    <div class="invalid-feedback">
                        Please enter address
                      </div>
              </div>
              <div class="form-group">
                  <label for="picture">Proile Picture</label>
                  <input type="file" class="form-control-file" id="picture" name="picture" required />
                  <div class="invalid-feedback">
                    Please enter picture
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection
@section('js')
<script>
(function() {
    'use strict';

    function updatePasswordMatch() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var msgElement = document.getElementById('msg');

        if (password !== confirmPassword) {
            msgElement.innerHTML = 'Password do not match';
            msgElement.style.color = 'red';
        } else {
            msgElement.innerHTML = 'Password matched';
            msgElement.style.color = 'green';
        }
    }

    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over forms and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            // Add keyup event listener to confirm_password field
            var confirmPasswordField = form.querySelector('#confirm_password');
            confirmPasswordField.addEventListener('keyup', updatePasswordMatch);
        });
    }, false);
})();

   
   /*  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      console.log("forms", forms);
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })(); */

/*  $(document).ready(function(){
        $("#ConfirmPassword").keyup(function(){
             if ($("#Password").val() != $("#ConfirmPassword").val()) {
                 $("#msg").html("Password do not match").css("color","red");
             }else{
                 $("#msg").html("Password matched").css("color","green");
            }
      });
}); */
</script>
@endsection

