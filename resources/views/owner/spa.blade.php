@extends('layouts.admin.app_admin')

<style>
    .button-menu {
        display: flex;
        justify-content: space-evenly;
    }
</style>
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Spa</h4>
                    <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal1"
                        class="btn btn-success mb-3"
                        onclick="clearForm()"
                    >
                    Add
                    </button>
                </div>
            <form action="{{ route('owner/spa') }}" method="GET">
                    <div class="input-group">
                        <input type="search" id="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" name="search_button" class="btn btn-outline-primary">search</button>
                    </div>
                </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Spa</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Therapist</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($spas as $spa)
                                    <tr>
                                        <td class="py-1">
                                            <img src="{{ asset('/fileupload/spa/').'/'.$spa->picture }}" alt="image"/>
                                        </td>
                                        <td>
                                            {{ $spa->name }}
                                        </td>
                                        <td>
                                           {{ $spa->description }}
                                        </td>
                                        <td>
                                            <button
                                                type="button" 
                                                class="btn btn-info btn-sm"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#view_therapist"
                                                data-id="{{ $spa->id }}"
                                             >
                                             View
                                           </button>
                                        </td>
                                        <td>
                                            {{ date("M j, Y",strtotime($spa->created_at)) }}<br>
                                            <small>({{ date("g:i a",strtotime($spa->created_at)) }})</small>
                                        </td>
                                        <td>
                                            <div class="button-menu">
                                                <button type="button" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateModal"
                                                data-id="{{ $spa->id }}"
                                                data-name="{{ $spa->name }}"
                                                data-description="{{ $spa->description }}"
                                                data-picture="{{ $spa->picture }}"
                                                class="btn btn-info btn-sm"
                                                >
                                                    Update
                                                </button>
                                                <button
                                                    type="button" 
                                                    class="btn btn-info btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#add_therapist"
                                                    data-id="{{ $spa->id }}"
                                                 >
                                                    Assign Therapist
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pl-5 pr-5">
                    {!! $spas->appends(request()->query())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Spa Management</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form class="needs-validation" novalidate action="{{ route('owner.spa.save')  }}" method="POST"  enctype="multipart/form-data">
            <div class="modal-body"> 
                @csrf
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                  <div class="invalid-feedback">
                    Please enter Name
                </div>
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" required>
                  <div class="invalid-feedback">
                    Please enter Description
                  </div>
              </div>
              <div class="form-group">
                  <label for="spa_picture">Spa Picture</label>
                  <input type="file" class="form-control-file" id="picture" name="picture" required />
                  <div class="invalid-feedback">
                    Please upload picture
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
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Spa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('owner.spa.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="picture">Spa Picture</label>
                            </div>
                        </div>
                        <div class="form-group">
                           {{--  <label for="new_picture">New Spa Picture</label> --}}
                            <input type="file" class="form-control-file" id="files" name="picture"> 
                        </div>
                        <div class="row">
                            <div class="col">
                                @if(empty($spa->picture))
                                    <img 
                                        name="picture" 
                                        id="picture"
                                        src="{{ asset('img/check.png') }}"
                                        alt="image" 
                                        style="width:100px; height:100px;"
                                    />
                                    @else
                                    <img 
                                        name="picture" 
                                        id="picture"
                                        src="{{ asset('/fileupload/owner/picture/').'/'.$spa->picture }}"
                                        alt="image" 
                                        style="width:100px; height:100px;"
                                    />
                                 @endif
                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="add_therapist" tabindex="-1" aria-labelledby="add_therapist" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_therapist">Therapist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" {{-- style="width: 100px; display:flex; justify-content:center; align-items:center;" --}}>
                  
                    <form action="{{ route('assigned.therapist.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <select name="therapist_id">
                            @foreach($usersList as $user)
                              {{--   @if ($usersList->spa_id === null) --}}
                                    <option value="{{ $user->id }}">
                                        {{ $user->fname }}
                                    </option>
                              {{--   @endif --}}
                            @endforeach  
                         </select>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                     </div>
                    </form>
                </div>
               
        </div>
    </div>
</div>
<div class="modal fade" id="view_therapist" tabindex="-1" aria-labelledby="view_therapist" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view_therapist">Therapist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" {{-- style="width: 100px; display:flex; justify-content:center; align-items:center;" --}}>
                
                    <input type="hidden" name="id" value="{{ $spa->id }}">
               
                </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
            var modal = $(input).closest('.modal');
            var reader = new FileReader();
            reader.onload = function (e) {
            modal.find('#picture').attr('src', e.target.result);
        }
            reader.readAsDataURL(input.files[0]);
        } 
    });


    $(document).ready(function () {
        'use strict';
    
        $('#add_therapist').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var spaId = button.data('id');
            $('input[name="id"]').val(spaId);
            console.log('spa_id:', spaId);
        });

       
        $('#view_therapist').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var spaId = button.data('id');

            $.ajax({
                url: '{{ route('owner.get-therapists') }}',
                method: 'GET',
                data: { spa_id: spaId },
                success: function(response) {
                    var modalBody = $('#view_therapist').find('.modal-body');
                    modalBody.empty();

                    response.forEach(function(therapist) {
                        modalBody.append('<span>' + therapist.fname + '</span>');
                    });
                },
                error: function(error) {
                    console.error(error);
                }   
            });
        });
        var forms = $('.needs-validation');
            console.log("forms", forms);

            // Loop over them and prevent submission
            forms.on('submit', function(event) {
                var form = $(this);

                if (form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }

            form.addClass('was-validated');
        });

    });

    

    function clearForm() {
        $('#id').val('');
        $('#name').val('');
        $('#description').val('');
        $('#picture').val('');
    }
   
   
  /*   (function() {
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
 */
</script>
@endsection