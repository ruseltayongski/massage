@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Spa</h4>
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
                                    <img src="{{ asset('/fileupload/spa').'/'.$spa->picture }}" alt="image"/>
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
@endsection
