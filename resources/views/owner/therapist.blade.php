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
                                        <img src="{{ asset('/fileupload/therapist/profile/').'/'.$therapist->picture }}" alt="image"/>
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
@endsection
@section('js')
<script>
    // your javascript code here
</script>
@endsection

