@extends('layouts.admin.app_admin')

@section('content')
<?php $user = Auth::user(); ?>
<div class="content-wrapper">
    {{-- <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0 font-weight-bold">{{ $user->fname.' '.$user->lname }}</h3>
        </div>
        <div class="col-sm-6">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="mb-3 mb-xl-0 pr-1">
                    <div class="dropdown">
                    <button class="btn bg-white btn-sm dropdown-toggle btn-icon-text border mr-2" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="typcn typcn-calendar-outline mr-2"></i>Last 7 days
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3" data-x-placement="top-start">
                        <h6 class="dropdown-header">Last 14 days</h6>
                        <a class="dropdown-item" href="#">Last 21 days</a>
                        <a class="dropdown-item" href="#">Last 28 days</a>
                    </div>
                    </div>
                </div>
                <div class="pr-1 mb-3 mr-2 mb-xl-0">
                <button type="button" class="btn btn-sm bg-white btn-icon-text border"><i class="typcn typcn-arrow-forward-outline mr-2"></i>Export</button>
                </div>
                <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-sm bg-white btn-icon-text border"><i class="typcn typcn-info-large-outline mr-2"></i>info</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row mt-3">
        <div class="col-xl-5 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Sessions by Channel</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6">
                        <div id="circleProgress6" class="progressbar-js-circle rounded p-3"></div>
                        </div>
                        <div class="col-lg-6">
                        <ul class="session-by-channel-legend">
                            <li>
                            <div>Firewalls(3)</div>
                            <div>4(100%)</div>
                            </li>
                            <li>
                            <div>Ports(12)</div>
                            <div>12(100%)</div>
                            </li>
                            <li>
                            <div>Servers(233)</div>
                            <div>2(100%)</div>
                            </li>
                            <li>
                            <div>Firewalls(3)</div>
                            <div>7(100%)</div>
                            </li>
                            <li>
                            <div>Firewalls(3)</div>
                            <div>6(70%)</div>
                            </li>
                        </ul>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Events</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="d-flex justify-content-between mb-md-5 mt-3">
                            <div class="small">Critical</div>
                            <div class="text-danger small">Error</div>
                            <div  class="text-warning small">Warning</div>
                        </div>
                        <canvas id="eventChart"></canvas>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Device stats</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="d-flex justify-content-between mb-4">
                            <div>Uptime</div>
                            <div class="text-muted">195 Days, 8 hours</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div>First Seen</div>
                            <div class="text-muted">23 Sep 2019, 2.04PM</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div>Collected time</div>
                            <div class="text-muted">23 Sep 2019, 2.04PM</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div>Memory space</div>
                            <div class="text-muted">168.3GB</div>
                        </div>
                        <div class="progress progress-md mt-4">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row mt-3">
        <div class="col-xl-3 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Sessions by Channel</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="font-weight-medium">Empolyee Name</div>
                            <div class="font-weight-medium">This Month</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Connor Chandler</div>
                            <div class="small">$ 4909</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Russell Floyd</div>
                            <div class="small">$857</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Douglas White</div>
                            <div class="small">$612	</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Alta Fletcher </div>
                            <div class="small">$233</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Marguerite Pearson</div>
                            <div class="small">$233</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Leonard Gutierrez</div>
                            <div class="small">$35</div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-secondary font-weight-medium">Helen Benson</div>
                            <div class="small">$43</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-secondary font-weight-medium">Helen Benson</div>
                            <div class="small">$43</div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Sales Analytics</h4>
                    <button type="button" class="btn btn-sm btn-light">Month</button>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="d-md-flex mb-4">
                        <div class="mr-md-5 mb-4">
                        <h5 class="mb-1"><i class="typcn typcn-globe-outline mr-1"></i>Online</h5>
                        <h2 class="text-primary mb-1 font-weight-bold">23,342</h2>
                        </div>
                        <div class="mr-md-5 mb-4">
                        <h5 class="mb-1"><i class="typcn typcn-archive mr-1"></i>Offline</h5>
                        <h2 class="text-secondary mb-1 font-weight-bold">13,221</h2>
                        </div>
                        <div class="mr-md-5 mb-4">
                        <h5 class="mb-1"><i class="typcn typcn-tags mr-1"></i>Marketing</h5>
                        <h2 class="text-warning mb-1 font-weight-bold">1,542</h2>
                        </div>
                    </div>
                    <canvas id="salesanalyticChart"></canvas>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Card Title</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="mb-5">
                        <div class="mr-1">
                        <div class="text-info mb-1">
                            Total Earning
                        </div>
                        <h2 class="mb-2 mt-2 font-weight-bold">287,493$</h2>
                        <div class="font-weight-bold">
                            1.4%  Since Last Month
                        </div>
                        </div>
                        <hr>
                        <div class="mr-1">
                        <div class="text-info mb-1">
                            Total Earning
                        </div>
                        <h2 class="mb-2 mt-2  font-weight-bold">87,493</h2>
                        <div class="font-weight-bold">
                            5.43%  Since Last Month
                        </div>
                        </div>
                    </div>
                    <canvas id="barChartStacked"></canvas>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">E-Commerce Analytics</h4>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                    <div class="d-sm-flex justify-content-between">
                        <div class="dropdown">
                        <button class="btn bg-white btn-sm dropdown-toggle btn-icon-text pl-0" type="button" id="dropdownMenuSizeButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mon,1 Oct 2019 - Tue,2 Oct 2019
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton4" data-x-placement="top-start">
                            <h6 class="dropdown-header">Mon,17 Oct 2019 - Tue,25 Oct 2019</h6>
                            <a class="dropdown-item" href="#">Tue,18 Oct 2019 - Wed,26 Oct 2019</a>
                            <a class="dropdown-item" href="#">Wed,19 Oct 2019 - Thu,26 Oct 2019</a>
                        </div>
                        </div>
                        <div>
                        <button type="button" class="btn btn-sm btn-light mr-2">Day</button>
                        <button type="button" class="btn btn-sm btn-light mr-2">Week</button>
                        <button type="button" class="btn btn-sm btn-light">Month</button>
                        </div>
                    </div>
                    <div class="chart-container mt-4">
                        <canvas id="ecommerceAnalytic"></canvas>
                    </div>
                    </div>
                    <div class="col-lg-3">
                    <div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="text-success font-weight-bold">Inbound</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Current</div>
                        <div class="text-muted">38.34M</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Average</div>
                        <div class="text-muted">38.34M</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Maximum</div>
                        <div class="text-muted">68.14M</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">60th %</div>
                        <div class="text-muted">168.3GB</div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-3">
                        <div class="text-success font-weight-bold">Outbound</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Current</div>
                        <div class="text-muted">458.77M</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Average</div>
                        <div class="text-muted">1.45K</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                        <div class="font-weight-medium">Maximum</div>
                        <div class="text-muted">15.50K</div>
                        </div>
                        <div class="d-flex justify-content-between">
                        <div class="font-weight-medium">60th %</div>
                        <div class="text-muted">45.5</div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-4 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Booking Analysis Trend</h4>
                    </div>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Booking History</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach($booking_history as $row)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('/fileupload/client/profile').'/'.$row->client_picture }}" alt="profile image">
                                                <div>
                                                    <div> Name</div>
                                                    <div class="font-weight-bold mt-1">{{ $row->client_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Status<br>
                                            <?php
                                                $color = "";
                                                $message = "";
                                                if($row->status == 'Pending') {
                                                    $color = "warning";
                                                    $message = "Pending";
                                                } else if($row->status == 'Approved') {
                                                    $color = "success";
                                                    $message = "Ongoing";
                                                } else if($row->status == 'Completed') {
                                                    $color = "success";
                                                    $message = "Completed";
                                                }else if($row->status == 'Rejected') {
                                                    $color = "danger";
                                                    $message = "Rejected";
                                                } else if($row->status == 'Cancel') {
                                                    $color = "danger";
                                                    $message = "Cancelled";
                                                }
                                            ?>
                                            <span class="badge badge-{{ $color }} p-2 booking_status text-white">
                                                {{ $message }}
                                            </span>
                                        </td>
                                        <td>
                                            Spa
                                            <div class="font-weight-bold mt-1">{{ $row->spa_name }}</div>
                                        </td>
                                        <td>
                                            Services
                                            <div class="font-weight-bold mt-1">{{ $row->services }}</div>
                                        </td>
                                        <td>
                                            Date
                                            <div class="font-weight-bold  mt-1">{{ date("M j, Y",strtotime($row->start_date)) }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face31.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Land Rover</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$12022  </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">70% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">08 Nov 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face32.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Bentley </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$8,725</div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">87% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">11 Jun 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face33.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Morgan </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$5,220 </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">65% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">26 Oct 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face34.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">volkswagen</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$2322 </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success mt-1">88% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">07 Nov 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="pl-5 pr-5 mt-5">
                        {!! $booking_history->appends(request()->query())->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Statistics</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <th>Pending</th>
                            <th>Ongoing</th>
                            <th>Completed</th>
                            <th>Cancelled</th>
                            <th>Total Bookings</th>
                            <th>Booking Date</th>
                            <tbody>
                            @foreach($bookingsCount as $row)
                                <tr>
                                    <td>
                                        {{ $row->Pending }}
                                    </td>
                                    <td>
                                        {{ $row->Ongoing}}
                                    </td>
                                         
                                    <td>
                                        {{ $row->Completed }}
                                    </td>
                                    <td>
                                        {{ $row->Cancel }}
                                    </td>
                                    <td>
                                        {{ $row->Total }}
                                    </td>
                                    <td>
                                        <div 
                                        class="font-weight-bold  mt-1">
                                        {{ date("M j, Y",strtotime($row->start_date)) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face31.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Land Rover</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$12022  </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">70% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">08 Nov 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face32.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Bentley </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$8,725</div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">87% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">11 Jun 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face33.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">Morgan </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$5,220 </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success  mt-1">65% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">26 Oct 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                        <img class="img-sm rounded-circle mb-md-0 mr-2" src="{{ asset('admin/images/faces/face34.png') }}" alt="profile image">
                                        <div>
                                            <div> Company</div>
                                            <div class="font-weight-bold  mt-1">volkswagen</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        Budget
                                        <div class="font-weight-bold  mt-1">$2322 </div>
                                    </td>
                                    <td>
                                        Status
                                        <div class="font-weight-bold text-success mt-1">88% </div>
                                    </td>
                                    <td>
                                        Deadline
                                        <div class="font-weight-bold  mt-1">07 Nov 2019</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary">edit actions</button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div id="chartContainer1" style="height: 400px; width: 100%;"></div>
                </div>
            </div>    
        </div>
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('admin/js/jquery.canvasjs.min.js') }}"></script>
<script>
    window.onload = function() {
        var options = {
            animationEnabled: true,
            // title: {
            //     text: "Booking Traffic Source"
            // },
            data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y})",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "Pending", y: "{{ $bookings['Pending'] ?? 0 }}" },
                        { label: "Cancel", y: "{{ $bookings['Cancel'] ?? 0 }}" },
                        { label: "Ongoing", y: "{{ $bookings['Approved'] ?? 0 }}" },
                        { label: "Rejected", y: "{{ $bookings['Rejected'] ?? 0 }}" },
                        { label: "Completed", y: "{{ $bookings['Completed'] ?? 0 }}" }
                    ]
            }]
        };
        $("#chartContainer").CanvasJSChart(options);


        let datapoints_bookings = [];
        $.each(<?php echo json_encode($linechart)?>, function( index, value ) {
            datapoints_bookings.push({
                x: new Date(value.date),
                y: parseFloat(value.value)
            });
        });
        
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            title:{
                text: "Booking's Comprehensive Overview"
            },
            axisX:{
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                //title: "Closing Price (in PESOS)",
                valueFormatString: "##0",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function(e) {
                        return "" + CanvasJS.formatNumber(e.value, "##0");
                    }
                }
            },
            data: [{
                type: "area",
                xValueFormatString: "DD MMM",
                yValueFormatString: "##0",
                dataPoints: datapoints_bookings
            }]
        });
        chart1.render();
    }
</script>
@endsection
