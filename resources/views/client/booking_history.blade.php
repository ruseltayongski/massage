@section('css')
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        .rate-container {
            display: grid;
            place-content: center;
            float: left;
        }

        .rate {
            height: 20px;
        
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:20px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }

        .rate > input:checked ~ label {
            color: #ffc700; 
        }

        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
    </style>
    <link href="{{ asset('admin/css/bootstrap-toogle.css?v=').date('His') }}" rel="stylesheet">
@endsection
@extends('layouts.client.app_client')

@section('content')
    <?php
        if (!function_exists('checkRatings')) {
            function checkRatings($value,$ratings) {
                return $value == $ratings ? 'checked' : '';
            }
        }
    ?>
    @if(count($bookings) > 0)
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Booking History</h3>
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
                                            Payment
                                        </th>
                                        <th>
                                            Service
                                        </th>
                                        <th>
                                            SPA
                                        </th>
                                        <th>
                                            Therapist
                                        </th>
                                        <th>
                                            Booking
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
                                        <th>
                                            Receipt
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td class="py-1">
                                            <a href="{{ route('client.booking.edit', ['id' => $booking->id]) }}">
                                                <img src="{{ asset('fileupload/client/payment').'/'.$booking->payment_picture }}" style="width:50px;" alt="image"/>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.booking.edit', ['id' => $booking->id]) }}">
                                                {{ $booking->services }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.rate.spa').'?spa_id='.$booking->spa_id }}">{{ $booking->spa_name }}</a><br>
                                            <form id="ratingForm">
                                                <div class="rate-container">
                                                    <div class="rate">
                                                        <input type="radio" value="5" {{ checkRatings(5,$booking->ratings_spa) }}/><label title="text">5 stars</label>
                                                        <input type="radio" value="4" {{ checkRatings(4,$booking->ratings_spa) }}/><label title="text">4 stars</label>
                                                        <input type="radio" value="3" {{ checkRatings(3,$booking->ratings_spa) }}/><label title="text">3 stars</label>
                                                        <input type="radio" value="2" {{ checkRatings(2,$booking->ratings_spa) }}/><label title="text">2 stars</label>
                                                        <input type="radio" value="1" {{ checkRatings(1,$booking->ratings_spa) }}/><label title="text">1 star</label>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.rate.therapist').'?therapist_id='.$booking->therapist_id }}">{{ $booking->therapist }}</a><br>
                                            <form id="ratingForm">
                                                <div class="rate-container">
                                                    <div class="rate">
                                                        <input type="radio" value="5" {{ checkRatings(5,$booking->ratings_therapist) }}/><label title="text">5 stars</label>
                                                        <input type="radio" value="4" {{ checkRatings(4,$booking->ratings_therapist) }}/><label title="text">4 stars</label>
                                                        <input type="radio" value="3" {{ checkRatings(3,$booking->ratings_therapist) }}/><label title="text">3 stars</label>
                                                        <input type="radio" value="2" {{ checkRatings(2,$booking->ratings_therapist) }}/><label title="text">2 stars</label>
                                                        <input type="radio" value="1" {{ checkRatings(1,$booking->ratings_therapist) }}/><label title="text">1 star</label>
                                                    </div>
                                                </div>
                                            </form>
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
                                                } else if($booking->status == 'Approved' || $booking->status == 'Completed') {
                                                    $color = "success";
                                                } else if($booking->status == 'Rejected') {
                                                    $color = "danger";
                                                }
                                            ?>
                                            @if($booking->status == 'Pending' || $booking->status == 'Cancel')
                                                {{-- <input type="hidden" name="booking_status" id="booking_status" value="Pending"> --}}
                                                <input 
                                                    type="checkbox"  
                                                    data-id="{{ $booking->id }}"
                                                    data-toggle="toggle" 
                                                    data-on="Cancelled" 
                                                    data-off="Pending" 
                                                    data-onstyle="info"
                                                    data-offstyle="primary" 
                                                    data-width="100"
                                                    data-pending="true"
                                                    onchange="confirmToggle(this)"
                                                    @if($booking->status == 'Cancel') checked @endif
                                                ><br>
                                                <small style="font-size: 6pt"><i>(Toggle to change status)</i></small>
                                            @else
                                                <span class="badge badge-{{ $color }} p-2 booking-status" style="color:white;">
                                                    {{ $booking->status }}     
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                           <a href="{{ route('client-generate-pdf', ['id' => $booking->id]) }}">
                                                Download
                                            </a>
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
                {{-- <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.dashboard') }}">Please click here to select a spa first</a></p>
                </div> --}}
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script src="{{ asset('admin/js/bootstrap-toogle.js?v=').date('His') }}"></script>
    <script>
        @if(session('booking_save'))
            Lobibox.notify('success', {
                msg: 'Successfully added booking!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('sucess_download'))
            Lobibox.notify('success', {
                msg: 'Successfully added booking!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('rate_therapist_save'))
            Lobibox.notify('success', {
                msg: 'Successfully rate the Therapist!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('rate_spa_save'))
            Lobibox.notify('success', {
                msg: 'Successfully rate the Spa!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('booking_edit_save'))
            Lobibox.notify('success', {
                msg: 'Successfully edited booking!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif

        function confirmToggle(data) {
            const url = "{{ route('client.update.booking.status') }}";
            const isChecked = data.checked;
            const booking_status = isChecked ? 'Cancel' : 'Pending';
            const booking_id = $(data).data('id');
            const formData = new FormData();
            formData.append('booking_id', booking_id);
            formData.append('booking_status', booking_status);
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
                    if(result) {
                        Lobibox.notify('success', {
                            msg: 'Successfully updated the booking status',
                            img: $("#asset").val()+"/img/check.png"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection