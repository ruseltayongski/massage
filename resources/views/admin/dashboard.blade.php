@extends('layouts.admin.app_admin')

@section('content')
<?php $user = Auth::user(); ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-3 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Booking Analysis Trend</h4>
                    </div>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Subscribe Analysis Trend</h4>
                    </div>
                    <div id="chartContainerSubscribe" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex grid-margin stretch-card">
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

        var optionsSubscribe = {
            animationEnabled: true,
            data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y})",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "Yearly", y: "{{ $contracts['yearly'] ?? 0 }}" },
                        { label: "Montly", y: "{{ $contracts['monthly'] ?? 0 }}" },
                        { label: "Weekly", y: "{{ $contracts['weekly'] ?? 0 }}" },
                    ]
            }]
        };
        $("#chartContainerSubscribe").CanvasJSChart(optionsSubscribe);


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
