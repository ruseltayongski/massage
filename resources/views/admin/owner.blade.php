@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Spa Owner</h4>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Owner</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Spa</th>
                            <th>Contract</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="py-1">
                                    <img src="{{ asset('/fileupload/owner').'/'.$user->picture }}" alt="image"/>
                                </td>
                                <td>
                                    {{ $user->fname.' '.$user->lname }}
                                </td>
                                <td>
                                    {{ $user->mobile }}
                                </td>
                                <td>
                                    5
                                </td>
                                <td>
                                    1 Year
                                </td>
                                <td>
                                    <label class="badge badge-info">Active</label><br>
                                    <label class="badge badge-danger">Deactivate</label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="pl-5 pr-5">
                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection
