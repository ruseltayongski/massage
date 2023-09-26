@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Striped Table</h4>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Owner</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Spa</th>
                        <th>Contract</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="py-1">
                            <img src="{{ asset('admin/images/faces/face1.jpg') }}" alt="image"/>
                        </td>
                        <td>
                            Herman Beck
                        </td>
                        <td>
                            +639238309990
                        </td>
                        <td>
                            5
                        </td>
                        <td>1 Year</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
