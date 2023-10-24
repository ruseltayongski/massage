@section('css')
    <style>
        .make-booking {
            display: flex !important;
            justify-content: center !important;
            align-items: center;
        }
        h1 {
        text-align: center;
        margin: 20px 0;
        color: #ffffff;
        }

        form {
            padding: 20px;
        }

        textarea {
            width: 100%;
            height: 150px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .form-check {
            margin-top: 10px;
        }

        .policy {
            color: #ffffff;
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
                    <p class="m-0"><a class="text-blue" href="{{ route('client.therapist') }}">Click here to go back to the therapist page</a></p>
                </div>
            </div>
        </div>

        <!-- Appointment Start -->
        <div class="container-fluid">
            <div class="container">
                <div class="row mx-0 justify-content-center text-center">
                    <div class="col-lg-6">
                        <h6 class="d-inline-block bg-light text-primary text-uppercase py-1 px-2">Booking</h6>
                        <h1 class="mb-5">Make An Booking</h1>
                    </div>
                </div>
                <div class="row justify-content-center bg-appointment mx-0">
                    <div class="col-lg-8 py-5">
                        <div class="p-5 my-5" style="background: rgba(33, 30, 28, 0.7);">
                           {{--  <h1 class="text-white text-center mb-4">Make Booking</h1> --}}
                            <form action="{{ route('client.booking.save') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="spa_id" value="{{ $spa_id }}">
                                <input type="hidden" name="service_id" value="{{ $service_id }}">
                                <input type="hidden" name="therapist_id" value="{{ $therapist_id }}">
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="date" id="date" data-target-input="nearest">
                                                <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_date" placeholder="Select Date" data-target="#date" data-toggle="datetimepicker" required="required"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="time" id="time" data-target-input="nearest">
                                                <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_time" placeholder="Select Time" data-target="#time" data-toggle="datetimepicker" required="required"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control bg-transparent p-4" id="amount_paid" name="amount_paid" placeholder="Amount Paid" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg-transparent p-4" id="payment_filename" name="payment_filename" placeholder="Upload Payment Proof" />
                                            <input style="color:transparent" type="file" name="payment_picture" id="payment_picture" placeholder="Upload payment" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select class="custom-select bg-transparent px-4" name="booking_type" style="height: 47px;" required="required">
                                                <option value="" selected>Select A Booking Type</option>
                                                <option value="onsite">Onsite</option>
                                                <option value="home_service">Home Service</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-flex">
                                        <div class="form-group make-booking">
                                            <span style="color:aliceblue">For Gcash payment, kindly send to this number: 09457163995</span>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="text-center">Terms of Booking</h1>                 
                                <div class="form-group">
                                    <textarea class="w-100" cols="30" rows="10" readonly>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam ex fugit officiis officia doloribus alias eligendi cumque fuga, iure quasi assumenda distinctio, quae animi, molestiae vel. Quis itaque quaerat delectus.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam ex fugit officiis officia doloribus alias eligendi cumque fuga, iure quasi assumenda distinctio, quae animi, molestiae vel. Quis itaque quaerat delectus.
                                    </textarea>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="trigger_booking" name="trigger_booking">
                                    <label class="form-check-label policy" for="trigger_booking">I have read and accept the terms of contract</label>
                                </div>  
                                <div class="make-booking enable_booking">
                                    <button class="btn btn-primary btn-block" type="submit" style="height: 47px;" disabled>Make Booking</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Appointment End -->
        
        {{-- <div class="container-fluid px-0" style='margin-top:-30px;'>
            <div class="row justify-content-center bg-appointment mx-0">
                <div class="col-lg-6">
                    <div class="p-5 my-5" style="background: rgba(33, 30, 28, 0.7);">
                        <form action="{{ route('client.booking.save') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="spa_id" value="{{ $spa_id }}">
                            <input type="hidden" name="service_id" value="{{ $service_id }}">
                            <input type="hidden" name="therapist_id" value="{{ $therapist_id }}">
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="date" id="date" data-target-input="nearest">
                                            <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_date" placeholder="Select Date" data-target="#date" data-toggle="datetimepicker" required="required"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="time" id="time" data-target-input="nearest">
                                            <input type="text" class="form-control bg-transparent p-4 datetimepicker-input" name="start_time" placeholder="Select Time" data-target="#time" data-toggle="datetimepicker" required="required"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control bg-transparent p-4" id="amount_paid" name="amount_paid" placeholder="Amount Paid" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control bg-transparent p-4" name="payment_picture" placeholder="Upload payment" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="custom-select bg-transparent px-4" name="booking_type" style="height: 47px;" required="required">
                                            <option value="" selected>Select A Booking Type</option>
                                            <option value="onsite">Onsite</option>
                                            <option value="home_service">Home Service</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-primary btn-block" type="submit" style="height: 47px;">Make Booking</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
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
    $("#amount_paid").val("{{ session('price') }}");

    $(document).ready(function () {
        $('#payment_picture').change(function () {
            var fileName = $(this).val().split('\\').pop();
            $('#payment_filename').val(fileName);
        });

        $('#trigger_booking').change(function() {
            var isChecked = $('input[name="trigger_booking"]:checked').val();

            if(isChecked) {
                console.log("rodfil");
                $('.enable_booking button').prop('disabled', false);
            } else {
                $('.enable_booking button').prop('disabled', true);
            }
        });
    });
</script>
@endsection