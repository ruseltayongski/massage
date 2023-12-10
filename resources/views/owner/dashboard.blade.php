@extends('layouts.admin.app_admin')

@section('content')
<?php $user = Auth::user(); ?>
<div class="content-wrapper">
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
                        <h4 class="card-title mb-3">Montly Sales in Bookings</h4>
                    </div>
                    <div id="barChartContainer" style="height: 300px; width: 100%;"></div>
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
                            <th>Rejected</th>
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
                                        {{ $row->Rejected }}
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
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Booking's Comprehensive Overview</h4>
                    </div>
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

        // var options_bar_chart = {
        //     data: [              
        //         {
        //             // Change type to "doughnut", "line", "splineArea", etc.
        //             type: "column",
        //             dataPointWidth: 2,
        //             dataPoints: [
        //                 { label: "Jan",  y: 10  },
        //                 { label: "Feb", y: 15  },
        //                 { label: "Mar", y: 25  },
        //                 { label: "Apr",  y: 30  },
        //                 { label: "May",  y: 28  },
        //                 { label: "Jun",  y: 28  },
        //                 { label: "Jul",  y: 28  },
        //                 { label: "Aug",  y: 28  },
        //                 { label: "Sep",  y: 28  },
        //                 { label: "Oct",  y: 28  },
        //                 { label: "Nov",  y: 28  },
        //                 { label: "Dec",  y: 28  },
        //             ]
        //         }
        //     ]
        // };
        // $("#barChartContainer").CanvasJSChart(options_bar_chart);


        var bar_chart = new CanvasJS.Chart("barChartContainer", {
            animationEnabled: true,
            data: [
                {
                    type: "column",
                    dataPoints: [
                        { label: "Jan",  y: 10  },
                        { label: "Feb",  y: 15  },
                        { label: "Mar",  y: 25  },
                        { label: "Apr",  y: 30  },
                        { label: "May",  y: 28  },
                        { label: "Jun",  y: 28  },
                        { label: "Jul",  y: 28  },
                        { label: "Aug",  y: 28  },
                        { label: "Sep",  y: 28  },
                        { label: "Oct",  y: 28  },
                        { label: "Nov",  y: 28  },
                        { label: "Dec",  y: 28  },
                    ],
                }
            ],
            dataPointWidth: 50,
            axisX: {
                interval: 1,
                //labelAngle: -70 
            },
            axisY: {
                labelFormatter: function (e) {
                    return "₱ " + e.value;  // Add ₱ before the y-axis label
                }
            },
            toolTip: {
                content: "{label}: ₱ {y}"  // Customize the tooltip content
            }
        });
        bar_chart.render();

        
        let datapoints_bookings = [];
        $.each(<?php echo json_encode($linechart)?>, function( index, value ) {
            datapoints_bookings.push({
                x: new Date(value.date),
                y: parseFloat(value.value)
            });
        });
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            // title:{
            //     text: "Booking's Comprehensive Overview"
            // },
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
