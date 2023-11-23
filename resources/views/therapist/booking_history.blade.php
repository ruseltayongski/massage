@section('css')
    <style>
         .filtering-holder {
            display: flex;
        }
        .view-all span{
            color: #fff !important;
            cursor: pointer;
        }
    </style>
@endsection

@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Booking History</h4>
                    </div>
                    <div class="filtering-holder">
                        <form action="{{ route('therapist.booking_history') }}">
                            <div class="left-filtering">
                                <ul class="nav nav-pills mb-3 pr-3">
                                    <li class="nav-item">
                                        <a 
                                            class="nav-link {{ request('status') == 'Pending' ? 'active' : '' }}" 
                                            aria-current="page" 
                                            href="{{ route('therapist.booking_history', ['status' => 'Pending']) }}">
                                            Pending
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a 
                                        class="nav-link {{ request('status') == 'Cancel' ? 'active' : '' }}" 
                                        href="{{ route('therapist.booking_history', ['status' => 'Cancel']) }}">
                                        Cancelled
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a 
                                            class="nav-link {{ request('status') == 'Approved' ? 'active' : '' }}" 
                                            href="{{ route('therapist.booking_history', ['status' => 'Approved']) }}">
                                            Approved
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a 
                                            class="nav-link {{ request('status') == 'Completed' ? 'active' : '' }}" 
                                            href="{{ route('therapist.booking_history', ['status' => 'Completed']) }}">
                                            Completed
                                        </a>
                                    </li>
                                </ul>
                                <label for="" class="pr-2">Date Range:</label>
                                <input type="text" name="datetimes" value="Select Date" />
                            </div>
                        </form>                            
                        <div class="right-filtering">
                            <button class="btn btn-primary">
                                <a href="{{ route('therapist.booking_history') }}" class="view-all">
                                    <span>View All</span>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Client Name
                                    </th>
                                    <th>
                                        Service
                                    </th>
                                    <th>
                                        SPA
                                    </th>
                                    <th>
                                        Booking Type
                                    </th>
                                    <th>
                                        Booking Date
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
                                        {{ $booking->client }}
                                    </td>
                                    <td>
                                        @if($booking->status != 'Approved' && $booking->status != 'Completed')
                                            <a href="{{ route('client.services') }}">
                                                {{ $booking->services }}
                                            </a>
                                        @else
                                          {{ $booking->services }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $booking->spa_name }}
                                    </td>
                                    <td>
                                        @if($booking->booking_type == 'home_service')
                                            Home Service
                                        @else
                                            Onsite
                                        @endif  
                                    </td>
                                    <td>
                                        @if($booking->status != 'Approved' && $booking->status != 'Completed')
                                            <a href="{{ route('client.booking.edit', ['id' => $booking->id]) }}">
                                                {{ date("M j, Y",strtotime($booking->start_date)) }}<br>
                                                <small>({{ date("g:i a",strtotime($booking->start_time)) }})</small>
                                            </a>
                                        @else
                                            {{ date("M j, Y",strtotime($booking->start_date)) }}<br>
                                            <small>({{ date("g:i a",strtotime($booking->start_time)) }})</small>
                                        @endif
                                    </td>
                                    <td>
                                        ₱&nbsp;{{ number_format($booking->amount_paid, 2, '.', ',') }}
                                    </td>
                                    <td>
                                        <?php
                                            $color = "";
                                            if($booking->status == 'Pending') {
                                                $color = "warning";
                                            } else if($booking->status == 'Approved' || $booking->status == 'Completed') {
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
                <div id="myModal" class="modal-picture">
                    <span id="close">&times;</span>
                    <img class="modal-contents" id="img01">
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
      $(function() {
        var dateRangePicker = $("input[name='datetimes']").daterangepicker();

        dateRangePicker.on('apply.daterangepicker', function(ev, picker) {
            $(this).closest('form').submit();
        });
    });
</script>
@endsection