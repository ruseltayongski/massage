@extends('layouts.client.app_client')

@section('content')
    @if(isset($spa_id))
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Booking</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-white" href="">Select</a></p>
                    <i class="far fa-circle px-3"></i>
                    <p class="m-0">Booking</p>
                </div>
            </div>
        </div>
        
        <div class="container-fluid px-0" style='margin-top:-30px;'>
            <div class="row justify-content-center bg-appointment mx-0">
                <div class="col-lg-6">
                    <div class="p-5 my-5" style="background: rgba(33, 30, 28, 0.7);">
                        <form action="{{ route('client.booking.save') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="number" class="form-control bg-transparent p-4" name="amount_paid" placeholder="Amount Paid" required="required" />
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
        </div>
    @else
        <div class="jumbotron jumbotron-fluid bg-jumbotron">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4">Spa Not Found</h3>
                <div class="d-inline-flex align-items-center text-white">
                    <p class="m-0"><a class="text-blue" href="{{ route('client.dashboard') }}">Please click here to select a spa first</a></p>
                </div>
            </div>
        </div>
    @endif
@endsection