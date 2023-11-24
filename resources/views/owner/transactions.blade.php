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
                    <h4 class="card-title">View Transactions</h4>
                </div>
                <form action="{{ route('owner/transactions') }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary">search</button>
                        <button type="submit" name="reset-button" class="btn btn-outline-info">View All</button>
                    </div>
                </form>
                <div class="table-responsive">
                    @if(!$transactions->isEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Spa</th>
                                <th>Services</th>
                                <th>Book Date</th>
                                <th>Therapist</th>
                               {{--  <th>Completed Date</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="py-1">
                                    {{ $transaction->client_name }}
                                </td>
                                <td>
                                    {{ $transaction->spa_name }}
                                    
                                </td>
                                <td>
                                    {{ $transaction->services_name }}
                                </td>
                                <td>
                                {{ $transaction->start_date }}
                                </td>
                                <td>
                                    {{ $transaction->therapist_name }}
                                </td>
                                {{-- <td>
                                    {{ $transaction->approved_date }}
                                </td> --}}
                                <td>
                                    <?php
                                    $color = "";
                                    $message = "";

                                        if($transaction->status == 'Pending') {
                                                $color = "warning";
                                                $message = "Pending";
                                            } else if($transaction->status == 'Approved') {
                                                $color = "success";
                                                $message = "Ongoing";
                                            } else if($transaction->status == 'Completed') {
                                                $color = "success";
                                                $message = "Completed";
                                            } else if($transaction->status == 'Rejected') {
                                                $color = "danger";
                                                $message = "Rejected";
                                            } else if($transaction->status == 'Cancel') {
                                                $color = "info";
                                                $message = "Cancelled";
                                            }
                                    ?>
                                    <span class="badge badge-{{ $color }} p-2 booking_status text-white">
                                            {{ $message }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else 
                    <h3 class="text-center mt-5">No Transactions Found</h3>
                    @endif
                </div>
            </div>    
            <div class="pl-5 pr-5">
                {!! $transactions->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>


@endsection