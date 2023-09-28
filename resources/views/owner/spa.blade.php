@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manage Spa</h4>
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
                            <th>Spa</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Therapist</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spas as $spa)
                            <tr>
                                <td class="py-1">
                                    <img src="{{ asset('/fileupload/spa/picture/').'/'.$spa->picture }}" alt="image"/>
                                </td>
                                <td>
                                    {{ $spa->name }}
                                </td>
                                <td>
                                    {{ $spa->description }}
                                </td>
                                <td>
                                    5
                                </td>
                                <td>
                                    {{ date("M j, Y",strtotime($spa->created_at)) }}<br>
                                    <small>({{ date("g:i a",strtotime($spa->created_at)) }})</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="pl-5 pr-5">
                {!! $spas->withQueryString()->links('pagination::bootstrap-5') !!}
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
      <form method="POST" action="{{ route('owner.spa.save') }}"  enctype="multipart/form-data">
        <div class="modal-body">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="spa_picture">Spa Picture</label>
                <input type="file" class="form-control-file" id="picture" name="picture">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

<script>
    /* document.addEventListener("DOMContentLoaded", function() {
        function saveSpa() {
        console.log("formData");
        const name = $("#name").val();
        const description = $("#description").val();
        const picture = $("#picture")[0].files[0];
        

        const url = "{{ route('owner.spa.save') }}";
        var formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);
        formData.append('picture', picture)
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (result) {
                console.log(result);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        return true;
    }
    document.getElementById('spaForm').addEventListener('submit', function(event) {
        if (!saveSpa()) {
            event.preventDefault();
        }
    });
    }) */
</script>
