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
                                    <span class="badge badge-danger p-2">
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