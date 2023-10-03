@extends('layouts.client.app_client')

@section('content')
    @if(count($bookings) > 0)
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Booking History</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-white" href="">Select</a></p>
                    <i class="far fa-circle px-3"></i>
                    <p class="m-0">Booking</p>
                </div>
            </div>
        </div>
        
        <section>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
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
                                        <td class="py-1">
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
                                                Onsite
                                            @endif  
                                        </td>
                                        <td>
                                            {{ date("M j, Y",strtotime($booking->start_date)) }}<br>
                                            <small>({{ date("g:i a",strtotime($booking->start_time)) }})</small>
                                        </td>
                                        <td>
                                            ₱&nbsp;{{ number_format($booking->amount_paid, 2, '.', ',') }}
                                        </td>
                                        <td>
                                            <?php
                                                $color = "";
                                                if($booking->status == 'Pending') {
                                                    $color = "warning";
                                                } else if($booking->status == 'Approved') {
                                                    $color = "success";
                                                } else if($booking->status == 'Rejected') {
                                                    $color = "danger";
                                                }
                                            ?>
                                            <span class="badge badge-{{ $color }} p-2 booking-status" style="color:white;">
                                                {{ $booking->status }}     
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="pl-5 pr-5 mt-5">
            {!! $bookings->appends(request()->query())->links('pagination::bootstrap-5') !!}
        </div>

    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Bookings Not Found</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client') }}">Please click here to select a spa first</a></p>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        @if(session('booking_save'))
            Lobibox.notify('success', {
                msg: 'Successfully added booking!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
    </script>
@endsection