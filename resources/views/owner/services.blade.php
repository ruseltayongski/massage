@extends('layouts.admin.app_admin')

<style>
    .button-menu {
        display: flex;
        justify-content: space-evenly;
        gap: 2rem;

    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Services</h4>
                    <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal1"
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
                                <th>Description</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('/fileupload/owner/therapist/').'/'.$service->picture }}" alt="image"/>
                                    </td>
                                    <td>
                                        {{ $service->name}}
                                    </td>
                                    <td>
                                        {{ $service->description }}
                                    </td>
                                    <td>
                                        {{ $service->price }}
                                    </td>
                                    <td>
                                        <div class="button-menu">
                                                <button
                                                type="button" 
                                                class="btn btn-info btn-sm"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#assign_spa"
                                                data-id="{{ $service->id }}"
                                            >
                                                Assign Spa
                                            </button>
                                            <button 
                                                type="button" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateModal"
                                                data-id="{{ $service->id }}"
                                                data-name="{{ $service->name }}"
                                                data-description="{{ $service->description }}"
                                                data-price="{{ $service->price }}"
                                                data-picture="{{ $service->picture }}"
                                                class="btn btn-info btn-sm"
                                            >
                                                Update
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
                {!! $services->withQueryString()->links('pagination::bootstrap-5') !!}
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

        <form class="needs-validation" novalidate action="{{ route('owner.services.save') }}" method="POST"  enctype="multipart/form-data">
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
                <label for="description">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
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
  <div class="modal fade" id="assign_spa" tabindex="-1" aria-labelledby="assign_spa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assign_spa">Therapist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('owner.assign.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <select name="spa_id">
                        @foreach($spa as $spas)
                            @if ($spas->spa_id === null)
                                <option value="{{ $spas->id }}">
                                    {{ $spas->name }}
                                </option>
                            @endif
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
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Spa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('owner.services.update') }}" enctype="multipart/form-data">
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
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
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
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var servicesId = button.data('id');
        var servicesName = button.data('name');
        var servicesDesc = button.data('description');
        var servicesPrice = button.data('price');
        var currentPicture = button.data('picture');
        
        var modal = $(this);
        modal.find('#id').val(servicesId);
        modal.find('#picture').val(currentPicture);
        modal.find('#price').val(servicesPrice);
        modal.find('#name').val(servicesName);
        modal.find('#description').val(servicesDesc);
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

        $('#assign_spa').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var servicesId = button.data('id');
            $('input[name="id"]').val(servicesId);
            console.log('servicesId:', servicesId);
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
</script>
@endsection