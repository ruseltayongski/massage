@section('css')
    <style>
         .booking_status {
            cursor: pointer !important;
            color: white;
        }

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        .modal-picture {
            display: none;
            position: fixed; 
            z-index: 999999999;
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.9); 
        }

        .modal-contents {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-contents {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        #close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        #close:hover,
        #close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px){
            .modal-contents {
                width: 100%;
            }
        }
    </style>
@endsection

@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manage Contract</h4>
                </div>
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary">search</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Signature</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Conctract Type</th>
                                <th>Amount Paid</th>
                                <th>Payment Proof</th>
                                <th>Status</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $contract)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('/fileupload/owner/signature/').'/'.$contract->owner_signature }}" alt="image"/>
                                    </td>
                                    <td>
                                        {{ date("M j, y",strtotime($contract->start_date)) }}
                                    </td>
                                    <td>
                                        {{ date("M j, y",strtotime($contract->end_date)) }}
                                    </td>
                                    <td>
                                        {{ $contract->type }}
                                    </td>
                                    <td>
                                        ₱&nbsp;{{ number_format($contract->amount_paid, 2, '.', ',') }}
                                    </td>
                                    <td class="py-1">
                                        <img 
                                            id="myImg"
                                            class="myImg"
                                            src="{{ asset('/fileupload/owner/payment/').'/'.$contract->payment_proof }}" 
                                            alt="image"
                                         />
                                    </td>
                                    <td>
                                        <?php
                                            $color = "";
                                            if($contract->status == 'Pending') {
                                                $color = "warning";
                                            } else if($contract->status == 'Approved') {
                                                $color = "success";
                                            } else if($contract->status == 'Rejected') {
                                                $color = "danger";
                                            }
                                        ?>
                                        <span class="badge badge-{{ $color }} p-2 booking_status">
                                            {{ $contract->status }}     
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('owner-generate-pdf', ['id' => $contract->id]) }}">
                                            Download
                                        </a>
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
                {!! $contracts->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var modal = $("#myModal");
            var modalImg = $("#img01");
            var images = $(".myImg");

            images.click(function() {
                modal.css("display", "block");
                modalImg.attr("src", $(this).attr("src"));
            });

            var span = $("#close");
            span.click(function() {
                modal.css("display", "none");
            });

            $(document).keydown(function(event) {
                if(event.key === "Escape" && modal.css("display") === "block") {
                    modal.css("display", "none");
                }
            })
        });
    </script>
@endsection