@section('css')
    <style>
        .make-booking {
            display: flex !important;
            justify-content: center !important;
            align-items: center;
        }
    </style>
@endsection

@extends('layouts.client.app_client')

@section('content')
    @if(!empty(session('spa_id')) && !empty(session('service_id')) && !empty(session('therapist_id')))

        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Booking</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.booking.history') }}">Click here to go back to the booking history</a></p>
                </div>
            </div>
        </div>

        <!-- Appointment Start -->
        <div class="container-fluid">
            <div class="container">
                <div class="row mx-0 justify-content-center text-center">
                    <div class="col-lg-6">
                        <h6 class="d-inline-block bg-light text-primary text-uppercase py-1 px-2">Edit Booking</h6>
                        <h1 class="mb-5">Make An Booking</h1>
                    </div>
                </div>
                <div class="row justify-content-center bg-appointment mx-0">
                    <div class="col-lg-8 py-5">
                        <div class="p-5 my-5" style="background: rgba(33, 30, 28, 0.7);">
                            <h1 class="text-white text-center mb-4">Make Booking</h1>
                            <form action="{{ route('client.booking.edit.save') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $booking->id }}">
                                <input type="hidden" name="spa_id" value="{{ $booking->spa_id }}">
                                <input type="hidden" name="service_id" value="{{ $booking->service_id }}">
                                <input type="hidden" name="therapist_id" value="{{ $booking->therapist_id }}">
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="date" id="date" data-target-input="nearest">
                                                <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_date" value="{{ date('m/d/Y',strtotime($booking->start_date)) }}" placeholder="Select Date" data-target="#date" data-toggle="datetimepicker" required="required"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="time" id="time" data-target-input="nearest">
                                                <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_time" value="{{ date('g:i A',strtotime($booking->start_time)) }} placeholder="Select Time" data-target="#time" data-toggle="datetimepicker" required="required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control bg-transparent p-4" id="amount_paid" value="{{ $booking->amount_paid }}" name="amount_paid" placeholder="Amount Paid" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="hidden" name="existing_image_path" value="{{ $booking->payment_picture }}" />
                                            <input type="text" class="form-control bg-transparent p-4" id="payment_filename" name="payment_filename" value="{{ $booking->payment_picture }}" placeholder="Upload Payment Proof" />
                                            <input style="color:transparent" type="file" name="payment_picture" id="payment_picture" placeholder="Upload payment" {{ $booking->payment_picture ? '' : 'required' }} />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select class="custom-select bg-transparent px-4" name="booking_type" style="height: 47px;" required="required">
                                                <option value="onsite" {{ $booking->booking_type == 'onsite' ? 'selected' : '' }}>Onsite</option>
                                                <option value="home_service" {{ $booking->booking_type == 'home_service' ? 'selected' : '' }}>Home Service</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-flex">
                                        <div class="form-group make-booking">
                                            <span style="color:aliceblue">For Gcash payment, kindly send to this number: 09457163995</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="make-booking">
                                        <button class="btn btn-primary btn-block" type="submit" style="height: 47px;">Edit Booking</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Appointment End -->
    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Spa Not Found</h3>
                <div class="d-inline-flex align-items-center text-white">
                    @if(empty(session('spa_id')))
                        <p class="m-0"><a class="text-blue" href="{{ route('client.dashboard') }}">Please click here to select a spa first</a></p>
                    @elseif(empty(session('service_id')))
                        <p class="m-0"><a class="text-blue" href="{{ route('client.services') }}">Please click here to select a service first</a></p>
                    @elseif(empty(session('therapist_id')))   
                        <p class="m-0"><a class="text-blue" href="{{ route('client.services') }}">Please click here to select a therapist first</a></p> 
                    @endif    
                </div>
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#payment_picture').change(function () {
                var fileName = $(this).val().split('\\').pop();
                $('#payment_filename').val(fileName);
            });
        });
    </script>
@endsection