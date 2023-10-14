@section('css')
    <style>
         .booking_status {
            cursor: pointer !important;
            color: white;
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
                                        <img src="{{ asset('/fileupload/owner/payment/').'/'.$contract->payment_proof }}" alt="image"/>
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
                                        <a href="{{ route('generate-pdf', ['id' => $contract->id]) }}">
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        $(document).ready(function {

        });
    </script>
@endsection