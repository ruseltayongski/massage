@extends('layouts.admin.app_admin')

@section('content')
<link href="{{ asset('admin/css/bootstrap-toogle.css') }}" rel="stylesheet">
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Manage Booking</h4>
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
                                    <th>
                                        Payment Proof
                                    </th>
                                    <th>
                                        SPA
                                    </th>
                                    <th>
                                        Service
                                    </th>
                                    <th>
                                        Therapist
                                    </th>
                                    <th>
                                        Booking Type
                                    </th>
                                    <th>
                                        Start Date
                                    </th>
                                    <th>
                                        Amount Paid
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('fileupload/client/payment').'/'.$booking->payment_picture }}" style="width:50px;" alt="image"/>
                                        </td>
                                        <td>
                                            {{ $booking->spa }}
                                        </td>
                                        <td>
                                            {{ $booking->services }}
                                        </td>
                                        <td>
                                            {{ $booking->therapist }}
                                        </td>
                                        <td>
                                            @if($booking->booking_type == 'home_service')
                                                Home Service
                                            @else
                                                {{ $booking->booking_type }}
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ date("M j, y",strtotime($booking->start_date)) }}</small><br>
                                            <small>({{ date("g:i a",strtotime($booking->start_time)) }})</small>
                                        </td>
                                        <td>
                                            ₱&nbsp;{{ number_format($booking->amount_paid, 2, '.', ',') }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="booking_status" id="booking_status" value="Pending">
                                            <input type="checkbox" id="booking_status_toggle" data-toggle="toggle" data-on="Approved" data-off="Pending" data-onstyle="success" data-offstyle="primary" data-width="100" >
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pl-5 pr-5">
                    {!! $bookings->appends(request()->query())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/js/bootstrap-toogle.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#booking_status_toggle').change(function() {
            if(this.checked) {
                $("#booking_status_call").val("Approved");
                console.log("approved")
            }
            else {
                $("#booking_status_call").val("Pending");
                console.log("pending")
            }
        });
    });
</script>
@endsection