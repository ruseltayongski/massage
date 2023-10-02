@extends('layouts.admin.app_admin')
<!-- Ayaw butangi og style CSS dire na area! -->
@section('content')
<style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        input[disabled]:hover {
           cursor: not-allowed;
        }
        .disable[disabled]:hover {
            cursor: not-allowed;
        }
</style>
<div class="content-wrapper">
<<<<<<< HEAD
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="container-xl px-3">
                    <hr class="mt-0 mb-4">
                    <form class="needs-validation" id="form-action" action="{{ route('therapist.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="{{ $therapists->id }}">
=======
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="container-xl px-3">
                        <hr class="mt-0 mb-4">
                        <div class="row">
>>>>>>> 35c515e80fe248cd01ae3dd4b8c6cc2952b3f4f5
                            <div class="col-xl-4">
                                <!-- Profile picture card-->
                                <div class="card mb-4 mb-xl-0">
                                    <div class="card-header">Profile Picture</div>
                                    <div class="card-body text-center">
<<<<<<< HEAD
                                        @if(empty($therapists->picture))
                                            <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                        @else
                                            <img
                                                class="img-account-profile rounded-circle mb-2 w-75" 
                                                src="{{ asset('/fileupload/owner/therapist/').'/'. $therapists->picture }}" 
                                                alt=""
                                                id="picture"
                                                name="picture"
                                             >
=======
                                        <!-- Profile picture image-->
                                    
                                        @if(empty($therapists->picture))
                                            <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                        @else
                                            <img class="img-account-profile {{-- rounded-circle --}} mb-2 w-75" src="{{ asset('/fileupload/owner/therapist/').'/'. $therapists->picture }}" alt="">
>>>>>>> 35c515e80fe248cd01ae3dd4b8c6cc2952b3f4f5
                                        @endif
                                        <!-- Profile picture help block-->
                                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                        <!-- Profile picture upload button-->
<<<<<<< HEAD
                                        <label for="">Upload new picture</label>
                                        <input type="file" class="form-control-file btn-primary" id="files" name="picture"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="header card-header">
                                        <span>Account Details</span>
                                        <button class="btn btn-primary" type="button">
                                            <span class="update-button">Update</span>
                                        </button>
                                    </div>
                                    
                                  
                                    <div class="card-body">
                                            <div class="row gx-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                                    <input class="form-control" id="fname" name="fname" type="text" placeholder="Enter your first name" value="{{ $therapists->fname }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                                    <input class="form-control" id="lname" id="lname" type="text" placeholder="Enter your last name" value="{{ $therapists->lname }}">
                                                </div>
                                            </div>
                                            <div class="row gx-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputOrgName">Phone Number</label>
                                                    <input class="form-control" id="mobile" name="mobile" type="text" placeholder="Enter your phone number"value="{{ $therapists->mobile }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputLocation">Address</label>
                                                    <input class="form-control" id="address" name="address" type="text" placeholder="Enter your address" value="{{ $therapists->address }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                                <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ $therapists->email }}">
                                            </div>
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (phone number)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputPhone">Password</label>
                                                    <input class="form-control" id="password" name="password" type="password" placeholder="Enter your phone password" value="{{ $therapists->password }}">
                                                </div>
                                                <!-- Form Group (birthday)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputBirthday">Confirm Password</label>
                                                    <input class="form-control" id="confirm_password" name="confirm_password" placeholder="confirm password" type="password" value="{{ $therapists->password }}">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary disable" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>    
=======
                                        <button class="btn btn-primary" type="button">Upload new image</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header">Account Details</div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Form Group (username)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                                <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="{{ $therapists->email }}">
                                            </div>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="Valerie">
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                                    <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="Luna">
                                                </div>
                                            </div>
                                            <!-- Form Row        -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (organization name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputOrgName">Organization name</label>
                                                    <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="Start Bootstrap">
                                                </div>
                                                <!-- Form Group (location)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputLocation">Location</label>
                                                    <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="San Francisco, CA">
                                                </div>
                                            </div>
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                                <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="name@example.com">
                                            </div>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (phone number)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                                    <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                                </div>
                                                <!-- Form Group (birthday)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputBirthday">Birthday</label>
                                                    <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
                                                </div>
                                            </div>
                                            <!-- Save changes button-->
                                            <button class="btn btn-primary" type="button">Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
>>>>>>> 35c515e80fe248cd01ae3dd4b8c6cc2952b3f4f5
        </div>
    </div>
</div>
@endsection
<!-- Add this script at the end of your file, before the closing </body> tag -->
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Disable form fields initially
        var formFields = document.querySelectorAll('input');
        formFields.forEach(function (field) {
            field.disabled = true;
        });

        var buttonFields = document.querySelectorAll('.disable');
        buttonFields.forEach(function (field) {
            field.disabled = true;
        }); 

        // Handle click event on the update button
        var updateButton = document.querySelector('.update-button');
        updateButton.addEventListener('click', function () {
            // Toggle the disabled attribute for all input fields
            formFields.forEach(function (field) {
                field.disabled = !field.disabled;
            });
            buttonFields.forEach(function (field) {
                field.disabled = !field.disabled;
            });
        });

        $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var spaId = button.data('id');
        var spaName = button.data('name');
        var spaDescription = button.data('description');
        var currentPicture = button.data('picture');
        
        var modal = $(this);
        modal.find('#id').val(spaId);
        modal.find('#picture').val(currentPicture);
        modal.find('#name').val(spaName);
        modal.find('#description').val(spaDescription);
        });

        document.getElementById('files').addEventListener('change', handleNewPictureChange, false)
        
        function handleNewPictureChange(event) {
            var input = event.target;
            var modal = $(input).closest('#form-action');
            var reader = new FileReader();
            reader.onload = function (e) {
            modal.find('#picture').attr('src', e.target.result);
        }
            reader.readAsDataURL(input.files[0]);
        } 
    });

    (function() {
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
   })();

</script>

@endsection

