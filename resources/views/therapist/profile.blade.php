@section('css')
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
@endsection
@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="row">
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
                                <div class="col-xl-4">
                                    <!-- Profile picture card-->
                                    <div class="card mb-4 mb-xl-0">
                                        <div class="card-header">Profile Picture</div>
                                        <div class="card-body text-center">
                                            @if(empty($therapists->picture))
                                                <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                            @else
                                                <img
                                                    class="img-account-profile rounded-circle mb-2 w-75" 
                                                    src="{{ asset('/fileupload/therapist/profile/').'/'. $therapists->picture }}" 
                                                    alt=""
                                                    id="picture"
                                                    name="picture"
                                                 >
                                            @endif
                                            <!-- Profile picture help block-->
                                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                            <!-- Profile picture upload button-->
                                            <label for="">Upload new picture</label>
                                            <input type="file" class="form-control-file btn-primary disabled" id="files" name="picture"> 
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
                                                        <input class="form-control disabled" id="fname" name="fname" type="text" placeholder="Enter your first name" value="{{ $therapists->fname }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputLastName">Last name</label>
                                                        <input class="form-control disabled" id="lname" name="lname" type="text" placeholder="Enter your last name" value="{{ $therapists->lname }}">
                                                    </div>
                                                </div>
                                                <div class="row gx-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputOrgName">Phone Number</label>
                                                        <input class="form-control disabled" id="mobile" name="mobile" type="text" placeholder="Enter your phone number"value="{{ $therapists->mobile }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputLocation">Address</label>
                                                        <input class="form-control disabled" id="address" name="address" type="text" placeholder="Enter your address" value="{{ $therapists->address }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                                    <input class="form-control disabled" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ $therapists->email }}">
                                                </div>
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group (phone number)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputPhone">Password</label>
                                                        <input class="form-control disabled" id="password" name="password" type="password" placeholder="Enter your phone password">
                                                    </div>
                                                    <!-- Form Group (birthday)-->
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for="inputBirthday">Confirm Password</label>
                                                        <input class="form-control disabled" id="confirm_password" name="confirm_password" placeholder="confirm password" type="password">
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
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Add this script at the end of your file, before the closing </body> tag -->
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Disable form fields initially
        var formFields = document.querySelectorAll('.disabled');
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

